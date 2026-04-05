<?php
declare(strict_types=1);

namespace App\Controller;

use Aporat\OAuth2\Client\Provider\XTwitter;
use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\Http\Session;
use Cake\Log\Log;
use Firebase\JWT\JWT;
use GNOffice\OAuth2\Client\Provider\Line;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\AppleResourceOwner;
use League\OAuth2\Client\Provider\Google;
use League\OAuth2\Client\Provider\Apple;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessTokenInterface;

/**
 * OAuth 2.0 ログイン（Google / Apple / X / LINE）
 *
 * URL 例: /oauth/login/google, /oauth/callback/google
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class OAuthController extends AppController
{
    /** URL スラッグ => Configure の OAuth キー */
    private const PROVIDER_CONFIG_KEYS = [
        'google' => 'Google',
        'apple' => 'Apple',
        'x' => 'X',
        'line' => 'Line',
    ];

    /** DB の oauth_provider に保存する値 */
    private const PROVIDER_DB_KEYS = [
        'google' => 'google',
        'apple' => 'apple',
        'x' => 'x',
        'line' => 'line',
    ];

    public function initialize(): void
    {
        parent::initialize();
        $this->Authentication->allowUnauthenticated(['login', 'callback']);
    }

    /**
     * プロバイダーの認可 URL へリダイレクトする。
     *
     * @param string|null $provider google|apple|x|line
     */
    public function login(?string $provider = null): ?Response
    {
        $this->request->allowMethod(['get']);

        $slug = $this->normalizeProviderSlug($provider);
        if ($slug === null) {
            $this->Flash->error('不明なログイン方式です。');
            return $this->redirect(['controller' => 'Homes', 'action' => 'index']);
        }

        $oauth = Configure::read('OAuth') ?? [];
        $configKey = self::PROVIDER_CONFIG_KEYS[$slug];
        $cfg = $oauth[$configKey] ?? [];

        if (empty($cfg['enabled'])) {
            $this->Flash->error('このログイン方式は現在ご利用いただけません。');
            return $this->redirect(['controller' => 'Homes', 'action' => 'index']);
        }

        try {
            $client = $this->createProvider($slug, $cfg);
        } catch (\InvalidArgumentException $e) {
            Log::warning('OAuth login config: ' . $e->getMessage());
            $this->Flash->error('ログインの準備に失敗しました。設定を確認してください。');
            return $this->redirect(['controller' => 'Homes', 'action' => 'index']);
        }

        $session = $this->request->getSession();
        $authUrl = $client->getAuthorizationUrl();

        $session->write('OAuth.state.' . $slug, $client->getState());

        if ($slug === 'line') {
            $session->write('OAuth.line.nonce', $client->getNonce());
            $pkce = $client->getPkceCode();
            if ($pkce !== null) {
                $session->write('OAuth.line.pkce', $pkce);
            }
        }

        return $this->redirect($authUrl);
    }

    /**
     * プロバイダーからのコールバック（Apple は form_post のため POST あり）。
     *
     * @param string|null $provider google|apple|x|line
     */
    public function callback(?string $provider = null): ?Response
    {
        $this->request->allowMethod(['get', 'post']);
        $this->disableAutoRender();

        $slug = $this->normalizeProviderSlug($provider);
        if ($slug === null) {
            $this->Flash->error('不明なログイン方式です。');
            return $this->redirect(['controller' => 'Homes', 'action' => 'index']);
        }

        $oauth = Configure::read('OAuth') ?? [];
        $configKey = self::PROVIDER_CONFIG_KEYS[$slug];
        $cfg = $oauth[$configKey] ?? [];

        $error = $this->request->getQuery('error') ?? $this->request->getData('error');
        if ($error !== null && $error !== '') {
            $this->clearOAuthSession($slug);
            $this->Flash->error('ログインがキャンセルされたか、エラーが発生しました。');
            return $this->redirect(['controller' => 'Homes', 'action' => 'index']);
        }

        $code = $this->request->getQuery('code') ?? $this->request->getData('code');
        if ($code === null || $code === '') {
            $this->clearOAuthSession($slug);
            $this->Flash->error('認可コードを取得できませんでした。');
            return $this->redirect(['controller' => 'Homes', 'action' => 'index']);
        }

        $state = $this->request->getQuery('state') ?? $this->request->getData('state');
        $session = $this->request->getSession();
        $expectedState = $session->read('OAuth.state.' . $slug);

        if ($state === null || $state === '' || $expectedState === null || !hash_equals((string)$expectedState, (string)$state)) {
            $this->clearOAuthSession($slug);
            $this->Flash->error('セッションが無効です。もう一度お試しください。');
            return $this->redirect(['controller' => 'Homes', 'action' => 'index']);
        }

        // state は使い捨て。LINE はトークン交換まで nonce / PKCE をセッションに残す。
        $session->delete('OAuth.state.' . $slug);

        try {
            $client = $this->createProvider($slug, $cfg);
        } catch (\InvalidArgumentException $e) {
            Log::warning('OAuth callback config: ' . $e->getMessage());
            $this->Flash->error('ログインの処理に失敗しました。');
            return $this->redirect(['controller' => 'Homes', 'action' => 'index']);
        }

        if ($slug === 'apple') {
            JWT::$leeway = 60;
        }

        try {
            $token = $this->exchangeCodeForToken($slug, $client, (string)$code, $session);
        } catch (IdentityProviderException $e) {
            Log::warning('OAuth token: ' . $e->getMessage());
            $this->clearLineOAuthSession();
            $this->Flash->error('外部サービスとの連携に失敗しました。');
            return $this->redirect(['controller' => 'Homes', 'action' => 'index']);
        } catch (\Throwable $e) {
            Log::error('OAuth token: ' . $e->getMessage(), ['exception' => $e]);
            $this->clearLineOAuthSession();
            $this->Flash->error('ログインに失敗しました。');
            return $this->redirect(['controller' => 'Homes', 'action' => 'index']);
        }

        try {
            $owner = $client->getResourceOwner($token);
        } catch (\Throwable $e) {
            Log::error('OAuth resource owner: ' . $e->getMessage(), ['exception' => $e]);
            $this->clearLineOAuthSession();
            $this->Flash->error('ユーザー情報の取得に失敗しました。');
            return $this->redirect(['controller' => 'Homes', 'action' => 'index']);
        }

        $dbProvider = self::PROVIDER_DB_KEYS[$slug];
        $subject = $this->extractSubject($owner);
        if ($subject === null || $subject === '') {
            $this->clearLineOAuthSession();
            $this->Flash->error('ユーザー識別子を取得できませんでした。');
            return $this->redirect(['controller' => 'Homes', 'action' => 'index']);
        }

        $email = $this->extractEmail($slug, $owner, $token, $client, $session);
        $displayName = $this->extractDisplayName($slug, $owner);

        $usersTable = $this->fetchTable('Users');
        $user = $usersTable->find()
            ->where([
                'oauth_provider' => $dbProvider,
                'oauth_subject' => $subject,
            ])
            ->first();

        if ($user === null) {
            if ($email !== null && $email !== '') {
                $existing = $usersTable->findByEmail($email)->first();
                if ($existing !== null) {
                    $this->clearLineOAuthSession();
                    $this->Flash->error(
                        'このメールアドレスは既に登録されています。メール／パスワードでログインしてください。'
                    );
                    return $this->redirect(['controller' => 'Homes', 'action' => 'index']);
                }
            } else {
                $email = $this->synthesizeOAuthEmail($dbProvider, $subject);
            }

            $user = $usersTable->newEmptyEntity();
            $user = $usersTable->patchEntity($user, [
                'email' => $email,
                'password' => null,
                'oauth_provider' => $dbProvider,
                'oauth_subject' => $subject,
                'role_id' => $usersTable::ROLE_ID_GENERAL,
            ], ['validate' => 'default']);

            $user->set('name', $displayName !== '' ? $displayName : __('ユーザー'));
            $user->set('yomi', $displayName !== '' ? $displayName : __('ゆーざー'));
            $usersTable->applyRegisterUserDisplayDefaults($user);

            if (!$usersTable->save($user)) {
                $errors = $user->getErrors();
                Log::warning('OAuth user save failed', ['errors' => $errors]);
                $this->clearLineOAuthSession();
                $this->Flash->error('アカウントの作成に失敗しました。');
                return $this->redirect(['controller' => 'Homes', 'action' => 'index']);
            }
        }

        $this->clearLineOAuthSession();

        $user = $usersTable->get($user->id);
        $this->Authentication->setIdentity($user);
        $this->request->getSession()->write('Auth.loginAsGeneral', true);
        $this->Flash->success('ログインしました。');

        return $this->redirect([
            'controller' => 'Homes',
            'action' => 'regacy',
        ]);
    }

    private function normalizeProviderSlug(?string $provider): ?string
    {
        if ($provider === null) {
            return null;
        }
        $p = strtolower($provider);
        return isset(self::PROVIDER_CONFIG_KEYS[$p]) ? $p : null;
    }

    /**
     * @param \League\OAuth2\Client\Provider\AbstractProvider $client
     */
    private function exchangeCodeForToken(
        string $slug,
        object $client,
        string $code,
        Session $session
    ): AccessTokenInterface {
        $opts = ['code' => $code];

        if ($slug === 'line') {
            $nonce = $session->read('OAuth.line.nonce');
            if ($nonce !== null) {
                $opts['nonce'] = $nonce;
            }
        }

        return $client->getAccessToken('authorization_code', $opts);
    }

    /**
     * @param array<string, mixed> $cfg
     * @return \League\OAuth2\Client\Provider\AbstractProvider
     */
    private function createProvider(string $slug, array $cfg): object
    {
        $clientId = trim((string)($cfg['clientId'] ?? ''));
        $clientSecret = trim((string)($cfg['clientSecret'] ?? ''));
        $redirectUri = trim((string)($cfg['redirectUri'] ?? ''));

        if ($clientId === '' || $redirectUri === '') {
            throw new \InvalidArgumentException('clientId または redirectUri が空です。');
        }

        return match ($slug) {
            'google' => $this->requireSecretAndMakeGoogle($clientId, $clientSecret, $redirectUri),
            'apple' => $this->makeApple($clientId, $clientSecret, $redirectUri, $cfg),
            'x' => $this->requireSecretAndMakeXTwitter($clientId, $clientSecret, $redirectUri),
            'line' => $this->requireSecretAndMakeLine($clientId, $clientSecret, $redirectUri),
            default => throw new \InvalidArgumentException('未対応のプロバイダーです。'),
        };
    }

    private function requireSecretAndMakeGoogle(string $clientId, string $clientSecret, string $redirectUri): Google
    {
        if ($clientSecret === '') {
            throw new \InvalidArgumentException('Google の clientSecret が空です。');
        }

        return new Google([
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'redirectUri' => $redirectUri,
        ]);
    }

    private function requireSecretAndMakeXTwitter(string $clientId, string $clientSecret, string $redirectUri): XTwitter
    {
        if ($clientSecret === '') {
            throw new \InvalidArgumentException('X の clientSecret が空です。');
        }

        return new XTwitter([
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'redirectUri' => $redirectUri,
        ]);
    }

    private function requireSecretAndMakeLine(string $clientId, string $clientSecret, string $redirectUri): Line
    {
        if ($clientSecret === '') {
            throw new \InvalidArgumentException('LINE の clientSecret が空です。');
        }

        return new Line([
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'redirectUri' => $redirectUri,
        ]);
    }

    /**
     * @param array<string, mixed> $cfg
     */
    private function makeApple(string $clientId, string $clientSecret, string $redirectUri, array $cfg): Apple
    {
        $teamId = trim((string)($cfg['teamId'] ?? ''));
        $keyFileId = trim((string)($cfg['keyFileId'] ?? ''));
        $keyFilePath = trim((string)($cfg['keyFilePath'] ?? ''));

        if ($teamId === '' || $keyFileId === '' || $keyFilePath === '') {
            throw new \InvalidArgumentException('Apple の teamId / keyFileId / keyFilePath が未設定です。');
        }
        if (!is_readable($keyFilePath)) {
            throw new \InvalidArgumentException('Apple の秘密鍵ファイルを読み込めません。');
        }

        $options = [
            'clientId' => $clientId,
            'teamId' => $teamId,
            'keyFileId' => $keyFileId,
            'keyFilePath' => $keyFilePath,
            'redirectUri' => $redirectUri,
        ];
        if ($clientSecret !== '') {
            $options['clientSecret'] = $clientSecret;
        }

        return new Apple($options);
    }

    private function extractSubject(ResourceOwnerInterface $owner): ?string
    {
        $id = $owner->getId();
        if ($id === null || $id === '') {
            return null;
        }

        return (string)$id;
    }

    private function extractEmail(
        string $slug,
        ResourceOwnerInterface $owner,
        AccessTokenInterface $token,
        object $client,
        Session $session
    ): ?string {
        if ($slug === 'google' && $owner instanceof GoogleUser) {
            $e = $owner->getEmail();
            return $e !== null && $e !== '' ? $e : null;
        }

        if ($slug === 'apple' && $owner instanceof AppleResourceOwner) {
            $e = $owner->getEmail();
            return $e !== null && $e !== '' ? $e : null;
        }

        if ($slug === 'x') {
            $data = $owner->toArray();
            $confirmed = $data['confirmed_email'] ?? null;
            return is_string($confirmed) && $confirmed !== '' ? $confirmed : null;
        }

        if ($slug === 'line' && $client instanceof Line) {
            $values = $token->getValues();
            $jwt = $values['id_token'] ?? null;
            $nonce = $session->read('OAuth.line.nonce');
            if (is_string($jwt) && $jwt !== '' && is_string($nonce) && $nonce !== '') {
                try {
                    $email = $client->getEmail($jwt, $nonce);
                    return $email !== null && $email !== '' ? $email : null;
                } catch (\Throwable) {
                    return null;
                }
            }
        }

        return null;
    }

    private function extractDisplayName(string $slug, ResourceOwnerInterface $owner): string
    {
        if ($slug === 'google' && $owner instanceof GoogleUser) {
            $n = $owner->getName();
            if (is_string($n) && $n !== '') {
                return mb_substr($n, 0, 255);
            }
            $e = $owner->getEmail();
            if (is_string($e) && str_contains($e, '@')) {
                return mb_substr(explode('@', $e, 2)[0], 0, 255);
            }
        }

        if ($slug === 'apple' && $owner instanceof AppleResourceOwner) {
            $first = $owner->getFirstName() ?? '';
            $last = $owner->getLastName() ?? '';
            $combined = trim($last . ' ' . $first);
            if ($combined !== '') {
                return mb_substr($combined, 0, 255);
            }
            $e = $owner->getEmail();
            if (is_string($e) && str_contains($e, '@')) {
                return mb_substr(explode('@', $e, 2)[0], 0, 255);
            }
        }

        if ($slug === 'x' && method_exists($owner, 'getUsername')) {
            /** @var object{getUsername(): string} $owner */
            $u = $owner->getUsername();
            if (is_string($u) && $u !== '') {
                return mb_substr($u, 0, 255);
            }
        }

        if (method_exists($owner, 'getName')) {
            /** @var object{getName(): ?string} $owner */
            $name = $owner->getName();
            if (is_string($name) && $name !== '') {
                return mb_substr($name, 0, 255);
            }
        }

        return '';
    }

    private function synthesizeOAuthEmail(string $dbProvider, string $subject): string
    {
        $safe = preg_replace('/[^a-zA-Z0-9._-]/', '_', $subject) ?? '';
        if ($safe === '') {
            $safe = bin2hex(random_bytes(8));
        }
        $local = mb_substr($dbProvider . '_' . $safe, 0, 200);

        return $local . '@oauth.local';
    }

    private function clearOAuthSession(string $slug): void
    {
        $session = $this->request->getSession();
        $session->delete('OAuth.state.' . $slug);
        $this->clearLineOAuthSession();
    }

    private function clearLineOAuthSession(): void
    {
        $session = $this->request->getSession();
        $session->delete('OAuth.line.nonce');
        $session->delete('OAuth.line.pkce');
    }
}
