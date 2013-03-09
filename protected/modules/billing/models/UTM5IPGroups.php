<?php

/**
 * 
 * CREATE  TABLE IF NOT EXISTS `ip_groups` (
 * `id` INT(11) NOT NULL AUTO_INCREMENT ,
 * `ip_group_id` INT(11) NOT NULL ,
 * `ip` INT(11) NOT NULL DEFAULT '0' ,
 * `mask` INT(11) NOT NULL DEFAULT '-1' ,
 * `uname` VARCHAR(255) NOT NULL ,
 * `upass` VARCHAR(255) NOT NULL ,
 * `mac` VARCHAR(255) NOT NULL DEFAULT '' ,
 * `allowed_cid` VARCHAR(255) NOT NULL DEFAULT '' ,
 * `ip_type` INT(11) NOT NULL DEFAULT '0' ,
 * `router_id` INT(11) NOT NULL DEFAULT '0' ,
 * `create_date` INT(11) NOT NULL DEFAULT '0' ,
 * `delete_date` INT(11) NOT NULL DEFAULT '0' ,
 * `is_deleted` INT(11) NOT NULL DEFAULT '0' ,
 * PRIMARY KEY (`id`) )
 * 
 */
class UTM5IPGroups extends UTM5ActiveRecord
{
  
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'ip_groups';
  }
  
  public function getTableSchema()
  {
    $table = parent::getTableSchema();
    $table->columns['ip_group_id']->isForeignKey = true;
    $table->foreignKeys['ip_group_id'] = array('UTM5IPTrafficServiceLinks', 'ip_group_id');
    return $table;
  }
  
  public function relations()
  {
    return array(
      'iptrafficServiceLink' => array(self::BELONGS_TO, 'UTM5IPTrafficServiceLinks', 'ip_group_id'),
    );
  }

  public function findByIP($ip)
  {
		$criteria=$this->getCommandBuilder()->createCriteria('ip = :ip', array(':ip'=>ip2long($ip)));
		return $this->query($criteria);
  }

}

?>
