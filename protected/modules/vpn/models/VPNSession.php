<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class VPNSession extends CModel
{

  public $ifname;
  public $username;
  public $csid;
  public $ip;
  public $rate;
  public $type;
  public $state;
  public $uptime;
  
  public function attributeNames()
  {
    return array('ifname', 'username', 'csid', 'ip', 'rate', 'type', 'state', 'uptime');
  }

  public function attributeLabels()
  {
    return array(
      'ifname'   => 'Интерфейс',
      'username' => 'Имя',
      'csid'     => 'Вызывающий IP',
      'ip'       => 'IP',
      'rate'     => 'Скорость, Кбит',
      'type'     => 'Тип',
      'state'    => 'Состояние',
      'uptime'   => 'Длительность',
    );
  }

  public function rules()
  {
    return array(
      array('ifname', 'match', 'pattern' => '/^ppp\d+$/'),
      array('username', 'match', 'pattern' => '/^[a-zA-Z0-9_-]{1,}$/'),
      array('csid, ip, rate, type, state, uptime', 'safe'),
    );
  }

  /**
   * @return array
   */
  public function getSessionList()
  {
    $out = array();
    exec('echo "show sessions order uptime" | nc -q1 127.0.0.1 2001', $out);
    unset($out[0]); // заголовок
    unset($out[1]); // разделительная линия
    $sessions = array();
    foreach ($out as $line) {
      $raw = array_map("trim", explode(' | ', htmlentities($line)));

      $fields['ifname']   = $raw[0];
      $fields['username'] = $raw[1];
      $fields['csid']     = $raw[2];
      $fields['ip']       = $raw[3];
      $fields['rate']     = $raw[4];
      $fields['type']     = $raw[5];
      $fields['state']    = $raw[6];
      $fields['uptime']   = $raw[7];

      $sessions[] = $fields;
    }
    //Yii::trace(CVarDumper::dumpAsString($sessions));
    return $sessions;
  }

  public function kill($ifname)
  {
    system(sprintf('echo "terminate if %s" | nc -q1 127.0.0.1 2001', $ifname));
  }

}

?>
