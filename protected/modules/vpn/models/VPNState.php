<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class VPNState extends CModel
{
  
  public function attributeNames()
  {
    return array();
  }

  public static function getState()
  {
    $out = array();
    exec('echo "show stat" | nc -q1 127.0.0.1 2001', $out);
    return implode("\n", $out);
  }

}
?>
