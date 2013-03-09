<?php

/**
 * 
 * CREATE  TABLE IF NOT EXISTS `account_tariff_link` (
 * `id` INT(11) NOT NULL AUTO_INCREMENT ,
 * `account_id` INT(11) NOT NULL DEFAULT '0' ,
 * `tariff_id` INT(11) NOT NULL DEFAULT '0' ,
 * `next_tariff_id` INT(11) NOT NULL DEFAULT '0' ,
 * `discount_period_id` INT(11) NOT NULL DEFAULT '0' ,
 * `is_deleted` INT(11) NOT NULL DEFAULT '0' ,
 * `link_date` INT(11) NOT NULL DEFAULT '0' ,
 * PRIMARY KEY (`id`) )
 * 
 */
class UTM5AccountTariffLink extends UTM5ActiveRecord
{

  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'account_tariff_link';
  }
  
  public function relations()
  {
    return array(
      'account' => array(self::BELONGS_TO, 'UTM5Accounts', 'account_id'),
      'tarif' => array(self::BELONGS_TO, 'UTM5Tariffs', 'tariff_id'),
      'serviceLinks' => array(self::HAS_MANY, 'UTM5ServiceLinks', 'tariff_link_id'),
    );
  }

}

?>
