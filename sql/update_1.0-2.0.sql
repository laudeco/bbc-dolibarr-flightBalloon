-- Create new structure
  CREATE TABLE `llx_bbc_interventions` (
    `rowid` INT(11) NOT NULL AUTO_INCREMENT,
    `uuid` BINARY(16) NOT NULL,
    `intervention_date` DATETIME NOT NULL,
    `author` INT(11) NOT NULL,
    `supervised_by` INT(11),
    `material_id` INT(11) NOT NULL,
    `comment` TEXT,
    `request_number` VARCHAR(50),
    PRIMARY KEY(rowid),
    CONSTRAINT unq_uuid UNIQUE (uuid)
  );

  CREATE TABLE `llx_bbc_manufacturers` (
    `rowid` INT(11) NOT NULL AUTO_INCREMENT,
    `uuid` BINARY(16) NOT NULL,
    `name` VARCHAR(50) NOT NULL,
    `supplier_id` INT(11) NOT NULL,
    PRIMARY KEY(rowid),
    CONSTRAINT unq_uuid UNIQUE (uuid),
    CONSTRAINT unq_name UNIQUE (name)
  );

  CREATE TABLE `llx_bbc_material` (
    `rowid` INT(11) NOT NULL AUTO_INCREMENT,
    `balloon_id` INT(11),
    `burner_id` INT(11),
    `tank_id` INT(11),
    `basket_id` INT(11),
    PRIMARY KEY(rowid),
    CONSTRAINT unq_material UNIQUE (balloon_id, burner_id, tank_id, basket_id),
    CONSTRAINT chk_material CHECK (
      (
        balloon_id IS NOT NULL
        AND burner_id IS NULL
        AND tank_id IS NULL
        AND basket_id IS NULL
      )
      OR
      (
        balloon_id IS NULL
        AND burner_id IS NOT NULL
        AND tank_id IS NULL
        AND basket_id IS NULL
      )
      OR
      (
        balloon_id IS NULL
        AND burner_id IS NULL
        AND tank_id IS NOT NULL
        AND basket_id IS NULL
      )
      OR
      (
        balloon_id IS NULL
        AND burner_id IS NULL
        AND tank_id IS NULL
        AND basket_id IS NOT NULL
      )
    )
  );

  CREATE TABLE `llx_bbc_balloon_events` (
    `rowid` INT(11) AUTO_INCREMENT,
    `uuid` BINARY(16) NOT NULL,
    `field` VARCHAR(20) NOT NULL,
    `new_value` TEXT,
    `old_value` TEXT,
    `material_id` INT(11) NOT NULL,
    `user_id` INT(11) NOT NULL,
    `type` ENUM('UPD', 'DEL', 'INS') NOT NULL DEFAULT 'UPD',
    `comment` TEXT,
    `label` VARCHAR(100),
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY(uuid)
  );

  CREATE TABLE `llx_bbc_balloons` (
    `rowid` INT(11) NOT NULL,
    `immat` VARCHAR(10) NOT NULL,
    `uuid` BINARY(16) NOT NULL,
    `model` VARCHAR(30),
    `buying_date` DATE NOT NULL DEFAULT '1999-01-01',
    `flight_time` INT UNSIGNED DEFAULT 0 COMMENT 'Flight time in min',
    `weight` SMALLINT UNSIGNED DEFAULT 0,
    `marraine` VARCHAR(45),
    `sponsored` TINYINT(1) NOT NULL DEFAULT 0,
    `out_reason_id` INT(11),
    `manufacturer_id` INT(11) NOT NULL,
    `created_by` INT(11) NOT NULL,
    `created_at` DATETIME NOT NULL,
    PRIMARY KEY(rowid),
    CONSTRAINT unq_uuid UNIQUE (uuid),
    CONSTRAINT unq_immat UNIQUE (immat, buying_date)
  );

  CREATE TABLE `llx_bbc_burners` (
    `rowid` INT(11) NOT NULL AUTO_INCREMENT,
    `uuid` BINARY(16) NOT NULL,
    `model` VARCHAR(30),
    `manufacturer_id` INT(11) NOT NULL,
    `buying_date` DATE NOT NULL DEFAULT '1999-01-01',
    `flight_time` INT UNSIGNED DEFAULT 0 COMMENT 'Flight time in min',
    `comment` TEXT,
    `serial` VARCHAR(50),
    `weight` SMALLINT UNSIGNED DEFAULT 0,
    `out_reason_id` INT(11),
    `manufacturer_id` INT(11) NOT NULL,
    `created_by` INT(11) NOT NULL,
    `created_at` DATETIME NOT NULL,
    PRIMARY KEY(rowid),
    CONSTRAINT unq_uuid UNIQUE (uuid),
    CONSTRAINT unq_serial UNIQUE (`serial`)
  );

  CREATE TABLE `llx_bbc_baskets` (
    `rowid` INT(11) NOT NULL AUTO_INCREMENT,
    `uuid` BINARY(16) NOT NULL,
    `serial_number` VARCHAR(50),
    `model` VARCHAR(30),
    `buying_date` DATE NOT NULL DEFAULT '1999-01-01',
    `weight` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    `flight_time` INT UNSIGNED DEFAULT 0 COMMENT 'Flight time in min',
    `comment` TEXT,
    `name` VARCHAR(100),
    `easy_access` TINYINT(1) NOT NULL DEFAULT 0,
    `out_reason_id` INT(11),
    `manufacturer_id` INT(11) NOT NULL,
    `created_by` INT(11) NOT NULL,
    `created_at` DATETIME NOT NULL,
    PRIMARY KEY(rowid),
    CONSTRAINT unq_serial UNIQUE (serial_number),
    CONSTRAINT unq_uuid UNIQUE (uuid)
  );

  CREATE TABLE `llx_bbc_tanks` (
    `rowid` INT(11) NOT NULL AUTO_INCREMENT,
    `uuid` BINARY(16),
    `serial` VARCHAR(50),
    `buying_date` DATE NOT NULL DEFAULT '1999-01-01',
    `capacity` TINYINT UNSIGNED DEFAULT 0,
    `manufacturer_id` INT(11) NOT NULL,
    `weight` SMALLINT UNSIGNED DEFAULT 0,
    `last_inspection_date` DATE,
    `next_inspection_date` DATE,
    `out_reason_id` INT(11),
    `created_by` INT(11) NOT NULL,
    `created_at` DATETIME NOT NULL,
    PRIMARY KEY(rowid),
    CONSTRAINT unq_serial UNIQUE (`serial`),
    CONSTRAINT unq_uuid UNIQUE (uuid)
  );

  CREATE TABLE `llx_bbc_responsibles` (
    `type` ENUM('RESPONSIBLE', 'BACK-UP RESPONSIBLE') NOT NULL,
    `configuration_id` INT(11) NOT NULL,
    `user_id` INT(11),
    PRIMARY KEY(configuration_id, user_id),
    CONSTRAINT unq_role UNIQUE (type, configuration_id)
  );

  CREATE TABLE `llx_bbc_reasons` (
    `rowid` INT(11) NOT NULL,
    `uuid` BINARY(16) NOT NULL,
    `label` VARCHAR(100) NOT NULL ,
    `description` VARCHAR(255) NOT NULL DEFAULT '',
    `enabled` TINYINT(1 ) NOT NULL DEFAULT 1,
    `type` ENUM('CONFIG', 'MATERIAL', 'ALL') NOT NULL,
    PRIMARY KEY(rowid),
    CONSTRAINT unq_reason UNIQUE (type, label),
    CONSTRAINT unq_uuid UNIQUE(uuid)
  );

  CREATE TABLE `llx_bbc_configurations` (
    `rowid` INT(11) NOT NULL,
    `uuid` BINARY(16),
    `balloon_id` INT(11) NOT NULL,
    `burner_id` INT(11) NOT NULL,
    `flight_time` INT UNSIGNED DEFAULT 0 COMMENT 'Flight time in min',
    `basket_id` INT(11) NOT NULL,
    `label` VARCHAR(100),
    `disabled_at` DATETIME,
    `disabled_comment` VARCHAR(255),
    `disabled_by` INT(11),
    `created_by` INT(11) NOT NULL,
    `created_at` DATETIME NOT NULL,
    PRIMARY KEY(rowid),
    CONSTRAINT unq_uuid UNIQUE (UUID),
    CONSTRAINT unq_configuration UNIQUE (balloon_id, basket_id, burner_id)
  );

  CREATE TABLE `llx_bbc_configuration_tanks` (
    `configuration_id` INT(11) NOT NULL,
    `tank_id` INT(11) NOT NULL,
    PRIMARY KEY(configuration_id, tank_id)
  );

  -- Insert Already present Data
  INSERT INTO llx_bbc_manufacturers (rowid, uuid, name, supplier_id) VALUES
    (1, (UNHEX(REPLACE(UUID(), "-",""))), 'Cameron', 73),
    (2, (UNHEX(REPLACE(UUID(), "-",""))), 'Libert', 80),
    (3, (UNHEX(REPLACE(UUID(), "-",""))), 'Ultra magic', 75);

  INSERT INTO llx_bbc_reasons (rowid, uuid, label, description, enabled, type) VALUES
    (1, (UNHEX(REPLACE(UUID(), "-",""))), 'Vente', 'Materiel vendu', 1, 'MATERIAL'),
    (2, (UNHEX(REPLACE(UUID(), "-",""))), 'Declasse', 'Materiel a ete declasse', 1, 'MATERIAL'),
    (3, (UNHEX(REPLACE(UUID(), "-",""))), 'Permie', 'Materiel perime', 1, 'MATERIAL');

  INSERT INTO llx_bbc_balloons (rowid, immat, uuid, model, buying_date, flight_time, weight, marraine, sponsored, out_reason_id, manufacturer_id, created_by, created_at)
    SELECT
      bal.rowid as rowid,
      bal.immat as immat,
      (UNHEX(REPLACE(UUID(), "-",""))) as uuid,
      '' as model,
      IFNULL(bal.date, NOW()) as buying_date,
      0 as flight_time,
      0 as weight,
      IFNULL(bal.marraine, '') as marraine,
      1 as sponsored,
      IF(bal.is_disable = 1, 2, NULL) as out_reason_id,
      2, -- libert
      2 as created_by, -- laurent
      NOW() as created_at
    FROM
      llx_bbc_ballons as bal
    ORDER BY bal.is_disable DESC, bal.immat ASC;

  INSERT INTO llx_bbc_material (balloon_id)
    SELECT
      bal.rowid
    FROM llx_bbc_balloons AS bal;

  INSERT INTO llx_bbc_configurations (rowid, uuid, balloon_id, burner_id, flight_time, basket_id, label, disabled_at, disabled_by, disabled_comment, created_at, created_by)
    SELECT
      bal.rowid as rowid
      (UNHEX(REPLACE(UUID(), "-",""))) as uuid,
      bal.rowid as balloon_id,
      0 as burner_id,
      0 as flight_time,
      0 as basket_id,
      '' as label,
      IF(bal.is_disable = 1, NOW(), NULL) as disabled_at,
      IF(bal.is_disable = 1, 2, NULL) as disabled_by,
      IF(bal.is_disable = 1, 'Import script', NULL) as disabled_comment,
      2 as created_by,
      NOW() as created_at
    FROM
      llx_bbc_ballons as bal
    ORDER BY bal.is_disable DESC, bal.immat ASC;

  INSERT INTO llx_bbc_responsibles (type, configuration_id, user_id)
    SELECT
      'RESPONSIBLE',
      bal.rowid as configuration_id,
      bal.fk_responsable as user_id
    FROM
      llx_bbc_ballons as bal
    ORDER BY bal.is_disable DESC, bal.immat ASC;

  INSERT INTO llx_bbc_responsibles (type, configuration_id, user_id)
    SELECT
      'BACK-UP RESPONSIBLE',
      bal.rowid as configuration_id,
      bal.fk_co_responsable as user_id
    FROM
      llx_bbc_ballons as bal
    ORDER BY bal.is_disable DESC, bal.immat ASC;

  -- Remove old data
  DROP TABLE llx_bbc_ballons;
  DROP TABLE llx_BBC_ballons;
  DROP TABLE llx_BBC_burners;
  DROP TABLE llx_bbc_burners;
  DROP TABLE llx_bbc_baskets;
  DROP TABLE llx_BBC_baskets;
  DROP TABLE llx_BBC_burners_sn;
  DROP TABLE llx_bbc_burners_sn;
  DROP TABLE llx_BBC_enveloppes;
  DROP TABLE llx_bbc_enveloppes;
  DROP TABLE llx_bbc_fuels;
  DROP TABLE llx_BBC_fuels;
  DROP TABLE llx_bbc_types_pieces;
  DROP TABLE llx_BBC_types_pieces;

  CREATE VIEW llx_bbc_ballons AS
    SELECT
      config.rowid as rowid,
      balloon.immat as immat,
      balloon.marraine as marraine,
      SEC_TO_TIME(balloon.flight_time*60) as init_heure,
      balloon.buying_date as date,
      NULL as picture,
      IF(config.disabled_at IS NULL, 0, 1) as is_disabled,
      IF(config.disabled_at IS NULL, 0, 1) as is_disable,
      bc_responsible.user_id as fk_co_responsable,
      responsible.user_id as fk_responsable

    FROM
      llx_bbc_configurations as config
      INNER JOIN llx_bbc_balloons as balloon
        ON balloon.rowid = config.balloon_id
      INNER JOIN llx_bbc_responsibles as responsible
        ON responsible.configuration_id = config.rowid
        AND responsible.type = 'RESPONSIBLE'
      INNER JOIN llx_bbc_responsibles as bc_responsible
        ON bc_responsible.configuration_id = config.rowid
        AND bc_responsible.type = 'BACK-UP RESPONSIBLE';