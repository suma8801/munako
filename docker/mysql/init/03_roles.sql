--
-- テーブルのドロップ
--
DROP TABLE IF EXISTS `roles`;

--
-- `roles` テーブルの作成
--
CREATE TABLE roles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL  COMMENT '役割名(一般、スタッフ、管理者)',
    created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='役割テーブル';

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;

INSERT INTO `roles` (`id`, `name`, `created`)
VALUES
	(1, '一般', '2025-01-01 00:00:00'),
	(2, 'スタッフ', '2025-01-01 00:00:00'),
	(3, '管理者', '2025-01-01 00:00:00');

/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;