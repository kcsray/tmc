-- update tmc 
set filbed= (select count(*)  from  tmc_migrants where tmc_migrants.tmc_cd=tmc.id);

--


DROP procedure IF EXISTS `tmc_AdjustFilbed`;

DELIMITER $$
 
CREATE PROCEDURE `tmc_AdjustFilbed` ()
BEGIN
update tmc 
set filbed= (select count(*)  from  tmc_migrants where tmc_migrants.tmc_cd=tmc.id);
END$$

DELIMITER ;


----
DROP procedure IF EXISTS `tmc_AdjExitDate`;

DELIMITER $$
 
CREATE PROCEDURE `tmc_AdjExitDate` ()
BEGIN
UPDATE  tmc_migrants SET exdate=adddate(endate,interval 21 day);
END$$

DELIMITER ;