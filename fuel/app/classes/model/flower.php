<?php

class Model_Flower extends \Orm\Model {
  protected static $_table_name = 'flower';  // default is 'users'

  protected static $_properties = [
    'id',
    'name',
    'price',
    'description',
    'imagefile',
    'instock',
  ];

  protected static $_many_many = [
    'baskets' => [
       'table_through' => 'item',
       'model_to' => 'Model_Basket',
    ],
  ];
  
  protected static $_has_many = [
    'items' => [
        'model_to' => 'Model_Item',
    ]
  ];
}
