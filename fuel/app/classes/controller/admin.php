<?php

class Controller_Admin extends Controller_Base {
    
    public function action_allOrders() {
      $baskets = Model_Basket::find('all');
      $members = Model_Member::find('all');
      $name = Session::get('member')->name;
      $data = [
          'baskets' => $baskets,
          'members' => $members,
          'name' => $name,
      ];
      return View::forge('home/allOrders.tpl', $data);
    }
    
    public function action_processOrder() {
        $basket = Session::get('basket');
        $items = Model_Item::find('all');
        $flowers = Model_Flower::find('all');
        $basket_id = $basket->id;
        $data = [
            'basket' => $basket,
            'items' => $items,
            'basket_id' => $basket_id,
            'flowers' => $flowers,
        ];
        return View::forge('home/adminBasketConfirm.tpl', $data);
    }
}