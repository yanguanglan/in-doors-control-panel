<?php

return array(
//  'title' => 'Поиск абонента',
  'action' => '/billing/index',
  
  'elements' => array(
    'login' => array(
      'type' => 'text',
      'maxlength' => 6,
      'visible' => true,
      'label' => 'Логин',
    ),
    'full_name' => array(
      'type' => 'text',
      'maxlength' => 100,
      'visible' => true,
      'label' => 'Полное имя',
      'attributes' => array('size' => 60),
    ),
    'actual_address' => array(
      'type' => 'text',
      'maxlength' => 100,
      'visible' => true,
      'label' => 'Фактический адрес',
      'attributes' => array('size' => 60),
    ),
  ),

  'buttons' => array(
    'search' => array(
      'type' => 'submit',
      'label' => 'Найти',
    ),
  ),
);

