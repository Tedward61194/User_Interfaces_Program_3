<?php

namespace Fuel\Tasks;

use Fuel\Core\Config;
use DB;

class MakeTables {
  private static $FLOWER_TABLE;
  private static $MEMBER_TABLE;
  private static $ITEM_TABLE;
  private static $BASKET_TABLE;
  private static $cx;
  private static $which;

  public static function run() {
    self::init();
    self::createTables();
    self::populateTables();
  }

  public static function create() {
    self::init();
    self::createTables();
  }

  public static function populate() {
    self::init();
    self::populateTables();
  }

  private static function init() {
    Config::load('development/db.php');

    $which = Config::get('which');
    echo "---- database: $which\n\n";

    self::$which = $which;

    self::$FLOWER_TABLE = \Model_Flower::table();
    self::$MEMBER_TABLE = \Model_Member::table();
    self::$ITEM_TABLE = \Model_Item::table();
    self::$BASKET_TABLE = \Model_Basket::table();

    if ($which == "sqlite") {
      self::initSQLite();
    }

    $dsn = Config::get("default.connection.dsn");
    $username = Config::get("default.connection.username");
    $password = Config::get("default.connection.password");

    self::$cx = new \PDO($dsn, $username, $password);
  }

  private static function createTables() {
    foreach ([
      self::$ITEM_TABLE, self::$BASKET_TABLE,
      self::$MEMBER_TABLE, self::$FLOWER_TABLE] as $table) {
      $sql = "drop table if exists $table";
      echo "$sql\n";
      self::$cx->prepare($sql)->execute();
    }

    foreach ([self::$FLOWER_TABLE, self::$MEMBER_TABLE, self::$BASKET_TABLE,
      self::$ITEM_TABLE,] as $table) {
      $which = self::$which;
      $sql = file_get_contents(__DIR__ . "/tables/$table-$which.sql");
      echo "$sql\n";
      self::$cx->prepare($sql)->execute();
    }
  }

  private static function populateTables() {
    self::addMembers();
    self::addFlowers();
    self::addOrders();
  }

  private static function addMembers() {
    echo "\n---------------------- add members\n";

    $user_data = [
        ["john", "arachnid@oracle.com", "john"],
        ["kirsten", "buffalo@go.com", "kirsten"],
        ["bill", "digger@gmail.com", "bill"],
        ["mary", "elephant@wcupa.edu", "mary"],
        ["joan", "kangaroo@upenn.edu", "joan"],
        ["alice", "feline@yahoo.com", "alice"],
        ["carla", "badger@esu.edu", "carla"],
        ["dave", "warthog@temple.edu", "dave"],
    ];

    foreach ($user_data as $data) {
      list($name, $email, $password) = $data;
      $member = \Model_Member::forge();
      $member->name = $name;
      $member->email = $email;
      $member->password = hash('sha256', $password);
      $member->save();
      echo "user $member->id: $name\n";
    }

    // Admins: choose a few selected ones
    echo "\n";
    foreach (['dave', 'carla'] as $name) {
      $member = \Model_Member::find('first', [
          'where' => [ 'name' => $name ],
      ]);
      $member->is_admin = 1;
      $member->save();      
      echo "admin: $name\n";
    }
  }

