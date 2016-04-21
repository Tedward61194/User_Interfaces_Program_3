<?php

class Model_Item extends \Orm\Model {
  protected static $_table_name = 'item'; 

  protected static $_properties = [
    'id',
    'flower_id',
    'basket_id',
    'price',
    'quantity'
  ];
  
  protected static $_belongs_to = [
    'flower' => [
        'model_to' => 'Model_Flower',
    ],
    'basket' => [
        'model_to' => 'Model_Basket',
    ]
  ];
}
