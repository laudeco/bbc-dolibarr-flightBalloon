
-- -----------------------------------------------------
-- Table `llx_bbc_types_pieces`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `llx_bbc_types_pieces` (
  `idType` INT NOT NULL AUTO_INCREMENT,
  `numero` INT NOT NULL,
  `nom` VARCHAR(20) NULL DEFAULT NULL,
  `active` TINYINT NULL DEFAULT 1,
  PRIMARY KEY (`idType`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `llx_bbc_ballons`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `llx_bbc_ballons` (
  `rowid` INT NOT NULL AUTO_INCREMENT,
  `immat` VARCHAR(15) NOT NULL,
  `marraine` VARCHAR(45) NULL DEFAULT NULL,
  `fk_responsable` INT NULL DEFAULT NULL,
  `date` DATE NULL DEFAULT NULL,
  `init_heure` TIME NULL DEFAULT NULL,
  `is_disable` TINYINT NOT NULL DEFAULT '0',
  `picture` BLOB NULL DEFAULT NULL,
  `fk_co_responsable` INT NULL,
  PRIMARY KEY (`rowid`))
ENGINE = InnoDB;

CREATE UNIQUE INDEX `immat_UNIQUE` ON `llx_bbc_ballons` (`immat` ASC);


-- -----------------------------------------------------
-- Table `llx_bbc_instruments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `llx_bbc_instruments` (
  `rowid` INT NOT NULL AUTO_INCREMENT,
  `manufacturer` VARCHAR(45) NULL DEFAULT NULL,
  `model` VARCHAR(45) NULL DEFAULT NULL,
  `serialnumber` VARCHAR(45) NULL DEFAULT NULL,
  `fk_balloon` INT NOT NULL,
  `fk_type` INT NOT NULL,
  PRIMARY KEY (`rowid`, `fk_balloon`, `fk_type`),
  CONSTRAINT `fk_llx_bbc_instruments_llx_bbc_ballons1`
    FOREIGN KEY (`fk_balloon`)
    REFERENCES `llx_bbc_ballons` (`rowid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_llx_bbc_instruments_llx_bbc_types_pieces1`
    FOREIGN KEY (`fk_type`)
    REFERENCES `llx_bbc_types_pieces` (`idType`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_llx_bbc_instruments_llx_bbc_ballons1_idx` ON `llx_bbc_instruments` (`fk_balloon` ASC);

CREATE INDEX `fk_llx_bbc_instruments_llx_bbc_types_pieces1_idx` ON `llx_bbc_instruments` (`fk_type` ASC);


-- -----------------------------------------------------
-- Table `llx_bbc_fuels`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `llx_bbc_fuels` (
  `rowid` INT NOT NULL AUTO_INCREMENT,
  `manufacturer` LONGTEXT NULL DEFAULT NULL,
  `model` LONGTEXT NULL DEFAULT NULL,
  `serialnumber` LONGTEXT NULL DEFAULT NULL,
  `constructiondate` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`rowid`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `llx_bbc_enveloppes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `llx_bbc_enveloppes` (
  `rowid` INT NOT NULL AUTO_INCREMENT,
  `manufacturer` LONGTEXT NULL DEFAULT NULL,
  `model` VARCHAR(45) NULL DEFAULT NULL,
  `serialnumber` VARCHAR(45) NULL DEFAULT NULL,
  `registration` VARCHAR(45) NULL DEFAULT NULL,
  `fk_balloon` INT NOT NULL,
  PRIMARY KEY (`rowid`, `fk_balloon`),
  CONSTRAINT `fk_llx_bbc_enveloppes_llx_bbc_ballons1`
    FOREIGN KEY (`fk_balloon`)
    REFERENCES `llx_bbc_ballons` (`rowid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_llx_bbc_enveloppes_llx_bbc_ballons1_idx` ON `llx_bbc_enveloppes` (`fk_balloon` ASC);


-- -----------------------------------------------------
-- Table `llx_bbc_burners`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `llx_bbc_burners` ;

CREATE TABLE IF NOT EXISTS `llx_bbc_burners` (
  `rowid` INT NOT NULL AUTO_INCREMENT,
  `manufacturer` VARCHAR(45) NULL DEFAULT NULL,
  `model` VARCHAR(45) NULL DEFAULT NULL,
  `framemodel` VARCHAR(45) NULL DEFAULT NULL,
  `framenumber` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`rowid`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `llx_bbc_burners_sn`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `llx_bbc_burners_sn` (
  `rowid` INT NOT NULL AUTO_INCREMENT,
  `serialnumber` VARCHAR(45) NULL DEFAULT NULL,
  `fk_burner` INT NOT NULL,
  PRIMARY KEY (`rowid`, `fk_burner`),
  CONSTRAINT `fk_llx_bbc_burners_sn_llx_bbc_burners1`
    FOREIGN KEY (`fk_burner`)
    REFERENCES `llx_bbc_burners` (`rowid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_llx_bbc_burners_sn_llx_bbc_burners1_idx` ON `llx_bbc_burners_sn` (`fk_burner` ASC);


-- -----------------------------------------------------
-- Table `llx_bbc_baskets`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `llx_bbc_baskets` (
  `rowid` INT NOT NULL AUTO_INCREMENT,
  `manufacturer` VARCHAR(45) NULL DEFAULT NULL,
  `model` VARCHAR(45) NULL DEFAULT NULL,
  `serialnumber` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`rowid`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `llx_bbc_basket_balloon`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `llx_bbc_basket_balloon` (
  `fk_basket` INT NOT NULL,
  `fk_balloon` INT NOT NULL,
  PRIMARY KEY (`fk_basket`, `fk_balloon`),
  CONSTRAINT `fk_llx_bbc_baskets_has_llx_bbc_ballons_llx_bbc_baskets`
    FOREIGN KEY (`fk_basket`)
    REFERENCES `llx_bbc_baskets` (`rowid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_llx_bbc_baskets_has_llx_bbc_ballons_llx_bbc_ballons1`
    FOREIGN KEY (`fk_balloon`)
    REFERENCES `llx_bbc_ballons` (`rowid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_llx_bbc_baskets_has_llx_bbc_ballons_llx_bbc_ballons1_idx` ON `llx_bbc_basket_balloon` (`fk_balloon` ASC);

CREATE INDEX `fk_llx_bbc_baskets_has_llx_bbc_ballons_llx_bbc_baskets_idx` ON `llx_bbc_basket_balloon` (`fk_basket` ASC);


-- -----------------------------------------------------
-- Table `llx_bbc_burner_balloon`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `llx_bbc_burner_balloon` (
  `fk_balloon` INT NOT NULL,
  `fk_burner` INT NOT NULL,
  PRIMARY KEY (`fk_balloon`, `fk_burner`),
  CONSTRAINT `fk_llx_bbc_ballons_has_llx_bbc_burners_llx_bbc_ballons1`
    FOREIGN KEY (`fk_balloon`)
    REFERENCES `llx_bbc_ballons` (`rowid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_llx_bbc_ballons_has_llx_bbc_burners_llx_bbc_burners1`
    FOREIGN KEY (`fk_burner`)
    REFERENCES `llx_bbc_burners` (`rowid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_llx_bbc_ballons_has_llx_bbc_burners_llx_bbc_burners1_idx` ON `llx_bbc_burner_balloon` (`fk_burner` ASC);

CREATE INDEX `fk_llx_bbc_ballons_has_llx_bbc_burners_llx_bbc_ballons1_idx` ON `llx_bbc_burner_balloon` (`fk_balloon` ASC);


-- -----------------------------------------------------
-- Table `llx_bbc_fuels_balloons`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `llx_bbc_fuels_balloons` (
  `fk_balloon` INT NOT NULL,
  `fk_fuel` INT NOT NULL,
  PRIMARY KEY (`fk_balloon`, `fk_fuel`),
  CONSTRAINT `fk_llx_bbc_ballons_has_llx_bbc_fuels_llx_bbc_ballons1`
    FOREIGN KEY (`fk_balloon`)
    REFERENCES `llx_bbc_ballons` (`rowid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_llx_bbc_ballons_has_llx_bbc_fuels_llx_bbc_fuels1`
    FOREIGN KEY (`fk_fuel`)
    REFERENCES `llx_bbc_fuels` (`rowid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_llx_bbc_ballons_has_llx_bbc_fuels_llx_bbc_fuels1_idx` ON `llx_bbc_fuels_balloons` (`fk_fuel` ASC);

CREATE INDEX `fk_llx_bbc_ballons_has_llx_bbc_fuels_llx_bbc_ballons1_idx` ON `llx_bbc_fuels_balloons` (`fk_balloon` ASC);
