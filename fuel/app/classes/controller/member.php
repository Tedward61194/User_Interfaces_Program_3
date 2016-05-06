<?php

class Controller_Member extends Controller_Base {
    public function before() {
        parent::before();
        if (is_null(Session::get('member'))) {
            return Response::redirect('/authenticate/login');
        }
        $this->sessMember = Session::get('member');
    }
    
    public function action_placeOrder() {
        $member_id = $this->sessMember->id;
        $basket = Model_Basket::forge();
        $basket->member_id = $member_id;
        $basket->made_on = date("Y-m-d", time());        
        $basket->save();
        
        $cart_data = Session::get('cart');
        $flowers = Model_Flower::find('all');
        
        foreach($cart_data as $flower_id => $quantity) {
            $flower = Model_Flower::find($flower_id);
            $item = Model_Item::forge();
            $item->flower_id = $flower_id;
            $item->basket_id = $basket->id;
            $item->quantity = $quantity;
            $item->price = $flower->price;
            $item->save();
        }
        Session::set('cart', []);
        Response::redirect("/member/myOrders");
    }
    
    public function action_myOrders() {
      $baskets = Model_Basket::find('all');
      $flowers = Model_Flower::find('all');
      $items = Model_Flower::find('all');
      $member_id = $this->sessMember->id;
      $data = [
          'baskets' => $baskets,
          'flowers' => $flowers,
          'items' => $items,
          'member_id' => $member_id,
      ];
      return View::forge('home/myOrders.tpl', $data);
    }
}