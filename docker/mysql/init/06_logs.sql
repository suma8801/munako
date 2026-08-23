--
-- テーブルのドロップ
--
DROP TABLE IF EXISTS `logs`;

--
-- `logs` テーブルの作成
-- 出欠編集画面でメモに「新しく追記した内容」だけを残す履歴。
-- 当時の追記者名は user_name に保存する（ユーザー削除・改名後も履歴を残すため）。
--
CREATE TABLE `logs` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'プライマリーキー（自動採番）',
  `member_id` int NOT NULL COMMENT '対象メンバーID',
  `year` int NOT NULL COMMENT '開催年',
  `user_id` int DEFAULT NULL COMMENT '追記したユーザーID（削除時はNULL）',
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '追記した人の名前（当時）',
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '新しく追記した内容',
  `created` datetime NOT NULL COMMENT '追記日時',
  PRIMARY KEY (`id`),
  KEY `idx_member_year` (`member_id`, `year`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_created` (`created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='メモ追記ログテーブル';
