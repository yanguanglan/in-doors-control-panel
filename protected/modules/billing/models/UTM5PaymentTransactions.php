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
  
  public function getAllPaymentsSqlDataProvider($userId)
  {
    $user = self::model()->findByPk($userId);
    if($user === null) {
      throw new CHttpException(404, 'The requested user does not exist.');
    }

    // Полубение информации об архивных таблицах
    $table_names = Yii::app()->dbUTM5->createCommand('SELECT * FROM `archives` WHERE `table_type` = 7 ORDER BY `end_date` DESC')->queryAll();

    $main_sql = '
SELECT
  `t`.`id` AS id,
  `m`.`name` AS method,
  `t`.`payment_absolute` AS pay,
  `t`.`payment_incurrency` AS pay_curr,
  `c`.`currency_brief_name` AS curr,
  `t`.`actual_date` AS actual_date,
  `t`.`payment_enter_date` AS enter_date,
  `t`.`comments_for_user` AS user_comment,
  `t`.`comments_for_admins` AS admin_comment,
  `u`.`login` AS who_receive,
  `t`.`burn_time` AS burn_time,
  `t`.`is_canceled` AS canceled
FROM
  `payment_transactions` `t`
  INNER JOIN `accounts` `a` ON `t`.`account_id` = `a`.`id`
  LEFT JOIN `payment_methods` `m` ON `t`.`method` = `m`.`id`
  LEFT JOIN `currency_list` `c` ON `t`.`currency_id` = `c`.`id`
  LEFT JOIN (SELECT `id`, `login` FROM `system_accounts`
             UNION
             SELECT `id`, `login` FROM `users`) `u` ON `t`.`who_receive` = `u`.`id`
WHERE
  `t`.`account_id` = ' . $user->basic_account . '
';
    $sqls = array();
    $sqls[] = $main_sql;
    foreach ($table_names as $table_name) {
      $sqls[] = str_replace('`payment_transactions`', $table_name['table_name'], $main_sql);
    }
    $union = '
UNION
';
    $sql = implode($union, $sqls);
    
    if (Yii::app()->user->name !== "admin") {
      $sql .= ' LIMIT 1';
    }

    //Yii::trace(CVarDumper::dumpAsString($sql));
    $dataProvider = new CSqlDataProvider($sql, array('pagination'=>false,));
    $dataProvider->db = Yii::app()->dbUTM5;
    
    return $dataProvider;

  }
  
}

?>
