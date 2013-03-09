<?php

/*
Таблица обслуживается сценарием самописным сценарием chatlog.lua

USE `verlihub`;
CREATE TABLE `log_mainchat` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ip` int(10) NOT NULL DEFAULT '0',
  `nick` varchar(255) NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `msg` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8
*/

class Hub extends CActiveRecord
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'log_mainchat';
	}

  public function getDbConnection()
  {
    if (self::$db !== null) {
      return self::$db;
    }
    else {
      self::$db = new CDbConnection('mysql:host=127.0.0.1;dbname=verlihub', 'verlihub', '5wPfJl9HT');
      self::$db->emulatePrepare        = true;
      self::$db->schemaCachingDuration = 3600;
      self::$db->charset               = 'utf8';
      //self::$db->enableProfiling       = true;
      //self::$db->enableParamLogging    = true;
      self::$db->active                = true;
      if (self::$db instanceof CDbConnection) {
        return self::$db;
      }
      else {
        throw new CDbException(Yii::t('yii','Hub::getDbConnection(): failed connect to verlihub database.'));
      }
    }
  }

	public function rules()
	{
		return array(
//      array('ip', 'match', 'pattern' => '((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(\.|$)){4}'),
      array('date', 'date', 'on' => 'search'),
			array('ip, nick, msg', 'safe', 'on' => 'search'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id'   => 'ID',
			'ip'   => 'IP адрес',
			'nick' => 'Ник',
			'date' => 'Дата',
      'msg'  => 'Сообщение',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria(array(
//      'select' => '`id`,INET_NTOA(`ip` & 0xFFFFFFFF) AS ip,`nick`,FROM_UNIXTIME(`date`, "%Y.%m.%d_%H:%m") AS date,`msg`',
      'order'  => 'date DESC',
    ));

    if (!empty($this->ip)) {
      $ip = ip2long($this->ip);
      if ($ip) {
		    $criteria->compare('ip', $ip);
      }
    }
		$criteria->addSearchCondition('nick', $this->nick);
    if (!empty($this->date)) {
      $unixDate = strtotime($this->date);
		  $criteria->addBetweenCondition('date', $unixDate, $unixDate + 86400);
    }
		$criteria->addSearchCondition('msg', $this->msg);

		return new CActiveDataProvider($this, array(
      'criteria' => $criteria,
      'pagination' => array(
        'pageSize' => 50,
      )
    ));
	}
  
}
