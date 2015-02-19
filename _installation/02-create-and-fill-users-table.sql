CREATE TABLE IF NOT EXISTS `MapDb`.`JofUsers` (
  `UserId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing UserId of each user, unique index',
  `Name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
  `Password_Hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s password in salted and hashed format',
  PRIMARY KEY (`UserId`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';
