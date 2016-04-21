<?php

class Model_Member extends \Orm\Model {
  protected static $_table_name = 'member';

  protected static $_properties = [
    'id',
    'name',
    'email',
    'password',
    'is_admin' => [
        'default' => 0,
    ],
  ];  
    
  protected static $_has_many = [
    'baskets' => [
       'model_to' => 'Model_Basket',
    ]
  ];

  public function __toString() { 
    return $this->name; 
  }
}
