<?php
// src/Service/MemberSearchService.php
namespace App\Service;

use App\Model\Table\MembersTable;
use Cake\ORM\TableRegistry;
use Cake\Datasource\Exception\RecordNotFoundException;

// メンバー検索サービス
class MemberSearchService
{
    // メンバーテーブル
    private $membersTable;

    public function __construct()
    {
        $this->membersTable  = TableRegistry::getTableLocator()->get('Members');
    }

    // メンバーを検索する
    public function searchMembers($param): array
    {
        if( $param == '' ) {
            $results = $this->membersTable->find('all', [
                'conditions' => ['class' => 1 ],
                'order' => 'id asc'
            ]);

            return $results->toArray();
        }  

        // 数字ならば
        if( is_numeric( $param ) ){
            if( $param == -1 ) {
    
                //物故者
                $results = $this->membersTable->find('all', [
                    'conditions' => ['gone' => 1 ],
                    'order' => 'id asc'
                ]);
            } else {
                $results = $this->membersTable->find('all', [
                    'conditions' => ['class' => $param ],
                    'order' => 'id asc'
                ]);
            }
        } else {
            // a クラスの時は、出席者
            if( $param == 'a' ) {
                $results = $this->membersTable->find('all', [
                    'conditions' => ['gone' => '0' ],
                    'order' => 'id asc'
                ]);
    
            } else {
                $results = $this->membersTable->find('all', [
                    'conditions' => [ 'OR' =>
                        [ 'name LIKE' => '%' . $param .'%' , 'yomi LIKE' => '%' . $param .'%' ]
                    ],
                    'order' => 'id asc'
                ]);
            }
        }

        return $results->toArray();
    }
}

                
                