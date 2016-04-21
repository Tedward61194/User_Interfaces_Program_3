<?php

class Helper {
  static function reformat($time) {
    return implode("@", explode(' ',$time));
  }
}