  private static function addFlowers() {
    echo "\n---------------------- add flowers\n";

    $flower_data = [
        [
            "Missouri Evening Primrose",
            "MissouriEveningPrimrose.jpg",
            8.00,
            70,
            <<<END
Let the sweet scent of Missouri Evening Primrose grace your garden, 
while you enjoy its bright yellow blooms all summer long! 
Very resilient. Will perform even in poor soil and drought conditions. 
END
        ],
        [
            "Mixed Liatris",
            "MixedLiatris.jpg",
            1.19,
            80,
            <<<END
Unique perennial adds interest to sun areas with stunning, stiff bottlebrush 
of dense white and purple flowers and fine, grasslike foliage! An excellent 
addition to cut flower arrangements, Mixed Liatris has a long vase life 
and captivates passersby when grown out in the garden. 
END
        ],
        [
            "Commander in Chief Lily",
            "CommanderInChiefLily.jpg",
            2.65,
            90,
            <<<END
This Asiatic lily produces an abundance of large, 6-8" blooms of shimmering, 
scarlet-red atop 3-4' tall plants. This stunner grows almost anywhere in 
zones 3 to 9 in full sun to partial shade. You'll adore these blooms, 
but deer won't; they tend to avoid it. 
END
        ],
        [
            "Alaska Shasta Daisy",
            "AlaskaShastaDaisy.jpg",
            3.33,
            60,
            <<<END
No garden should be without this classic flower! This longlived perennial requires 
little care and delivers masses of frilly, double blooms with yellow centers. 
Butterflies love them! 
END
        ],
        [
            "Orange Glory Flower",
            "OrangeGloryFlower.jpg",
            4.69,
            85,
            <<<END
If you like to watch beautiful butterflies, then you'll love Orange Glory Flower.
It's one of their favorites! These eye-catching blooms look like a fiery floral 
sunset in the garden, creating a lasting statement all season long. 
END
        ],
        [
            "Peruvian Daffodil",
            "PeruvianDaffodil.jpg",
            4.15,
            75,
            <<<END
Large, trumpet-shaped flower heads unfurl to show off their exotic look and 
intense fragrance. A delicately fringed trumpet atop amaryllis-like foliage 
provides an attractive accent for this daffodil look-alike.
END
        ],
        [
            "Red Spider Lily",
            "RedSpiderLily.jpg",
            4.25,
            120,
            <<<END
Multi-flowering, bright red flowers make a dramatic statement! Strap-shaped 
green foliage disappears in July in preparation for the flower spike bursting 
forth in August. Grow in cool greenhouses or outdoors in warmer areas where 
little or no frost is experienced. Apply winter cover in zones lower than 7.
END
        ],
        [
            "Sweet William",
            "SweetWilliam.jpg",
            3.33,
            85,
            <<<END
One sniff of its clusters of small blooms will tell you why this perennial 
is so popular! An old-fashioned favorite, it grows fast and brings early-season 
color and fragrance to your borders and rock gardens.
END
        ],
    ];

    foreach ($flower_data as $data) {
      list($name, $imagefile, $price, $instock, $description) = $data;
      $flower = \Model_Flower::forge();
      $flower->name = $name;
      $flower->imagefile = $imagefile;
      $flower->price = $price;
      $flower->instock = $instock;
      $flower->description = $description;
      $flower->save();
      echo "added: $flower->name\n";
    }
  }


  private static function addOrders() {
    echo "\n---------------------- add orders\n";
    
    function NdaysBefore($n) {
      return time() - 24 * 3600 * $n - rand(0, 3 * 3600);
    }

    foreach (range(1, 8) as $i) {
      $flower[$i] = \Model_Flower::find($i);
    }
    
    function makeItem($basket_id, $flower, $quantity) {
      $item = \Model_Item::forge();
      $item->basket_id = $basket_id;
      $item->flower_id = $flower->id;
      $item->price = $flower->price;
      $item->quantity = $quantity;
      $item->save();
    }

    //------------------------------------------------
    $basket = \Model_Basket::forge();
    $basket->member_id = 5;
    $basket->made_on = date("Y-m-d H:i:s", NdaysBefore(8));
    $basket->save();
    
    makeItem($basket->id, $flower[4], 22);
    makeItem($basket->id, $flower[7], 33);
    makeItem($basket->id, $flower[2], 11);
    
    echo "order #$basket->id made by {$basket->member->name} on {$basket->made_on}\n";
    
    //------------------------------------------------
    $basket = \Model_Basket::forge();
    $basket->member_id = 6;
    $basket->made_on = date("Y-m-d H:i:s", NdaysBefore(8));
    $basket->save();
    
    makeItem($basket->id, $flower[3], 22);
    makeItem($basket->id, $flower[2], 33);
    makeItem($basket->id, $flower[5], 11);
    
    echo "order #$basket->id made by {$basket->member->name} on {$basket->made_on}\n";

    //------------------------------------------------
    $basket = \Model_Basket::forge();
    $basket->member_id = 5;
    $basket->made_on = date("Y-m-d H:i:s", NdaysBefore(8));
    $basket->save();
    
    makeItem($basket->id, $flower[1], 15);
    makeItem($basket->id, $flower[8], 70);
    
    echo "order #$basket->id made by {$basket->member->name} on {$basket->made_on}\n";
  }

  private static function initSQLite() {
    $dir = APPPATH . 'database';
    if (!is_dir($dir)) {
      mkdir($dir);
      chmod($dir, 0777);
    }
    $database = "$dir/db.sqlite";
    if (!is_file($database)) {
      touch($database);
      chmod($database, 0666);
    }
  }
}