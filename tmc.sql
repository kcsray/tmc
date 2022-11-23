CREATE TABLE  `tmc_block` (
  `bcode` CHAR(4) NOT NULL,
  `bname` VARCHAR(50) NULL,
  `pass` VARCHAR(250) NULL,
  `type` CHAR(1) NULL DEFAULT 'R',
  PRIMARY KEY (`bcode`));


---

CREATE TABLE  `tmc` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `bcd` CHAR(4) NOT NULL,
  `block` VARCHAR(50) NULL,
  `gp` VARCHAR(50) NULL,
  `tmc_name` VARCHAR(150) NOT NULL,
  `totbed` INT NULL DEFAULT 0,
  `filbed` INT NULL DEFAULT 0,
  PRIMARY KEY (`id`));

---

CREATE TABLE  `tmc_migrants` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `mname` VARCHAR(50) NOT NULL,
  `sex` CHAR(1) NULL DEFAULT 'M',
  `age` INT NULL,
  `mobileno` VARCHAR(10) NULL,
  `endate` DATE NOT NULL,
  `exdate` DATE NULL,
  `bcd` CHAR(4) NULL,
  `tmc_cd` INT NOT NULL,
  PRIMARY KEY (`id`));
