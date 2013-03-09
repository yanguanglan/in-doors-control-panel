<?php

class BillingUser extends CModel
{

  private $dbUTM5;
  private $builder;
  private $criteria;
  
  public function __construct()
  {
    $this->dbUTM5 = new CDbConnection('mysql:host=127.0.0.1;dbname=UTM5', 'utm5', 'xVft0EAdC');
    $this->dbUTM5->emulatePrepare        = true;
    $this->dbUTM5->schemaCachingDuration = 3600;
    $this->dbUTM5->charset               = 'utf8';
    $this->dbUTM5->active                = true;
    $this->builder = $this->dbUTM5->getSchema()->getCommandBuilder();
    $this->criteria = new CDbCriteria(array(
      'select' => 'id, login, full_name, actual_address',
      'condition' => 'is_deleted=0',
    ));
  }

  public function updateCriteria($newLimit, $newOffset)
  {
    $this->criteria->limit = $newLimit;
    $this->criteria->offset = $newOffset;
  }

  public function applyLoginFilter($login = '')
  {
    if (!empty($login)) {
      $this->criteria->condition = $this->criteria->condition.' AND login LIKE "%'.$login.'%"';
    }
  }

  public function applyFullNameFilter($full_name = '')
  {
    if (!empty($full_name)) {
      $this->criteria->condition = $this->criteria->condition.' AND full_name LIKE "%'.$full_name.'%"';
    }
  }

  public function applyActualAddressFilter($actual_address = '')
  {
    if (!empty($actual_address)) {
      $this->criteria->condition = $this->criteria->condition.' AND actual_address LIKE "%'.$actual_address.'%"';
    }
  }

  public function countUsers()
  {
    return $this->builder->createCountCommand('users', $this->criteria)->queryScalar();
  }

  public function userList()
  {
    return $this->builder->createFindCommand('users', $this->criteria)->queryAll();
  }

  public function attributeLabels()
  {
    return array(
      'login' => 'Логин',
      'full_name' => 'Полное имя',
      'actual_address' => 'Фактический адрес',
    );
  }

  public function attributeNames()
  {
    return array(
      'login',
      'full_name',
      'actual_address',
    );
  }


}
