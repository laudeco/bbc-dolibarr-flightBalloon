-- -----------------------------------------------------
-- Table `mydb`.`burners`
-- -----------------------------------------------------
DROP TABLE IF EXISTS llx_bbc_burners ;

CREATE  TABLE IF NOT EXISTS `llx_bbc_burners` (
  `rowid` INT NOT NULL AUTO_INCREMENT ,
  `manufacturer` VARCHAR(45) NULL ,
  `model` VARCHAR(45) NULL ,
  `framemodel` VARCHAR(45) NULL ,
  `framenumber` VARCHAR(45) NULL ,
  PRIMARY KEY (`rowid`) )
ENGINE = InnoDB;
