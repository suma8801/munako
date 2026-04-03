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
        if ($identity) {
            $this->viewBuilder()->setLayout('logged_in');
        } else {
            $this->viewBuilder()->setLayout('logged_out');
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
}
