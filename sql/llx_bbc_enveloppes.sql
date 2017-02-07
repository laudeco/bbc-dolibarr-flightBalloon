-- -----------------------------------------------------
-- Table `mydb`.`enveloppes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS llx_bbc_enveloppes ;

CREATE  TABLE IF NOT EXISTS `llx_bbc_enveloppes` (
  `rowid` INT NOT NULL AUTO_INCREMENT ,
  `manufacturer` LONGTEXT NULL ,
  `model` VARCHAR(45) NULL ,
  `serialnumber` VARCHAR(45) NULL ,
  `registration` VARCHAR(45) NULL ,
  PRIMARY KEY (`rowid`) )
ENGINE = InnoDB;