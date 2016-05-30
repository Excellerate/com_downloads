DROP TABLE IF EXISTS `#__downloads`;
 
CREATE TABLE `#__downloads` (
  `id`       INT(11)     NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(225) NOT NULL,
  `email` VARCHAR(225) NOT NULL,
  `file` VARCHAR(225) NOT NULL,
  `count` tinyint(11) NOT NULL,
  `created_at` tinyint(11) NOT NULL,
  `updated_at` tinyint(11) NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE =MyISAM
  AUTO_INCREMENT =0
  DEFAULT CHARSET =utf8;