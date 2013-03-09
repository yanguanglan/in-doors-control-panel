<?php

class SearchUserForm extends CFormModel
{
  public $login;
  public $full_name;
  public $actual_address;
  public $ip;
  
  public function rules()
  {
    return array(
      array('login, full_name, actual_address, ip', 'safe'),
    );
  }
  
  public function attributeLabels()
  {
    return array(
      'login' => 'Логин',
      'full_name' => 'Полное имя',
      'actual_address' => 'Фактический адрес',
      'ip' => 'IP адрес',
    );
  }

}

