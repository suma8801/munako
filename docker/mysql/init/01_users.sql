-- テーブルのドロップ
--
DROP TABLE IF EXISTS `users`;

--
-- `users` テーブルの作成
--
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'プライマリーキー（自動採番）',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ログイン名（mail)',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名前',
  `yomi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'よみがな',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'パスワードのハッシュ値（NULLはOAuth専用ユーザー）',
  `oauth_provider` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'OAuthプロバイダー識別子（google,line,apple,x,facebook,instagram 等）',
  `oauth_subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'プロバイダー発行のユーザー一意ID（sub 等）',
  `role_id` int NOT NULL COMMENT 'ロールテーブルのid',
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'パスワード忘れのトークン',
  `token_expire` datetime DEFAULT NULL COMMENT 'トークンの期限',
  `created` datetime NOT NULL COMMENT 'ユーザーの利用開始',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_oauth_provider_subject` (`oauth_provider`,`oauth_subject`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ユーザーテーブル';


INSERT INTO `users` (`id`, `email`, `name`, `yomi`, `password`, `role_id`, `token`, `token_expire`, `created`)
VALUES
	(1,'suma8801@gmail.com','松本豊','まつもとゆたか','$2y$10$tiOEKbHuYM71dIx7hOrgteQSrpixSRlsWSs7w1gxM12TrcaJ2KecC',3,NULL,NULL,'2025-09-12 16:44:00');