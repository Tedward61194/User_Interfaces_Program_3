<?php

class Controller_Home extends Controller_Base {

  public function before() {
    parent::before();
  }

  public function action_index() {
    $order = Session::get('order');
    $flowers = Model_Flower::find('all');
    $data = [
        'flowers' => $flowers,
    ];
    return View::forge('home/index.tpl', $data);
  }
}

