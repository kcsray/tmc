select  tmc_block.bname,sum(tmc.totbed) as capacity,sum(tmc.filbed) as filled ,sum(tmc.totbed) - sum(tmc.filbed) as vacancy
from tmc,tmc_block
where  tmc.bcd =tmc_block.bcode
group by tmc_block.bname

----


select  tmc_block.bname,IFNULL(sum(tmc.totbed),0) as capacity, IFNULL(sum(tmc.filbed),0) as filled ,IFNULL(sum(tmc.totbed),0)- IFNULL(sum(tmc.filbed),0) as vacancy
from  tmc_block 
LEFT JOIN tmc 
ON  tmc_block.bcode = tmc.bcd 
where  tmc_block.type <>'A'
group by tmc_block.bname