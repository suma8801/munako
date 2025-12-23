--
-- テーブルのドロップ
--
DROP TABLE IF EXISTS `attend_statuses`;

--
-- `attend_statuses` テーブルの作成
--
CREATE TABLE `attend_statuses` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'プライマリーキー（自動採番）',
  `name` varchar(100) NOT NULL COMMENT 'ステータス名',
  `created` datetime NOT NULL COMMENT '作成日時',
  `modified` datetime NOT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='出欠ステータステーブル';

LOCK TABLES `attend_statuses` WRITE;
/*!40000 ALTER TABLE `attend_statuses` DISABLE KEYS */;

INSERT INTO `attend_statuses` (`id`, `name`, `created`, `modified`)
VALUES
  (1, '出席', '2025-01-01 00:00:00', '2025-01-01 00:00:00'),
  (2, '欠席', '2025-01-01 00:00:00', '2025-01-01 00:00:00'),
  (3, '連絡先不明', '2025-01-01 00:00:00', '2025-01-01 00:00:00'),
  (4, '連絡拒否', '2025-01-01 00:00:00', '2025-01-01 00:00:00'),
  (5, '死亡', '2025-01-01 00:00:00', '2025-01-01 00:00:00');

/*!40000 ALTER TABLE `attend_statuses` ENABLE KEYS */;
UNLOCK TABLES;


