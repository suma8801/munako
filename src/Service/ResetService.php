<?php
// src/Service/ResetService.php
namespace App\Service;

use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Datasource\Exception\RecordNotFoundException;

// パスワードリセットサービス
class ResetService
{
    // ユーザーテーブル
    private $usersTable;

    public function __construct()
    {
        $this->usersTable  = TableRegistry::getTableLocator()->get('Users');
    }

    // 引数でもらったユーザにパスワードリセットのメールを送る
    public function sendResetUrl($user): bool
    {
        try {
            // トークンを生成（32文字のランダム文字列）
            $token = bin2hex(random_bytes(16));
            
            // 有効期限を3日後に設定
            $tokenExpire = date('Y-m-d H:i:s', strtotime('+3 days'));
            
            // usersテーブルの該当者にtokenとtoken_expireを保存
            $user->token = $token;
            $user->token_expire = $tokenExpire;
            
            if (!$this->usersTable->save($user)) {
                return false;
            }
            
            // パスワードリセット用のURLを作成
            $url = \Cake\Routing\Router::url([
                'controller' => 'Users',
                'action' => 'resetPassword',
                $token
            ], true);
            
            // メールの件名と本文を作成
            $subject = 'パスワードリセットのお知らせ';
            $content = "{$user->name} 様\n\n";
            $content .= "パスワードリセットのご依頼を承りました。\n\n";
            $content .= "下記のURLをクリックして、新しいパスワードを設定してください。\n";
            $content .= "{$url}\n\n";
            $content .= "※このURLの有効期限は3日間です。\n";
            $content .= "※このメールに心当たりがない場合は、無視してください。\n\n";
            $content .= "---\n";
            $content .= "このメールは自動送信されています。\n";
            
            // メール送信設定
            $mailto = $user->email;
            $mailfrom = "From:steushyd@semotion.xsrv.jp";// 後で修正する
            
            // 文字エンコーディング設定
            mb_language("ja");
            mb_internal_encoding("UTF-8");
            
            // メール送信
            $result = mb_send_mail($mailto, $subject, $content, $mailfrom);
            
            return $result;
            
        } catch (\Exception $e) {
            // エラーログに記録（必要に応じて）
            error_log('Password reset email error: ' . $e->getMessage());
            return false;
        }
    }
}