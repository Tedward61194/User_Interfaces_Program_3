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
}