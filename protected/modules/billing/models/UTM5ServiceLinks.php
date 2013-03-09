<?php

/**
 * 
 * CREATE  TABLE IF NOT EXISTS `service_links` (
 * `id` INT(11) NOT NULL AUTO_INCREMENT ,
 * `user_id` INT(11) NOT NULL ,
 * `account_id` INT(11) NOT NULL ,
 * `service_id` INT(11) NOT NULL ,
 * `tariff_link_id` INT(11) NOT NULL ,
 * `is_deleted` INT(11) NOT NULL DEFAULT '0' ,
 * PRIMARY KEY (`id`) )
 * 
 */
class UTM5ServiceLinks extends UTM5ActiveRecord
{
  
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'service_links';
  }
  
  public function relations()
  {
    return array(
      'account' => array(self::BELONGS_TO, 'UTM5Accounts', 'account_id'),
      'user' => array(self::BELONGS_TO, 'UTM5Users', 'user_id'),
      'service' => array(self::BELONGS_TO, 'UTM5ServicesData', 'service_id'),
      'tarifLink' => array(self::BELONGS_TO, 'UTM5AccountTariffLink', 'tariff_link_id'),
      'iptrafficServiceLink' => array(self::HAS_ONE, 'UTM5IPTrafficServiceLinks', 'id'),
    );
  }

}

?>
