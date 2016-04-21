<?php

class Model_Basket extends \Orm\Model {
  protected static $_table_name = 'basket'; 

  protected static $_properties = [
    'id',
    'member_id',
    'made_on',
  ];

  protected static $_many_many = [
    'flowers' => [
       'table_through' => 'item',
       'model_to' => 'Model_Flower',
    ],
  ];
  
  protected static $_belongs_to = array(
    'member' => array(
        'model_to' => 'Model_Member',
    )
  );
  
  protected static $_has_many = [
    'items' => [
       'model_to' => 'Model_Item',
       'cascade_delete'=> true,
    ]
  ];  

}
