<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');

        //全コントローラで認証を有効に
        $this->loadComponent('Authentication.Authentication');
        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        // 全コントローラ共通で「未認証はデフォルト禁止」
        $this->Authentication->addUnauthenticatedActions([]);
    }

    public function beforeRender(
        \Cake\Event\EventInterface $event
    ): void {
        parent::beforeRender($event);

        $identity = $this->request->getAttribute('authentication')?->getIdentity();
        $this->set('effectiveRoleId', $this->getEffectiveRoleId());
        if ($identity) {
            $this->viewBuilder()->setLayout('logged_in');
            $this->set('currentUser', $identity->getOriginalData());
        } else {
            $this->viewBuilder()->setLayout('logged_out');
            // テンプレートの empty($currentUser) を確実に true にする（未設定のままだと環境差で誤判定しうる）
            $this->set('currentUser', null);
        }
    }

    /**
     * 実効ロールIDを返す。一般ログイン（loginUser）で入った場合は常に 1（一般）。
     *
     * @return int|null ログインしていなければ null
     */
    protected function getEffectiveRoleId(): ?int
    {
        if ($this->request->getSession()->read('Auth.loginAsGeneral')) {
            return 1;
        }
        $identity = $this->request->getAttribute('authentication')?->getIdentity();
        if ($identity === null) {
            return null;
        }
        $user = $identity->getOriginalData();
        return (int)($user->role_id ?? 0) ?: null;
    }

    /**
     * OAuth ログイン・新規登録用（有効かつ最低限の設定が揃ったプロバイダーのみ）
     *
     * @return list<array{slug: string, buttonText: string}>
     */
    protected function buildOauthLoginProviders(): array
    {
        $oauth = Configure::read('OAuth') ?? [];
        $defs = [
            ['key' => 'Google', 'slug' => 'google', 'buttonText' => __('Googleでログイン')],
            ['key' => 'Facebook', 'slug' => 'facebook', 'buttonText' => __('Facebookでログイン')],
            ['key' => 'X', 'slug' => 'x', 'buttonText' => __('Xでログイン')],
            ['key' => 'Line', 'slug' => 'line', 'buttonText' => __('LINEでログイン')],
        ];
        $out = [];
        foreach ($defs as $row) {
            $cfg = $oauth[$row['key']] ?? [];
            if (empty($cfg['enabled']) || !$this->isOauthProviderConfigured($row['key'], $cfg)) {
                continue;
            }
            $out[] = [
                'slug' => $row['slug'],
                'buttonText' => $row['buttonText'],
            ];
        }

        return $out;
    }

    /**
     * @param array<string, mixed> $cfg
     */
    protected function isOauthProviderConfigured(string $configKey, array $cfg): bool
    {
        $clientId = trim((string)($cfg['clientId'] ?? ''));
        $redirectUri = trim((string)($cfg['redirectUri'] ?? ''));
        if ($clientId === '' || $redirectUri === '') {
            return false;
        }

        return match ($configKey) {
            'Google', 'Facebook', 'X', 'Line' => trim((string)($cfg['clientSecret'] ?? '')) !== '',
            default => false,
        };
    }
}
