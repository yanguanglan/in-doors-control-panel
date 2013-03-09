<?php

/**
 * 
 * CREATE  TABLE IF NOT EXISTS `iptraffic_service_links` (
 * `id` INT(11) NOT NULL AUTO_INCREMENT ,
 * `ip_group_id` INT(11) NOT NULL ,
 * `downloaded_id` INT(11) NOT NULL ,
 * `is_deleted` INT(11) NOT NULL DEFAULT '0' ,
 * PRIMARY KEY (`id`) )
 * 
 */
class UTM5IPTrafficServiceLinks extends UTM5ActiveRecord
{
  
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'iptraffic_service_links';
  }
  
  public function relations()
  {
    return array(
      'serviceLink' => array(self::BELONGS_TO, 'UTM5ServiceLinks', 'id'),
      'ipGroups' => array(self::HAS_MANY, 'UTM5IPGroups', 'ip_group_id'),
    );
  }

}

?>
