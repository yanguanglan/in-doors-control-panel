<?php

/**
 * 
 * CREATE  TABLE IF NOT EXISTS `payment_transactions` (
 * `id` INT(11) NOT NULL AUTO_INCREMENT ,
 * `account_id` INT(11) NOT NULL DEFAULT '0' ,
 * `payment_incurrency` DOUBLE NOT NULL DEFAULT '0' ,
 * `currency_id` INT(11) NOT NULL DEFAULT '0' ,
 * `currency_rate` DOUBLE NOT NULL DEFAULT '0' ,
 * `payment_absolute` DOUBLE NOT NULL DEFAULT '0' ,
 * `actual_date` INT(11) NOT NULL DEFAULT '0' ,
 * `payment_enter_date` INT(11) NOT NULL DEFAULT '0' ,
 * `payment_ext_number` VARCHAR(255) NULL DEFAULT '' ,
 * `method` INT(11) NOT NULL DEFAULT '0' ,
 * `who_receive` INT(11) NOT NULL DEFAULT '0' ,
 * `comments_for_user` VARCHAR(255) NULL DEFAULT '' ,
 * `comments_for_admins` VARCHAR(255) NULL DEFAULT '' ,
 * `burn_time` INT(11) NOT NULL DEFAULT '0' ,
 * `is_canceled` INT(11) NOT NULL DEFAULT '0' ,
 * `cancel_id` INT(11) NOT NULL DEFAULT '0' ,
 * `hash` VARCHAR(255) NOT NULL DEFAULT '' ,
 * `charge_id` INT(11) NOT NULL DEFAULT '0' ,
 * `ic_status` INT(11) NOT NULL DEFAULT '0' ,
 * `ic_id` VARCHAR(255) NOT NULL DEFAULT '' ,
 * `last_sync_date` INT(11) NOT NULL DEFAULT '0' ,
 * PRIMARY KEY (`id`) )
 * 
 */
class UTM5PaymentTransactions extends UTM5ActiveRecord
{
  
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'payment_transactions';
  }
  
  public function relations()
  {
    return array(
      'account' => array(self::BELONGS_TO, 'UTM5Accounts', 'account_id'),
      'paymentMethod' => array(self::BELONGS_TO, 'UTM5PaymentMethods', 'method'),
      'currency' => array(self::BELONGS_TO, 'UTM5CurrencyList', 'currency_id'),
    );
  }

  public function defaultScope()
  {
    return array(
      'alias' => $this->tableName(),
      'condition' => '',
    );
  }
  
}

?>
