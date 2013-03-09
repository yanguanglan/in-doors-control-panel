<?php

/**
 * 
 */
class RADIUSLog extends CModel
{
  
  const DEFAULT_LINES_COUNT = 50;
  const MAX_LINES_COUNT     = 1000;

  public $logfilePath = '/var/log/netup/radius.main.log';

  public $type;
  public $date;
  public $id;
  public $subSystem;
  public $details;

  private $_linesCount;

  public function __construct($lines = RADIUSLog::DEFAULT_LINES_COUNT)
  {
    $this->setLinesCount($lines);
  }

  public function setLinesCount($count)
  {
    $num = intval($count);
    $this->_linesCount = ($num>0 && $num<RADIUSLog::MAX_LINES_COUNT) ? $num : RADIUSLog::DEFAULT_LINES_COUNT;
  }
  
  public function getLinesCount()
  {
    return $this->_linesCount;
  }

  public function attributeNames()
  {
    return array();
  }

  public function attributeLabels()
  {
    return array(
      'type'      => 'Тип',
      'date'      => 'Дата',
      'id'        => 'ID',
      'subSystem' => 'Подсистема',
      'details'   => 'Подробности',
    );
  }

  public function rules()
  {
    return array(
      array('type', 'in', array('Notice', 'Warn', 'ERROR')),
      array('subSystem', 'in', array('AuthServer', 'RADIUS DBA')),
      array('id', 'match', 'pattern' => '/^[a-z0-9]{8}$/'),
      array('date, details', 'safe'),
    );
  }

  public function read($lines = null)
  {
    if ($lines) {
      $this->setLinesCount($lines);
    }
    $out = array();
    exec('cat ' . $this->logfilePath . ' | grep -v "Login OK" | tail -n ' . $this->_linesCount, $out);
    $radius_log = array_reverse($out);

    $errors = array();
    $key = 0;
    foreach ($radius_log as $line) {
      $m = array();
      $ret = preg_match('/^ (Notice|Warn|ERROR)\s{0,3}: ([a-z]{3} \d\d \d\d:\d\d:\d\d) ([a-f0-9]{8}) (AuthServer|RADIUS\sDBA): (.+)$/i', $line, $m);
      //Yii::trace(CVarDumper::dumpAsString($line));

      if (empty($m[1]) or empty($m[4])) {
        $fields['unknown'] = $line;
      }
      else {
        $replaced_login = preg_replace('/^Login incorrect <([a-zA-Z0-9_\.-]{1,255})>/i', 'Login incorrect <$1>', $m[5]);
        $replaced_ip    = preg_replace('/Calling-station <(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})>$/i', 'Calling-station <$1>', $replaced_login);
        $replaced_mac   = preg_replace('/Calling-station <(vlan[\d]{1,4}:([0-9a-f:]{17}))>$/i', 'Calling-station <$1>', $replaced_ip);

        $fields['type']      = $m[1];
        $fields['date']      = $m[2];
        $fields['id']        = $m[3];
        $fields['subSystem'] = $m[4];
        $fields['details']   = mb_convert_encoding($replaced_mac, 'UTF-8' , 'CP1251');
      }
      $fields['key'] = $key++;

      $errors[] = $fields;
    }

    return $errors;
  }

}
?>
