<?php

/**
 * 
 * CREATE  TABLE IF NOT EXISTS `users` (
 * `id` INT(11) NOT NULL AUTO_INCREMENT ,
 * `login` VARCHAR(255) NOT NULL ,
 * `password` VARCHAR(255) NOT NULL DEFAULT '' ,
 * `basic_account` INT(11) NOT NULL ,
 * `advance_payment` INT(11) NOT NULL DEFAULT '0' ,
 * `create_date` INT(11) NOT NULL DEFAULT '0' ,
 * `last_change_date` INT(11) NOT NULL DEFAULT '0' ,
 * `who_create` INT(11) NOT NULL DEFAULT '0' ,
 * `who_change` INT(11) NOT NULL DEFAULT '0' ,
 * `is_juridical` INT(11) NOT NULL DEFAULT '0' ,
 * `full_name` TEXT NULL DEFAULT NULL ,
 * `juridical_address` TEXT NULL DEFAULT NULL ,
 * `actual_address` TEXT NULL DEFAULT NULL ,
 * `work_telephone` VARCHAR(255) NOT NULL DEFAULT '' ,
 * `home_telephone` VARCHAR(255) NOT NULL DEFAULT '' ,
 * `mobile_telephone` VARCHAR(255) NOT NULL DEFAULT '' ,
 * `web_page` VARCHAR(255) NOT NULL DEFAULT '' ,
 * `icq_number` VARCHAR(255) NOT NULL DEFAULT '' ,
 * `tax_number` VARCHAR(255) NOT NULL DEFAULT '' ,
 * `kpp_number` VARCHAR(255) NOT NULL DEFAULT '' ,
 * `bank_id` INT(11) NOT NULL DEFAULT '0' ,
 * `bank_account` VARCHAR(255) NOT NULL DEFAULT '' ,
 * `email` VARCHAR(255) NOT NULL DEFAULT '' ,
 * `house_id` INT(11) NOT NULL DEFAULT '0' ,
 * `flat_number` VARCHAR(255) NOT NULL DEFAULT '' ,
 * `entrance` VARCHAR(255) NOT NULL DEFAULT '' ,
 * `floor` VARCHAR(255) NOT NULL DEFAULT '' ,
 * `district` VARCHAR(255) NOT NULL DEFAULT '' ,
 * `building` VARCHAR(255) NOT NULL DEFAULT '' ,
 * `passport` VARCHAR(255) NOT NULL DEFAULT '' ,
 * `comments` TEXT NULL DEFAULT NULL ,
 * `personal_manager` VARCHAR(255) NOT NULL DEFAULT '' ,
 * `connect_date` INT(11) NOT NULL DEFAULT '0' ,
 * `remote_switch_id` INT(11) NOT NULL DEFAULT '0' ,
 * `port_number` INT(11) NOT NULL DEFAULT '0' ,
 * `binded_currency_code` INT(11) NOT NULL DEFAULT '810' ,
 * `is_deleted` INT(11) NOT NULL DEFAULT '0' ,
 * `is_send_invoice` INT(11) NOT NULL DEFAULT '0' ,
 * `ic_status` INT(11) NOT NULL DEFAULT '0' ,
 * `ic_id` VARCHAR(255) NOT NULL DEFAULT '' ,
 * `last_sync_date` INT(11) NOT NULL DEFAULT '0' )
 * 
 */
class UTM5Users extends UTM5ActiveRecord
{

  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'users';
  }
  
  public function relations()
  {
    return array(
      'basicAccount' => array(self::BELONGS_TO, 'UTM5Accounts', 'basic_account'),
      'serviceLinks' => array(self::HAS_MANY, 'UTM5ServiceLinks', 'user_id'),
    );
  }

}

?>
