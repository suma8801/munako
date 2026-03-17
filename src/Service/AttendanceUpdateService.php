<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Table\AttendStatusesTable;
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

    public function __construct()
    {
        $tableLocator = TableRegistry::getTableLocator();
        $this->membersTable = $tableLocator->get('Members');
        $this->reunionAttendsTable = $tableLocator->get('ReunionAttends');
        $this->attendStatusesTable = $tableLocator->get('AttendStatuses');
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
     * @return array{member: \App\Model\Entity\Member|null, attendStatuses: array, attendance: \App\Model\Entity\ReunionAttend|null}
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

        return [
            'member' => $member,
            'attendStatuses' => $attendStatuses,
            'attendance' => $attendance,
        ];
    }

    /**
     * 出欠状況を保存する（既存は更新、なければ新規作成）
     *
     * @param int $memberId メンバーID
     * @param int $year 開催年
     * @param int|null $attendStatusId 出欠ステータスID（null 可）
     * @param string|null $note メモ
     * @return bool 保存成功時 true
     */
    public function save(int $memberId, int $year, ?int $attendStatusId, ?string $note): bool
    {
        $existingRecord = $this->reunionAttendsTable->find()
            ->where([
                'member_id' => $memberId,
                'year' => $year
            ])
            ->first();

        if ($existingRecord) {
            $existingRecord->attend_status_id = $attendStatusId;
            if ($note !== null) {
                $existingRecord->note = $note;
            }
            return (bool)$this->reunionAttendsTable->save($existingRecord);
        }

        $newRecord = $this->reunionAttendsTable->newEntity([
            'member_id' => $memberId,
            'year' => $year,
            'attend_status_id' => $attendStatusId,
            'note' => $note
        ]);

        return (bool)$this->reunionAttendsTable->save($newRecord);
    }
}
