-- -----------------------------------------------------
-- Table `mydb`.`baskets`
-- -----------------------------------------------------
DROP TABLE IF EXISTS llx_bbc_baskets ;

CREATE  TABLE IF NOT EXISTS `llx_bbc_baskets` (
  `rowid` INT NOT NULL AUTO_INCREMENT ,
  `manufacturer` VARCHAR(45) NULL ,
  `model` VARCHAR(45) NULL ,
  `serialnumber` VARCHAR(45) NULL ,
  PRIMARY KEY (`rowid`) )
ENGINE = InnoDB;
