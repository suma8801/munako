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
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'パスワードのハッシュ値',
  `role_id` int NOT NULL COMMENT 'ロールテーブルのid',
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'パスワード忘れのトークン',
  `token_expire` datetime DEFAULT NULL COMMENT 'トークンの期限',
  `created` datetime NOT NULL COMMENT 'ユーザーの利用開始',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ユーザーテーブル';
