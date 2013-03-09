<?php

/**
 * 
 * CREATE  TABLE IF NOT EXISTS `tariffs` (
 * `id` INT(11) NOT NULL AUTO_INCREMENT ,
 * `name` VARCHAR(255) NOT NULL ,
 * `create_date` INT(11) NOT NULL DEFAULT '0' ,
 * `change_date` INT(11) NOT NULL DEFAULT '0' ,
 * `who_change` INT(11) NOT NULL DEFAULT '0' ,
 * `who_create` INT(11) NOT NULL DEFAULT '0' ,
 * `expire_date` INT(11) NOT NULL DEFAULT '0' ,
 * `balance_rollover` INT(11) NOT NULL DEFAULT '0' ,
 * `is_deleted` INT(11) NOT NULL DEFAULT '0' ,
 * `comments` VARCHAR(255) NOT NULL DEFAULT '' )
 * 
 */
class UTM5Tariffs extends UTM5ActiveRecord
{
  
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'tariffs';
  }
  
  public function relations()
  {
    return array(
      'accountTariffLinks' => array(self::HAS_MANY, 'UTM5AccountTariffLink', 'tariff_id'),
      'services' => array(self::MANY_MANY, 'UTM5ServicesData', 'tariffs_services_link(tariff_id,service_id)'),
    );
  }

}

?>
