<?php
// src/Service/MemberSearchService.php
namespace App\Service;

use App\Model\Table\MembersTable;
use Cake\ORM\TableRegistry;

// メンバー検索サービス
class MemberSearchService
{
    // メンバーテーブル
    private MembersTable $membersTable;

    public function __construct()
    {
        $this->membersTable = TableRegistry::getTableLocator()->get('Members');
    }

    // メンバーを検索する
    public function searchMembers($param): array
    {
        $query = $this->membersTable->find()
            ->orderBy(['Members.id' => 'ASC'])
            ->contain(['ReunionAttends']);

        if ($param === '') {
            $query->where(['class' => 1]);

            return $query->toArray();
        }

        // 数字ならば
        if (is_numeric($param)) {
            if ($param == -1) {
                // 物故者
                $query->where(['gone' => 1]);
            } else {
                $query->where(['class' => $param]);
            }
        } else {
            // a クラスの時は、出席者
            if ($param === 'a') {
                $query->where(['gone' => '0']);
            } else {
                $query->where([
                    'OR' => [
                        'name LIKE' => '%' . $param . '%',
                        'yomi LIKE' => '%' . $param . '%',
                    ],
                ]);
            }
        }

        return $query->toArray();
    }
}
