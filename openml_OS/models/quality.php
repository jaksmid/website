<?php
class Quality extends Database_read {
  
  function __construct() {
    parent::__construct();
    $this->table = 'quality';
    $this->id_column = 'id';
  }
  
  function allUsed() {
    // this query selects only the data qualities that are actually used at least once
    $sql = '
      SELECT `q`.`name`, count(*) AS `number` 
      FROM `quality` `q`, `data_quality` `dq` 
      WHERE `q`.`type`= "DataQuality" 
      AND `q`.`name` = `dq`.`quality` 
      GROUP BY `q`.`name`';
    return $this->query( $sql );
    
  }
}
?>