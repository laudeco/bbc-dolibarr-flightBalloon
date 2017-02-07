
CREATE  TABLE IF NOT EXISTS `llx_bbc_initials` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `fk_id` INT NOT NULL,
  `initval` time NOT NULL,
  `isPilote` int NOT NULL default 1,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;