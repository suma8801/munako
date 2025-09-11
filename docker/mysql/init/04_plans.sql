DROP TABLE IF EXISTS `plans`;

-- 課金タイプ
CREATE TABLE plans (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,       -- 自動採番 PK
    name VARCHAR(50) NOT NULL comment 'プラン名（無料、ライト、アドバンス）',
    created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP -- 作成日時
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;