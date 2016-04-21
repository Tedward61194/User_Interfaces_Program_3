<?php

class Controller_Show extends Controller_Base {

  public function before() {
    parent::before();
    $cart = Session::get('cart');
    if (is_null($cart)) {
      Session::set('cart', []);
    }
  }

  public function action_flower($flower_id) {
    $flower = Model_Flower::find($flower_id);
    $data = [
        'flower' => $flower,
    ];
    return View::forge('home/showFlower.tpl', $data);
  }

  public function action_cart() {
    $cart_data = [];
    $data = [
        'cart_data' => $cart_data,
    ];

    return View::forge('home/cart.tpl', $data);
  }
}