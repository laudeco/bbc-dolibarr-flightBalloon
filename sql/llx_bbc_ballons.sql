
-- -----------------------------------------------------
-- Table `BBC_ballons`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `llx_bbc_ballons` (
  `rowid` INT NOT NULL AUTO_INCREMENT ,
  `immat` VARCHAR(15) NOT NULL ,
  `marraine` VARCHAR(45) NULL ,
  `fk_responsable` INT NULL ,
  `date` DATE NULL ,
  `init_heure` TIME NULL,
  `is_disable` BOOLEAN NOT NULL DEFAULT '0',
  `picture` BLOB NULL,
  PRIMARY KEY (`rowid`, `immat`, `fk_responsable`) )
ENGINE = InnoDB;

