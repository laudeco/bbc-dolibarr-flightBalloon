-- -----------------------------------------------------
-- Table `mydb`.`fuels`
-- -----------------------------------------------------
DROP TABLE IF EXISTS llx_bbc_fuels ;

CREATE  TABLE IF NOT EXISTS `llx_bbc_fuels` (
  `rowid` INT NOT NULL AUTO_INCREMENT ,
  `manufacturer` LONGTEXT NULL ,
  `model` LONGTEXT NULL ,
  `serialnumber` LONGTEXT NULL ,
  `constructiondate` DATE NULL ,
  PRIMARY KEY (`rowid`) )
ENGINE = InnoDB;