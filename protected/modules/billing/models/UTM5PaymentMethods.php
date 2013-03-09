<?php

/**
 * 
 * CREATE  TABLE IF NOT EXISTS `payment_methods` (
 * `id` INT(11) NOT NULL AUTO_INCREMENT ,
 * `name` VARCHAR(255) NOT NULL ,
 * PRIMARY KEY (`id`) )
 * 
 */
class UTM5PaymentMethods extends UTM5ActiveRecord
{
  
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'payment_methods';
  }
  
  public function relations()
  {
    return array(
      'paymentTransactions' => array(self::HAS_MANY, 'UTM5PaymentTransactions', 'id'),
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
