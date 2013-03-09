<?php

/**
 * 
 * CREATE  TABLE IF NOT EXISTS `accounts` (
 * `id` INT(11) NOT NULL AUTO_INCREMENT ,
 * `balance` DOUBLE NOT NULL DEFAULT '0' ,
 * `account_name` VARCHAR(255) NOT NULL DEFAULT '' ,
 * `credit` DOUBLE NOT NULL DEFAULT '0' ,
 * `flags` INT(11) NOT NULL DEFAULT '0' ,
 * `is_blocked` INT(11) NOT NULL DEFAULT '0' ,
 * `vat_rate` DOUBLE NOT NULL DEFAULT '0' ,
 * `sale_tax_rate` DOUBLE NOT NULL DEFAULT '0' ,
 * `int_status` INT(11) NOT NULL DEFAULT '0' ,
 * `block_recalc_abon` INT(11) NOT NULL DEFAULT '0' ,
 * `block_recalc_prepaid` INT(11) NOT NULL DEFAULT '0' ,
 * `unlimited` INT(11) NOT NULL DEFAULT '0' ,
 * `is_deleted` INT(11) NOT NULL DEFAULT '0' ,
 * `external_id` VARCHAR(255) NOT NULL DEFAULT '' ,
 * PRIMARY KEY (`id`) )
 *
 */
class UTM5Accounts extends UTM5ActiveRecord
{

  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'accounts';
  }
  
  public function relations()
  {
    return array(
      'user' => array(self::HAS_ONE, 'UTM5Users', 'basic_account'),
      'serviceLinks' => array(self::HAS_MANY, 'UTM5ServiceLinks', 'account_id'),
      'tarifLinks' => array(self::HAS_MANY, 'UTM5AccountTariffLink', 'account_id'),
      'payments' => array(self::HAS_MANY, 'UTM5PaymentTransactions', 'account_id'),
    );
  }

}

?>
