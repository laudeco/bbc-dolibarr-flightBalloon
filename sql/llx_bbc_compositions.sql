-- -----------------------------------------------------
-- Table `mydb`.`compositions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS llx_bbc_compositions ;

CREATE  TABLE IF NOT EXISTS `llx_bbc_compositions` (
  `rowid` INT NOT NULL AUTO_INCREMENT ,
  `fk_balloon` INT NOT NULL ,
  `piece_type` INT NULL ,
  `fk_piece` INT NULL ,
  PRIMARY KEY (`piece_type`, `fk_balloon`, `fk_piece`))
ENGINE = InnoDB;