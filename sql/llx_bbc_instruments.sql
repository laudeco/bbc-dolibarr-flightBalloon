
-- -----------------------------------------------------
-- Table `llx_bbc_instruments`
-- -----------------------------------------------------

DROP TABLE IF EXISTS llx_bbc_instruments ;

CREATE  TABLE IF NOT EXISTS `llx_bbc_instruments` (
  `rowid` INT NOT NULL AUTO_INCREMENT ,
  `manufacturer` VARCHAR(45) NULL ,
  `model` VARCHAR(45) NULL ,
  `serialnumber` VARCHAR(45) NULL ,
  PRIMARY KEY (`rowid`) )
ENGINE = InnoDB;