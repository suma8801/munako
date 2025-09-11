<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use App\Service\ResetService;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
/*
 *  ログイン (/users/login) - メールアドレスとパスワードによる認証
 *  ログアウト (/users/logout) - セッション終了
 *  ユーザー登録 (/users/register) - 新規ユーザー作成
 *  パスワードリセット (/users/forgotPassword) - パスワード忘れ対応
 *  プロフィール表示・編集 (/users/profile, /users/edit) - ユーザー情報管理
 *  パスワード変更 (/users/changePassword) - セキュアなパスワード更新
*/
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        
        // 認証が必要ないアクションを設定（ミドルウェアレベルで処理）
        // この設定は不要です
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        // これらのアクションは未認証でもアクセス可能
        $this->Authentication->allowUnauthenticated(['login', 'register','forgotPassword','resetPassword']);
    }


    /**
     * ログインページを表示
     *
     * @return \Cake\Http\Response|null
     */
    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        
        if ($this->request->is('post')) {

            $result = $this->request->getAttribute('authentication')->getResult();
            
            if ($result->isValid()) {
                // ログイン成功後、ユーザー情報を取得
                $user = $this->Authentication->getIdentity();
                $userData = $user->getOriginalData();
                
                // コースが0に設定されている時はパスワード変更していない
                if ($userData->course_id == 0) {
                    // 初回ログイン時はパスワード変更を促す
                    $this->Flash->warning('初回ログインです。パスワードを変更してください。');
                    return $this->redirect(['action' => 'changePassword']);
                }
                
                // ログイン成功時のリダイレクト先
                $redirect = $this->request->getQuery('redirect', [
                    'controller' => 'Homes',
                    'action' => 'regacy'
                ]);
                
                return $this->redirect($redirect);
            }
            
            if ($this->request->is('ajax') || $this->request->is('json')) {
                $this->response = $this->response->withStatus(401);
                $this->set('error', 'ログインに失敗しました。');
                $this->viewBuilder()->setClassName('Json');
                $this->viewBuilder()->setOption('serialize', ['error']);
                return;
            }
            
            $this->Flash->error('メールアドレスまたはパスワードが正しくありません。');
        }
    }

    /**
     * ログアウト処理
     *
     * @return \Cake\Http\Response
     */
    public function logout(): Response
    {
        $this->request->getAttribute('authentication')->clearIdentity($this->request, $this->response);
        $this->Flash->success('ログアウトしました。');
        
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    /**
     * ユーザー登録ページ
     * (管理者のみ登録可能)
     *
     * @return \Cake\Http\Response|null
     */
    public function register()
    {
        $this->request->allowMethod(['get', 'post']);

        // 既存管理者の有無を確認（role_id=3 を管理者とする）
        $hasAdmin = $this->Users->exists(['role_id' => 3]);

        // 認証必須（ただし、管理者未作成時は未認証でも許可）
        $identity = $this->request->getAttribute('authentication')?->getIdentity();
        if (!$identity && $hasAdmin) {
            return $this->redirect(['action' => 'login']);
        }

        // 権限チェック: オペレータ(2)または管理者(3)のみ（管理者未作成時はスキップ）
        if ($hasAdmin && $identity) {
            $currentUser = $identity->getOriginalData();
            $currentRoleId = $currentUser->role_id ?? null;
            if (!in_array((int)$currentRoleId, [2, 3], true)) {
                $this->Flash->error('この操作を行う権限がありません。');
                return $this->redirect(['controller' => 'Pages', 'action' => 'home']);
            }
        }

        // セレクト用マスタ取得
        $roles = $this->fetchTable('Roles')->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        // 初回登録時は管理者のみ選択可能にする
        if (!$hasAdmin) {
            $roles = array_intersect_key($roles, [3 => true]);
        }
        $plans = $this->fetchTable('Plans')->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $courses = $this->fetchTable('Courses')->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            // 初回登録は強制的に管理者権限に固定
            if (!$hasAdmin) {
                $data['role_id'] = 3;
            }

            // パスワード確認
            if (($data['password'] ?? '') !== ($data['password_confirm'] ?? '')) {
                $this->Flash->error('パスワード（確認）が一致しません。');
            } else {
                $user = $this->Users->newEmptyEntity();
                $user = $this->Users->patchEntity($user, $data);

                if ($this->Users->save($user)) {
                    $this->Flash->success('ユーザー登録が完了しました。');
                    return $this->redirect(['controller' => 'Users', 'action' => 'login']);
                }

                $this->Flash->error('ユーザー登録に失敗しました。入力内容をご確認ください。');
            }
        }

        $this->set(compact('roles', 'plans', 'courses', 'hasAdmin'));
    }

    /**
     * パスワードリセットページ
     * (パスワードを忘れた人が、  パスワードリセット用のメールを送信する)
     * @return \Cake\Http\Response|null
     */
    public function forgotPassword()
    {
        $this->request->allowMethod(['get', 'post']);
        
        if ($this->request->is('post')) {
            $email = $this->request->getData('email');
            
            if (empty($email)) {
                $this->Flash->error('メールアドレスを入力してください。');
                return;
            }
            
            $user = $this->Users->findByEmail($email)->first();
            
            if ($user) {
                // パスワードリセット処理
                $service = new ResetService();
                if ($service->sendResetUrl($user)) {
                    $this->Flash->success('パスワードリセット用のメールを送信しました。');
                    return $this->redirect(['action' => 'login']);
                } else {
                    $this->Flash->error('メールの送信ができませんでした。しばらく時間をおいて再度お試しください。');
                }
            } else {
                $this->Flash->error('該当するメールアドレスが見つかりません。');
            }
        }
    }

    /**
     * ユーザープロフィール表示(作りかけです)
     *
     * @return void
     */
    public function profile()
    {
        $user = $this->request->getAttribute('authentication')->getIdentity()->getOriginalData();
        
        
        $this->set(compact('user'));
    }

    /**
     * ユーザープロフィール編集
     *
     * @return \Cake\Http\Response|null
     */
    public function edit()
    {
        $user = $this->request->getAttribute('authentication')->getIdentity()->getOriginalData();
        $user = $this->Users->get($user->id);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            
            if ($this->Users->save($user)) {
                $this->Flash->success('プロフィールを更新しました。');
                return $this->redirect(['action' => 'profile']);
            }
            
            $this->Flash->error('プロフィールの更新に失敗しました。');
        }
        
        $this->set(compact('user'));
    }

    /**
     * パスワード変更
     *
     * @return \Cake\Http\Response|null
     */
    public function changePassword()
    {
        $user = $this->request->getAttribute('authentication')->getIdentity()->getOriginalData();
        $user = $this->Users->get($user->id);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            
            // 現在のパスワード確認
            if (!$this->Users->verifyPassword($data['current_password'], $user->password)) {
                $this->Flash->error('現在のパスワードが正しくありません。');
                return;
            }
            
            // 新しいパスワードの確認
            if ($data['new_password'] !== $data['confirm_password']) {
                $this->Flash->error('新しいパスワードが一致しません。');
                return;
            }
            
            $user->password = $data['new_password'];
            
            // course_idが0の場合は1に変更（初回パスワード変更完了）
            if ($user->course_id == 0) {
                $user->course_id = 1;
            }
            
            if ($this->Users->save($user)) {
                $this->Flash->success('パスワードを変更しました。');
                return $this->redirect(['controller' => 'homes' ,'action' => 'regacy']);
            }
            
            $this->Flash->error('パスワードの変更に失敗しました。');
        }

        // ユーザ情報をセット
        $this->set(compact('user'));
    }

    /**
     * パスワードのリセット(パスワードを忘れた人)
     *
     * @return \Cake\Http\Response|null
     */
    public function resetPassword($token)
    {
        $this->request->allowMethod(['get', 'post']);
        
        // 新しいパスワードがPOSTされた時
        if ($this->request->is('post')) {

            // トークンとパスワードを取得
            $token = $this->request->getData('token');
            $password = $this->request->getData('password');

            // トークンでユーザーを取得
            $user = $this->Users->findByToken($token)->first();
            
            // トークンがデータベースにあるか？
            if (!$user) {
                $this->Flash->error('無効なトークンです。');
                return $this->redirect(['action' => 'login']);
            }

            // トークンの有効期限が切れているか？
            if ($user->token_expire < date('Y-m-d H:i:s')) {
                $this->Flash->error('トークンの有効期限が切れています。');
                return $this->redirect(['action' => 'login']);
            }

            // 新しいパスワードと確認用パスワードが一致しているか？
            $confirmPassword = $this->request->getData('confirm_password');

            if( $password !== $confirmPassword ){
                $this->Flash->error('新しいパスワードが一致しません。');
                return;
            }

            // 新しいパスワードをハッシュ化して更新
            $user->password = $password;
            $user->token = null;
            $user->token_expire = null;
            
            if( $this->Users->save($user) ){
                $this->Flash->success('パスワードを変更しました。');
                return $this->redirect(['action' => 'login']);
            }

            $this->Flash->error('パスワードの変更に失敗しました。');
            return;
        }

        // 新しいパスワードがPOSTされていない時
        $this->set(compact('token'));
    }
}
