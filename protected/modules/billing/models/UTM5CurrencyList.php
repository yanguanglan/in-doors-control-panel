<?php

/**
 * 
 * CREATE  TABLE IF NOT EXISTS `currency_list` (
 * `id` INT(11) NOT NULL AUTO_INCREMENT ,
 * `currency_brief_name` VARCHAR(255) NOT NULL ,
 * `currency_full_name` VARCHAR(255) NOT NULL ,
 * `percent` DOUBLE NOT NULL DEFAULT '0' ,
 * `is_deleted` INT(11) NOT NULL DEFAULT '0' ,
 * PRIMARY KEY (`id`) )
 * 
 */
class UTM5CurrencyList extends UTM5ActiveRecord
{
  
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'currency_list';
  }
  
  public function relations()
  {
    return array(
      'paymentTransactions' => array(self::HAS_MANY, 'UTM5PaymentTransactions', 'id'),
    );
  }

}
?>
