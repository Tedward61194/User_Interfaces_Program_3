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
        $basket->id= $basket->save();
        
        $cart_data = Session::get('cart');
        $flowers = Model_Flower::find('all');
        foreach($cart_data as $index) {
            foreach($flowers as $cur_flower) {
                if($cur_flower->id==$index && !$cart_data[$cur_flower->id]==null) {
                    $item=Model_Item::forge();
                    $item->flower_id = $cur_flower->id;
                    $item->basket_id = $basket->id;
                    $item->price = $cur_flower->price;
                    $item->quantity = 1;
//                  $id = $item->save();
                }
            }
        }
//        $newItem = Model_Item::forge();
//        $newItem->'id'
        Response::redirect("/member/myOrders");
    }
    
    public function action_myOrders() {
      $baskets = Model_Basket::find('all');
      $cart_data = Session::get('cart');
      $flowers = Model_Flower::find('all');
      $items = Model_Flower::find('all');
      $member_id = $this->sessMember->id;
      $data = [
          'baskets' => $baskets,
          'cart_data' => $cart_data,
          'flowers' => $flowers,
          'items' => $items,
          'member_id' => $member_id,
      ];
      return View::forge('home/myOrders.tpl', $data);
    }
}