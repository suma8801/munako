<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Table\MembersTable;
use App\Model\Table\ReunionAttendsTable;
use Cake\ORM\TableRegistry;

/**
 * ダッシュボード統計情報サービス
 */
class DashboardStatisticsService
{
    private MembersTable $membersTable;
    private ReunionAttendsTable $reunionAttendsTable;

    public function __construct()
    {
        $tableLocator = TableRegistry::getTableLocator();
        $this->membersTable = $tableLocator->get('Members');
        $this->reunionAttendsTable = $tableLocator->get('ReunionAttends');
    }

    /**
     * ダッシュボードに必要な統計情報をすべて取得
     *
     * @return array
     */
    public function getDashboardStatistics(): array
    {
        return [
            'totalMembers' => $this->getTotalMembers(),
            'deceasedCount' => $this->getDeceasedCount(),
            'aliveCount' => $this->getAliveCount(),
            'attendanceByYear' => $this->getAttendanceByYear(),
            'membersByClass' => $this->getMembersByClass(),
            'deceasedByClass' => $this->getDeceasedByClass(),
            'attendance2023ByClass' => $this->getAttendance2023ByClass(),
            'attendanceNextYearByClass' => $this->getAttendanceByYearByClass((int)NEXT_YEAR),
        ];
    }

    /**
     * 全体の人数を取得
     *
     * @return int
     */
    private function getTotalMembers(): int
    {
        return $this->membersTable->find()->count();
    }

    /**
     * 物故者の人数を取得（gone = 1）
     *
     * @return int
     */
    private function getDeceasedCount(): int
    {
        return $this->membersTable->find()
            ->where(['gone' => 1])
            ->count();
    }

    /**
     * 生存者の人数を取得
     *
     * @return int
     */
    private function getAliveCount(): int
    {
        return $this->membersTable->find()
            ->where(['OR' => [
                'gone IS' => null,
                'gone !=' => 1
            ]])
            ->count();
    }

    /**
     * 開催年ごとの参加者数を取得（性別別）
     *
     * @return array ['years' => [], 'maleCounts' => [], 'femaleCounts' => [], 'totalCounts' => [], 'attendanceByYear' => []]
     */
    private function getAttendanceByYear(): array
    {
        // 開催年のリストを取得
        $yearList = $this->reunionAttendsTable->find()
            ->select(['year' => 'ReunionAttends.year'])
            ->distinct()
            ->orderBy(['ReunionAttends.year' => 'ASC'])
            ->toArray();

        $attendanceByYear = [];
        $years = [];
        $maleCounts = [];
        $femaleCounts = [];
        $totalCounts = [];

        foreach ($yearList as $yearItem) {
            $year = $yearItem->year;

            // その年のユニークなmember_idのリストを取得（全体）
            $uniqueMembers = $this->reunionAttendsTable->find()
                ->select(['member_id'])
                ->where(['ReunionAttends.year' => $year])
                ->distinct()
                ->toArray();
            $uniqueMemberIds = array_column($uniqueMembers, 'member_id');
            $totalCount = count($uniqueMemberIds);

            // 男性の参加者数（sex = 1）
            if (!empty($uniqueMemberIds)) {
                $maleMembers = $this->membersTable->find()
                    ->where([
                        'Members.id IN' => $uniqueMemberIds,
                        'Members.sex' => 1
                    ])
                    ->count();

                // 女性の参加者数（sex = 0）
                $femaleMembers = $this->membersTable->find()
                    ->where([
                        'Members.id IN' => $uniqueMemberIds,
                        'Members.sex' => 0
                    ])
                    ->count();
            } else {
                $maleMembers = 0;
                $femaleMembers = 0;
            }

            $years[] = $year;
            $maleCounts[] = $maleMembers;
            $femaleCounts[] = $femaleMembers;
            $totalCounts[] = $totalCount;
            $attendanceByYear[] = (object)[
                'year' => $year,
                'count' => $totalCount,
                'male' => $maleMembers,
                'female' => $femaleMembers
            ];
        }

        return [
            'years' => $years,
            'maleCounts' => $maleCounts,
            'femaleCounts' => $femaleCounts,
            'totalCounts' => $totalCounts,
            'attendanceByYear' => $attendanceByYear,
        ];
    }

    /**
     * クラス別の人数統計を取得
     *
     * @return array
     */
    private function getMembersByClass(): array
    {
        return $this->membersTable->find()
            ->select([
                'class' => 'Members.class',
                'count' => 'COUNT(Members.id)'
            ])
            ->groupBy('Members.class')
            ->orderBy(['Members.class' => 'ASC'])
            ->toArray();
    }

    /**
     * クラスごとの物故者数を取得
     *
     * @return array
     */
    private function getDeceasedByClass(): array
    {
        return $this->membersTable->find()
            ->select([
                'class' => 'Members.class',
                'count' => 'COUNT(Members.id)'
            ])
            ->where(['gone' => 1])
            ->groupBy('Members.class')
            ->orderBy(['Members.class' => 'ASC'])
            ->toArray();
    }

    /**
     * クラスごとの2023年の出席数を取得
     *
     * @return array<int, int> クラス番号 => 出席数
     */
    private function getAttendance2023ByClass(): array
    {
        return $this->getAttendanceByYearByClass(2023);
    }

    /**
     * 指定年のクラス別出席数を取得
     *
     * @param int $year 開催年
     * @return array<int, int> クラス番号 => 出席数
     */
    private function getAttendanceByYearByClass(int $year): array
    {
        $membersByClass = $this->getMembersByClass();
        $result = [];

        foreach ($membersByClass as $classStat) {
            $class = $classStat->class;
            $classMembers = $this->membersTable->find()
                ->select(['id'])
                ->where(['class' => $class])
                ->toArray();
            $classMemberIds = array_column($classMembers, 'id');

            if ($classMemberIds !== []) {
                $attendedMembers = $this->reunionAttendsTable->find()
                    ->where([
                        'ReunionAttends.year' => $year,
                        'ReunionAttends.member_id IN' => $classMemberIds
                    ])
                    ->select(['member_id'])
                    ->distinct()
                    ->toArray();
                $result[$class] = count($attendedMembers);
            } else {
                $result[$class] = 0;
            }
        }

        return $result;
    }

    /**
     * 指定年の参加者一覧を取得（クラス・番号順）
     *
     * @param int $year 開催年
     * @param string|null $gender 性別で絞り込み 'male' 男性のみ / 'female' 女性のみ / null 全体
     * @return \App\Model\Entity\ReunionAttend[]
     */
    public function getAttendeesByYear(int $year, ?string $gender = null): array
    {
        $query = $this->reunionAttendsTable->find()
            ->where(['ReunionAttends.year' => $year])
            ->contain(['Members', 'AttendStatuses'])
            ->orderBy(['Members.class' => 'ASC', 'Members.no' => 'ASC']);

        if ($gender === 'male') {
            $query->matching('Members', fn($q) => $q->where(['Members.sex' => 1]));
        } elseif ($gender === 'female') {
            $query->matching('Members', fn($q) => $q->where(['Members.sex' => 0]));
        }

        return $query->toArray();
    }
}

