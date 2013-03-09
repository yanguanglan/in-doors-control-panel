<?php

/**
 * 
 * CREATE  TABLE IF NOT EXISTS `services_data` (
 * `id` INT(11) NOT NULL AUTO_INCREMENT ,
 * `service_type` INT(11) NOT NULL ,
 * `service_name` VARCHAR(255) NOT NULL ,
 * `comment` VARCHAR(255) NOT NULL ,
 * `is_deleted` INT(11) NOT NULL DEFAULT '0' ,
 * `tariff_id` INT(11) NOT NULL DEFAULT '0' ,
 * `parent_service_id` INT(11) NOT NULL DEFAULT '0' ,
 * `link_by_default` INT(11) NOT NULL DEFAULT '0' ,
 * `is_dynamic` INT(11) NOT NULL DEFAULT '0' ,
 * PRIMARY KEY (`id`) )
 * 
 */
class UTM5ServicesData extends UTM5ActiveRecord
{
  
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'services_data';
  }
  
  public function relations()
  {
    return array(
      'tarifs' => array(self::MANY_MANY, 'UTM5Tariffs', 'tariffs_services_link(service_id,tariff_id)'),
      'serviceLinks' => array(self::HAS_MANY, 'UTM5ServiceLinks', 'service_id'),
    );
  }

}

?>
