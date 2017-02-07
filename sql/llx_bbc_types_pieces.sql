-- -----------------------------------------------------
-- Table `mydb`.`fuels`
-- -----------------------------------------------------
DROP TABLE IF EXISTS llx_bbc_types_pieces ;

CREATE  TABLE IF NOT EXISTS `llx_bbc_types_pieces` (
  `rowid` INT NOT NULL AUTO_INCREMENT ,
  `label` LONGTEXT NULL ,
  PRIMARY KEY (`rowid`) )
ENGINE = InnoDB;