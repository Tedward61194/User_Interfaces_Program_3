<?php

return array(
  'extensions' => array( 'tpl' => 'View_Smarty' ),
  'View_Smarty' => array(
     'extensions' => array(
        'Smarty_Fuel_Extension',
        'MyExtensions',
    ),
  )
);