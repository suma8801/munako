<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Test\Fixture\UsersFixture;
use App\Test\Fixture\RolesFixture;
use App\Test\Fixture\PlansFixture;
use App\Test\Fixture\CoursesFixture;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\Core\Configure;

/**
 * UsersControllerTest class
 *
 * @uses \App\Controller\UsersController
 */
class UsersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Users',
        'app.Roles',
        'app.Plans',
        'app.Courses',
    ];

    /**
     * Set up method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        Configure::write('debug', true);
    }

    /**
     * Tear down method
     *
     * @return void
     */
    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Test login method - GET request
     *
     * @return void
     */
    public function testLoginGet()
    {
        $this->get('/users/login');
        $this->assertResponseOk();
        $this->assertResponseContains('ログイン');
    }

    /**
     * Test login method - POST request with valid credentials
     *
     * @return void
     */
    public function testLoginPostValidCredentials()
    {
        $this->enableCsrfToken();
        $this->post('/users/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);
        
        // ログイン成功時のリダイレクトを確認
        $this->assertRedirect(['controller' => 'Homes', 'action' => 'regacy']);
    }

    /**
     * Test login method - POST request with invalid credentials
     *
     * @return void
     */
    public function testLoginPostInvalidCredentials()
    {
        $this->enableCsrfToken();
        $this->post('/users/login', [
            'email' => 'invalid@example.com',
            'password' => 'wrongpassword'
        ]);
        
        $this->assertResponseOk();
        $this->assertResponseContains('メールアドレスまたはパスワードが正しくありません');
    }

    /**
     * Test login method - POST request with empty credentials
     *
     * @return void
     */
    public function testLoginPostEmptyCredentials()
    {
        $this->enableCsrfToken();
        $this->post('/users/login', [
            'email' => '',
            'password' => ''
        ]);
        
        $this->assertResponseOk();
        $this->assertResponseContains('メールアドレスまたはパスワードが正しくありません');
    }

    /**
     * Test login method - AJAX request with invalid credentials
     *
     * @return void
     */
    public function testLoginAjaxInvalidCredentials()
    {
        $this->enableCsrfToken();
        $this->configRequest([
            'headers' => ['Accept' => 'application/json']
        ]);
        
        $this->post('/users/login', [
            'email' => 'invalid@example.com',
            'password' => 'wrongpassword'
        ]);
        
        $this->assertResponseCode(401);
        $this->assertResponseContains('ログインに失敗しました');
    }

    /**
     * Test login method - first time login (course_id = 0)
     *
     * @return void
     */
    public function testLoginFirstTime()
    {
        // 初回ログインユーザーを作成
        $this->Users = $this->getTableLocator()->get('Users');
        $user = $this->Users->newEntity([
            'email' => 'firsttime@example.com',
            'password' => 'password123',
            'name' => 'First Time User',
            'role_id' => 1,
            'course_id' => 0
        ]);
        $this->Users->save($user);

        $this->enableCsrfToken();
        $this->post('/users/login', [
            'email' => 'firsttime@example.com',
            'password' => 'password123'
        ]);
        
        $this->assertRedirect(['action' => 'changePassword']);
        $this->assertFlashMessage('初回ログインです。パスワードを変更してください。');
    }

    /**
     * Test logout method
     *
     * @return void
     */
    public function testLogout()
    {
        // ログイン状態をシミュレート
        $this->session(['Auth' => ['User' => ['id' => 1, 'email' => 'test@example.com']]]);
        
        $this->post('/users/logout');
        
        $this->assertRedirect(['controller' => 'Users', 'action' => 'login']);
        $this->assertFlashMessage('ログアウトしました。');
    }

    /**
     * Test register method - GET request
     *
     * @return void
     */
    public function testRegisterGet()
    {
        $this->get('/users/register');
        $this->assertResponseOk();
        $this->assertResponseContains('ユーザー登録');
    }

    /**
     * Test register method - POST request with valid data (first admin)
     *
     * @return void
     */
    public function testRegisterPostFirstAdmin()
    {
        // 管理者が存在しない状態でテスト
        $this->Users = $this->getTableLocator()->get('Users');
        $this->Users->deleteAll([]);
        
        $this->enableCsrfToken();
        $this->post('/users/register', [
            'email' => 'admin@example.com',
            'password' => 'password123',
            'password_confirm' => 'password123',
            'name' => 'Admin User',
            'yomi' => 'アドミンユーザー',
            'role_id' => 3,
            'plane_id' => 1,
            'course_id' => 1
        ]);
        
        $this->assertRedirect(['controller' => 'Users', 'action' => 'login']);
        $this->assertFlashMessage('ユーザー登録が完了しました。');
    }

    /**
     * Test register method - POST request with password mismatch
     *
     * @return void
     */
    public function testRegisterPostPasswordMismatch()
    {
        $this->enableCsrfToken();
        $this->post('/users/register', [
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirm' => 'differentpassword',
            'name' => 'Test User',
            'yomi' => 'テストユーザー',
            'role_id' => 1,
            'plane_id' => 1,
            'course_id' => 1
        ]);
        
        $this->assertResponseOk();
        $this->assertResponseContains('パスワード（確認）が一致しません');
    }

    /**
     * Test register method - POST request with invalid data
     *
     * @return void
     */
    public function testRegisterPostInvalidData()
    {
        $this->enableCsrfToken();
        $this->post('/users/register', [
            'email' => '',
            'password' => '',
            'password_confirm' => '',
            'name' => '',
            'yomi' => '',
            'role_id' => 1,
            'plane_id' => 1,
            'course_id' => 1
        ]);
        
        $this->assertResponseOk();
        $this->assertResponseContains('ユーザー登録に失敗しました');
    }

    /**
     * Test forgotPassword method - GET request
     *
     * @return void
     */
    public function testForgotPasswordGet()
    {
        $this->get('/users/forgot-password');
        $this->assertResponseOk();
        $this->assertResponseContains('パスワードリセット');
    }

    /**
     * Test forgotPassword method - POST request with valid email
     *
     * @return void
     */
    public function testForgotPasswordPostValidEmail()
    {
        // テスト用ユーザーを作成
        $this->Users = $this->getTableLocator()->get('Users');
        $user = $this->Users->newEntity([
            'email' => 'reset@example.com',
            'password' => 'password123',
            'name' => 'Reset User',
            'role_id' => 1,
            'course_id' => 1
        ]);
        $this->Users->save($user);

        $this->enableCsrfToken();
        $this->post('/users/forgot-password', [
            'email' => 'reset@example.com'
        ]);
        
        $this->assertRedirect(['action' => 'login']);
        $this->assertFlashMessage('パスワードリセット用のメールを送信しました。');
    }

    /**
     * Test forgotPassword method - POST request with empty email
     *
     * @return void
     */
    public function testForgotPasswordPostEmptyEmail()
    {
        $this->enableCsrfToken();
        $this->post('/users/forgot-password', [
            'email' => ''
        ]);
        
        $this->assertResponseOk();
        $this->assertResponseContains('メールアドレスを入力してください');
    }

    /**
     * Test forgotPassword method - POST request with non-existent email
     *
     * @return void
     */
    public function testForgotPasswordPostNonExistentEmail()
    {
        $this->enableCsrfToken();
        $this->post('/users/forgot-password', [
            'email' => 'nonexistent@example.com'
        ]);
        
        $this->assertResponseOk();
        $this->assertResponseContains('該当するメールアドレスが見つかりません');
    }

    /**
     * Test profile method - authenticated user
     *
     * @return void
     */
    public function testProfileAuthenticated()
    {
        // ログイン状態をシミュレート
        $this->session(['Auth' => ['User' => [
            'id' => 1,
            'email' => 'test@example.com',
            'name' => 'Test User',
            'course_id' => 1
        ]]]);
        
        $this->get('/users/profile');
        $this->assertResponseOk();
        $this->assertResponseContains('プロフィール');
    }

    /**
     * Test profile method - unauthenticated user
     *
     * @return void
     */
    public function testProfileUnauthenticated()
    {
        $this->get('/users/profile');
        $this->assertRedirect(['controller' => 'Users', 'action' => 'login']);
    }

    /**
     * Test edit method - GET request
     *
     * @return void
     */
    public function testEditGet()
    {
        // ログイン状態をシミュレート
        $this->session(['Auth' => ['User' => [
            'id' => 1,
            'email' => 'test@example.com',
            'name' => 'Test User',
            'course_id' => 1
        ]]]);
        
        $this->get('/users/edit');
        $this->assertResponseOk();
        $this->assertResponseContains('プロフィール編集');
    }

    /**
     * Test edit method - POST request with valid data
     *
     * @return void
     */
    public function testEditPostValidData()
    {
        // ログイン状態をシミュレート
        $this->session(['Auth' => ['User' => [
            'id' => 1,
            'email' => 'test@example.com',
            'name' => 'Test User',
            'course_id' => 1
        ]]]);
        
        $this->enableCsrfToken();
        $this->post('/users/edit', [
            'name' => 'Updated Name',
            'yomi' => 'アップデートネーム'
        ]);
        
        $this->assertRedirect(['action' => 'profile']);
        $this->assertFlashMessage('プロフィールを更新しました。');
    }

    /**
     * Test edit method - POST request with invalid data
     *
     * @return void
     */
    public function testEditPostInvalidData()
    {
        // ログイン状態をシミュレート
        $this->session(['Auth' => ['User' => [
            'id' => 1,
            'email' => 'test@example.com',
            'name' => 'Test User',
            'course_id' => 1
        ]]]);
        
        $this->enableCsrfToken();
        $this->post('/users/edit', [
            'name' => '',
            'yomi' => ''
        ]);
        
        $this->assertResponseOk();
        $this->assertResponseContains('プロフィールの更新に失敗しました');
    }

    /**
     * Test changePassword method - GET request
     *
     * @return void
     */
    public function testChangePasswordGet()
    {
        // ログイン状態をシミュレート
        $this->session(['Auth' => ['User' => [
            'id' => 1,
            'email' => 'test@example.com',
            'name' => 'Test User',
            'course_id' => 1
        ]]]);
        
        $this->get('/users/change-password');
        $this->assertResponseOk();
        $this->assertResponseContains('パスワード変更');
    }

    /**
     * Test changePassword method - POST request with valid data
     *
     * @return void
     */
    public function testChangePasswordPostValidData()
    {
        // ログイン状態をシミュレート
        $this->session(['Auth' => ['User' => [
            'id' => 1,
            'email' => 'test@example.com',
            'name' => 'Test User',
            'course_id' => 1
        ]]]);
        
        $this->enableCsrfToken();
        $this->post('/users/change-password', [
            'current_password' => 'password123',
            'new_password' => 'newpassword123',
            'confirm_password' => 'newpassword123'
        ]);
        
        $this->assertRedirect(['action' => 'profile']);
        $this->assertFlashMessage('パスワードを変更しました。');
    }

    /**
     * Test changePassword method - POST request with course_id = 0 (first time password change)
     *
     * @return void
     */
    public function testChangePasswordPostFirstTime()
    {
        // 初回ログインユーザー（course_id = 0）を作成
        $this->Users = $this->getTableLocator()->get('Users');
        $user = $this->Users->newEntity([
            'email' => 'firsttime@example.com',
            'password' => 'password123',
            'name' => 'First Time User',
            'role_id' => 1,
            'course_id' => 0
        ]);
        $this->Users->save($user);

        // ログイン状態をシミュレート
        $this->session(['Auth' => ['User' => [
            'id' => $user->id,
            'email' => 'firsttime@example.com',
            'name' => 'First Time User',
            'course_id' => 0
        ]]]);
        
        $this->enableCsrfToken();
        $this->post('/users/change-password', [
            'current_password' => 'password123',
            'new_password' => 'newpassword123',
            'confirm_password' => 'newpassword123'
        ]);
        
        $this->assertRedirect(['action' => 'profile']);
        $this->assertFlashMessage('パスワードを変更しました。');
        
        // course_idが1に変更されたことを確認
        $updatedUser = $this->Users->get($user->id);
        $this->assertEquals(1, $updatedUser->course_id);
    }

    /**
     * Test changePassword method - POST request with wrong current password
     *
     * @return void
     */
    public function testChangePasswordPostWrongCurrentPassword()
    {
        // ログイン状態をシミュレート
        $this->session(['Auth' => ['User' => [
            'id' => 1,
            'email' => 'test@example.com',
            'name' => 'Test User',
            'course_id' => 1
        ]]]);
        
        $this->enableCsrfToken();
        $this->post('/users/change-password', [
            'current_password' => 'wrongpassword',
            'new_password' => 'newpassword123',
            'confirm_password' => 'newpassword123'
        ]);
        
        $this->assertResponseOk();
        $this->assertResponseContains('現在のパスワードが正しくありません');
    }

    /**
     * Test changePassword method - POST request with password mismatch
     *
     * @return void
     */
    public function testChangePasswordPostPasswordMismatch()
    {
        // ログイン状態をシミュレート
        $this->session(['Auth' => ['User' => [
            'id' => 1,
            'email' => 'test@example.com',
            'name' => 'Test User',
            'course_id' => 1
        ]]]);
        
        $this->enableCsrfToken();
        $this->post('/users/change-password', [
            'current_password' => 'password123',
            'new_password' => 'newpassword123',
            'confirm_password' => 'differentpassword'
        ]);
        
        $this->assertResponseOk();
        $this->assertResponseContains('新しいパスワードが一致しません');
    }

    /**
     * Test resetPassword method - GET request with valid token
     *
     * @return void
     */
    public function testResetPasswordGetValidToken()
    {
        // 有効なトークンを持つユーザーを作成
        $this->Users = $this->getTableLocator()->get('Users');
        $user = $this->Users->newEntity([
            'email' => 'reset@example.com',
            'password' => 'password123',
            'name' => 'Reset User',
            'role_id' => 1,
            'course_id' => 1,
            'token' => 'valid_token_123',
            'token_expire' => date('Y-m-d H:i:s', strtotime('+1 hour'))
        ]);
        $this->Users->save($user);

        $this->get('/users/reset-password/valid_token_123');
        $this->assertResponseOk();
        $this->assertResponseContains('パスワードリセット');
    }

    /**
     * Test resetPassword method - GET request with invalid token
     *
     * @return void
     */
    public function testResetPasswordGetInvalidToken()
    {
        $this->get('/users/reset-password/invalid_token');
        $this->assertRedirect(['action' => 'login']);
        $this->assertFlashMessage('無効なトークンです。');
    }

    /**
     * Test resetPassword method - POST request with valid token
     *
     * @return void
     */
    public function testResetPasswordPostValidToken()
    {
        // 有効なトークンを持つユーザーを作成
        $this->Users = $this->getTableLocator()->get('Users');
        $user = $this->Users->newEntity([
            'email' => 'reset@example.com',
            'password' => 'password123',
            'name' => 'Reset User',
            'role_id' => 1,
            'course_id' => 1,
            'token' => 'valid_token_123',
            'token_expire' => date('Y-m-d H:i:s', strtotime('+1 hour'))
        ]);
        $this->Users->save($user);

        $this->enableCsrfToken();
        $this->post('/users/reset-password/valid_token_123', [
            'token' => 'valid_token_123',
            'password' => 'newpassword123',
            'confirm_password' => 'newpassword123'
        ]);
        
        $this->assertRedirect(['action' => 'login']);
        $this->assertFlashMessage('パスワードを変更しました。');
    }

    /**
     * Test resetPassword method - POST request with expired token
     *
     * @return void
     */
    public function testResetPasswordPostExpiredToken()
    {
        // 期限切れトークンを持つユーザーを作成
        $this->Users = $this->getTableLocator()->get('Users');
        $user = $this->Users->newEntity([
            'email' => 'reset@example.com',
            'password' => 'password123',
            'name' => 'Reset User',
            'role_id' => 1,
            'course_id' => 1,
            'token' => 'expired_token_123',
            'token_expire' => date('Y-m-d H:i:s', strtotime('-1 hour'))
        ]);
        $this->Users->save($user);

        $this->enableCsrfToken();
        $this->post('/users/reset-password/expired_token_123', [
            'token' => 'expired_token_123',
            'password' => 'newpassword123',
            'confirm_password' => 'newpassword123'
        ]);
        
        $this->assertRedirect(['action' => 'login']);
        $this->assertFlashMessage('トークンの有効期限が切れています。');
    }

    /**
     * Test resetPassword method - POST request with password mismatch
     *
     * @return void
     */
    public function testResetPasswordPostPasswordMismatch()
    {
        // 有効なトークンを持つユーザーを作成
        $this->Users = $this->getTableLocator()->get('Users');
        $user = $this->Users->newEntity([
            'email' => 'reset@example.com',
            'password' => 'password123',
            'name' => 'Reset User',
            'role_id' => 1,
            'course_id' => 1,
            'token' => 'valid_token_123',
            'token_expire' => date('Y-m-d H:i:s', strtotime('+1 hour'))
        ]);
        $this->Users->save($user);

        $this->enableCsrfToken();
        $this->post('/users/reset-password/valid_token_123', [
            'token' => 'valid_token_123',
            'password' => 'newpassword123',
            'confirm_password' => 'differentpassword'
        ]);
        
        $this->assertResponseOk();
        $this->assertResponseContains('新しいパスワードが一致しません');
    }

    /**
     * Test CSRF protection
     *
     * @return void
     */
    public function testCsrfProtection()
    {
        $this->post('/users/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);
        
        $this->assertResponseCode(403);
        $this->assertResponseContains('CSRF');
    }

    /**
     * Test CSRF protection with token
     *
     * @return void
     */
    public function testCsrfProtectionWithToken()
    {
        $this->enableCsrfToken();
        $this->post('/users/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);
        
        $this->assertThat(403, $this->logicalNot($this->equalTo($this->_response->getStatusCode())));
        $this->assertResponseNotContains('CSRF');
    }

    /**
     * Test authentication required for protected actions
     *
     * @return void
     */
    public function testAuthenticationRequired()
    {
        $protectedActions = [
            'profile',
            'edit',
            'changePassword'
        ];

        foreach ($protectedActions as $action) {
            $this->get("/users/{$action}");
            $this->assertRedirect(['controller' => 'Users', 'action' => 'login']);
        }
    }

    /**
     * Test authorization for register action
     *
     * @return void
     */
    public function testRegisterAuthorization()
    {
        // 管理者が存在する状態でテスト
        $this->Users = $this->getTableLocator()->get('Users');
        $admin = $this->Users->newEntity([
            'email' => 'admin@example.com',
            'password' => 'password123',
            'name' => 'Admin User',
            'role_id' => 3,
            'course_id' => 1
        ]);
        $this->Users->save($admin);

        // 未認証ユーザーが登録を試行
        $this->get('/users/register');
        $this->assertRedirect(['action' => 'login']);

        // 一般ユーザー（role_id=1）が登録を試行
        $this->session(['Auth' => ['User' => [
            'id' => 2,
            'email' => 'user@example.com',
            'name' => 'User',
            'role_id' => 1,
            'course_id' => 1
        ]]]);
        
        $this->get('/users/register');
        $this->assertRedirect(['controller' => 'Pages', 'action' => 'home']);
        $this->assertFlashMessage('この操作を行う権限がありません。');
    }
}
