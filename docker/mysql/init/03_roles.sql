--
-- テーブルのドロップ
--
DROP TABLE IF EXISTS `roles`;

--
-- `roles` テーブルの作成
--
CREATE TABLE roles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL  COMMENT '役割名(一般、オペレータ、管理者)',
    created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='役割テーブル';

