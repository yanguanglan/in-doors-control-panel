<?php

class BillingUserInfo extends CModel
{

  private $dbUTM5;

  public function __construct()
  {
    $this->dbUTM5 = new CDbConnection('mysql:host=127.0.0.1;dbname=UTM5', 'utm5', 'xVft0EAdC');
    $this->dbUTM5->emulatePrepare        = true;
    $this->dbUTM5->schemaCachingDuration = 3600;
    $this->dbUTM5->charset               = 'utf8';
    $this->dbUTM5->active                = true;
  }

  public function userInfo($id = 0)
  {
    if ($id < 1 || $id === 3 /* ибо нехуй меня просматривать! */) {
      return array();
    }
    $data = $this->dbUTM5->createCommand('
SELECT
  `users`.`id`,
  `users`.`login`,
  `users`.`basic_account`,
  `accounts`.`balance` AS balance,
  `users`.`password`,
  `users`.`full_name`,
  `users`.`actual_address`,
  `users`.`home_telephone`,
  `users`.`mobile_telephone`,
  `users`.`email`,
  FROM_UNIXTIME(`users`.`connect_date`, "%Y.%m.%d") AS conn_date,
  `ip_groups`.`uname` AS uname,
  `ip_groups`.`upass` AS upass
FROM
  `users`
LEFT JOIN
  `accounts` ON (`users`.`basic_account` = `accounts`.`id`
                 AND `accounts`.`is_deleted` = 0)
LEFT JOIN
  `service_links` ON (`accounts`.`id` = `service_links`.`account_id`
                         AND `service_links`.`is_deleted` = 0)
LEFT JOIN
  `iptraffic_service_links` ON (`service_links`.`id` = `iptraffic_service_links`.`id`
                                AND `iptraffic_service_links`.`is_deleted` = 0)
LEFT JOIN
  `ip_groups` ON (`iptraffic_service_links`.`ip_group_id` = `ip_groups`.`ip_group_id`
                  AND `ip_groups`.`is_deleted` = 0)
WHERE
  `users`.`is_deleted` = 0 AND `users`.`id` = '.intval($id).'
')->queryRow();
    return $data;
  }

  public function attributeNames()
  {
    return array(
      'id',
      'login',
      'basic_account',
      'balance',
      'password',
      'full_name',
      'actual_address',
      'home_telephone',
      'mobile_telephone',
      'email',
      'conn_date',
      'uname',
      'upass',
    );
  }

}
