
-- -----------------------------------------------------
-- Table `mydb`.`burners_serialnumber`
-- -----------------------------------------------------
DROP TABLE IF EXISTS llx_bbc_burners_sn ;

CREATE  TABLE IF NOT EXISTS `llx_bbc_burners_sn` (
  `rowid` INT NOT NULL AUTO_INCREMENT ,
  `burners_rowid` INT NOT NULL ,
  `serialnumber` VARCHAR(45) NULL ,
  PRIMARY KEY (`rowid`, `burners_rowid`))
ENGINE = InnoDB;