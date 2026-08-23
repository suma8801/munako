<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Table\AttendStatusesTable;
use App\Model\Table\LogsTable;
use App\Model\Table\MembersTable;
use App\Model\Table\ReunionAttendsTable;
use Cake\ORM\TableRegistry;

/**
 * 出欠状況の取得・保存を行うサービス
 */
class AttendanceUpdateService
{
    private MembersTable $membersTable;

    private ReunionAttendsTable $reunionAttendsTable;

    private AttendStatusesTable $attendStatusesTable;

    private LogsTable $logsTable;

    public function __construct()
    {
        $tableLocator = TableRegistry::getTableLocator();
        $this->membersTable = $tableLocator->get('Members');
        $this->reunionAttendsTable = $tableLocator->get('ReunionAttends');
        $this->attendStatusesTable = $tableLocator->get('AttendStatuses');
        $this->logsTable = $tableLocator->get('Logs');
    }

    /**
     * クラス別出欠一覧用のデータを取得
     *
     * @param int $class クラス番号
     * @param int $year 開催年
     * @return array{members: array, attendStatuses: array, attendances: array}
     */
    public function getClassAttendanceData(int $class, int $year): array
    {
        $members = $this->membersTable->find()
            ->where(['class' => $class])
            ->orderBy(['no' => 'ASC'])
            ->toArray();

        $attendStatuses = $this->attendStatusesTable->find()
            ->orderBy(['id' => 'ASC'])
            ->toArray();

        $memberIds = array_column($members, 'id');
        $attendances = [];
        if ($memberIds !== []) {
            $records = $this->reunionAttendsTable->find()
                ->where([
                    'member_id IN' => $memberIds,
                    'year' => $year
                ])
                ->contain(['AttendStatuses'])
                ->toArray();
            foreach ($records as $record) {
                $attendances[$record->member_id] = $record;
            }
        }

        return [
            'members' => $members,
            'attendStatuses' => $attendStatuses,
            'attendances' => $attendances,
        ];
    }

    /**
     * 個別出欠編集画面用のデータを取得
     *
     * @param int $memberId メンバーID
     * @param int $class クラス番号（メンバー検証用）
     * @param int $year 開催年
     * @return array{member: \App\Model\Entity\Member|null, attendStatuses: array, attendance: \App\Model\Entity\ReunionAttend|null, noteLogs: array}
     */
    public function getEditAttendanceData(int $memberId, int $class, int $year): array
    {
        $member = null;
        try {
            $entity = $this->membersTable->get($memberId);
            if ($entity->class == $class) {
                $member = $entity;
            }
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            // member は null のまま
        }

        $attendStatuses = $this->attendStatusesTable->find()
            ->orderBy(['id' => 'ASC'])
            ->toArray();

        $attendance = $this->reunionAttendsTable->find()
            ->where([
                'member_id' => $memberId,
                'year' => $year
            ])
            ->contain(['AttendStatuses'])
            ->first();

        $noteLogs = [];
        if ($member !== null) {
            $noteLogs = $this->logsTable->find()
                ->where([
                    'member_id' => $memberId,
                    'year' => $year,
                ])
                ->orderBy(['created' => 'DESC', 'id' => 'DESC'])
                ->toArray();
        }

        return [
            'member' => $member,
            'attendStatuses' => $attendStatuses,
            'attendance' => $attendance,
            'noteLogs' => $noteLogs,
        ];
    }

    /**
     * 出欠状況を保存する（既存は更新、なければ新規作成）。
     * メモが末尾追記された場合のみ logs に追記内容を残す。
     *
     * @param int $memberId メンバーID
     * @param int $year 開催年
     * @param int|null $attendStatusId 出欠ステータスID（null 可）
     * @param string|null $note メモ
     * @param int|null $userId 追記したユーザーID
     * @param string|null $userName 追記した人の名前
     * @return bool 保存成功時 true
     */
    public function save(
        int $memberId,
        int $year,
        ?int $attendStatusId,
        ?string $note,
        ?int $userId = null,
        ?string $userName = null
    ): bool {
        $connection = $this->reunionAttendsTable->getConnection();

        return (bool)$connection->transactional(function () use (
            $memberId,
            $year,
            $attendStatusId,
            $note,
            $userId,
            $userName
        ) {
            $existingRecord = $this->reunionAttendsTable->find()
                ->where([
                    'member_id' => $memberId,
                    'year' => $year
                ])
                ->first();

            $oldNote = $existingRecord !== null ? (string)($existingRecord->note ?? '') : '';

            if ($existingRecord) {
                $existingRecord->attend_status_id = $attendStatusId;
                if ($note !== null) {
                    $existingRecord->note = $note;
                }
                if (!$this->reunionAttendsTable->save($existingRecord)) {
                    return false;
                }
            } else {
                $newRecord = $this->reunionAttendsTable->newEntity([
                    'member_id' => $memberId,
                    'year' => $year,
                    'attend_status_id' => $attendStatusId,
                    'note' => $note
                ]);
                if (!$this->reunionAttendsTable->save($newRecord)) {
                    return false;
                }
            }

            $newNote = $note !== null ? $note : $oldNote;
            $appended = $this->extractAppendedNote($oldNote, $newNote);
            if ($appended === null) {
                return true;
            }

            $name = trim((string)$userName);
            $log = $this->logsTable->newEntity([
                'member_id' => $memberId,
                'year' => $year,
                'user_id' => $userId,
                'user_name' => $name !== '' ? $name : '不明',
                'body' => $appended,
            ]);

            return (bool)$this->logsTable->save($log);
        });
    }

    /**
     * 新しいメモから「末尾に追記された部分」だけを取り出す。
     * 既存メモの途中編集・置き換えは追記とみなさない。
     *
     * @return string|null 追記内容。追記がなければ null
     */
    private function extractAppendedNote(string $oldNote, string $newNote): ?string
    {
        $oldNormalized = str_replace(["\r\n", "\r"], "\n", $oldNote);
        $newNormalized = str_replace(["\r\n", "\r"], "\n", $newNote);

        if ($newNormalized === $oldNormalized) {
            return null;
        }
        if ($oldNormalized === '') {
            return trim($newNormalized) === '' ? null : $newNormalized;
        }
        if (!str_starts_with($newNormalized, $oldNormalized)) {
            return null;
        }

        $appended = substr($newNormalized, strlen($oldNormalized));
        $appended = preg_replace('/^\n/', '', $appended) ?? $appended;
        if (trim($appended) === '') {
            return null;
        }

        return $appended;
    }
}
