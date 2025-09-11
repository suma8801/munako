-- 天命、才能、弱みのテーブル
--
-- テーブルのドロップ
--
DROP TABLE IF EXISTS `destiny_results`;

--
-- `destiny_results` テーブルの作成
--
CREATE TABLE `destiny_results` (
  `id` INT NOT NULL  COMMENT 'プライマリーキー',
  `card_title` VARCHAR(255),
  `etitle` VARCHAR(255),
  `card_image` VARCHAR(255),
  `short_text` TEXT,
  `long_text` TEXT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='天命鑑定結果';


--
-- テーブルのドロップ
--
DROP TABLE IF EXISTS `talent_results`;

--
-- `talent_results` テーブルの作成
--
CREATE TABLE `talent_results` (
  `id` INT NOT NULL  COMMENT 'プライマリーキー',
  `card_title` VARCHAR(255),
  `etitle` VARCHAR(255),
  `card_image` VARCHAR(255),
  `short_text` TEXT,
  `long_text` TEXT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='才能鑑定結果';


--
-- テーブルのドロップ
--
DROP TABLE IF EXISTS `weakness_results`;

--
-- `talent_results` テーブルの作成
--
CREATE TABLE `weakness_results` (
  `id` INT NOT NULL COMMENT 'プライマリーキー',
  `card_title` VARCHAR(255),
  `etitle` VARCHAR(255),
  `card_image` VARCHAR(255),
  `short_text` TEXT,
  `long_text` TEXT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='弱み鑑定結果';

