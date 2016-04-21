<?php
/**
 * The development database settings. These get merged with the global settings.
 */

// set this to either 'mysql' or 'sqlite'
$which = 'mysql';

$mysql = [
  // change these MySQL database specs if necessary
  'connection'  => [
    'dsn'        => 'mysql:host=localhost;dbname=test',
    'username'   => 'guest',
    'password'   => '',
  ],
];

$sqlite = [
  'charset' => NULL,
  'connection'  => [
    'dsn' => 'sqlite:' . APPPATH . 'database/db.sqlite',
  ],
];

$choices = [
    'mysql' => $mysql,
    'sqlite' => $sqlite,
];

return [
  'which' => $which,
  'default' => $choices[$which],  // makes this the one used
];
