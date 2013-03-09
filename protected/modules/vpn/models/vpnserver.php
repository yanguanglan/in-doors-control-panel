<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class VPNServer extends CModel
{

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
      $fields = array_map("trim", explode(' | ', htmlentities($line)));
      //for ($i=0; $i<count($fields); $i++) {
      //  $fields[$i] = trim($fields[$i]);
      //}

      $sessions[] = $fields;
    }
    return $sessions;
  }

}

?>
