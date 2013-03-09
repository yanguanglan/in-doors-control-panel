<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class UTM5ActiveRecord extends CActiveRecord
{
  
  public function defaultScope()
  {
    return array(
      'alias' => $this->tableName(),
      'condition' => '`'.$this->tableName().'`.`is_deleted` = 0',
    );
  }
  
  public function getDbConnection()
  {
    return Yii::app()->dbUTM5;
  }

}
?>
