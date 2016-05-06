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
    
    public function action_processOrderConfirm() {
        $basket = Session::get('basket');
        $member_id = $basket->member_id;
        $member = Model_Member::find($member_id);
        $items = Model_Item::find('all');
        $flowers = Model_Flower::find('all');
        $basket_id = $basket->id;
        $data = [
            'basket' => $basket,
            'items' => $items,
            'basket_id' => $basket_id,
            'flowers' => $flowers,
            'member' => $member,
        ];
        
        if (isset($_POST['processOrder'])) {
            Session::set('basket', $basket);
            Response::redirect("admin/processOrderValidCheck");
        }
        return View::forge('home/adminBasketConfirm.tpl', $data);
    }
    
    public function action_processOrderValidCheck() {
        $basket = Session::get('basket');
        $member_id = $basket->member_id;
        $member = Model_Member::find($member_id);
        $items = Model_Item::find('all');
        $flowers = Model_Flower::find('all');
        $basket_id = $basket->id;
        $dontProcess = false;
        
        foreach($items as $item) {
            if ($item->basket_id == $basket_id) {
                $flower_id = $item->flower_id;
                $flower = $flowers[$flower_id];
                if(!($flower->instock >= $item->quantity)) {
                    $dontProcess = true;
                }
            }
        }
        if (!$dontProcess) {
            foreach($items as $item) {
                if ($item->basket_id == $basket_id) {
                    $flower_id = $item->flower_id;
                    $flower = $flowers[$flower_id];
                    $flower->instock = ($flower->instock) -($item->quantity);
                    $flower->save();
                    $item->delete();
                }
            }
            Session::set('message', "Order #$basket_id successfully processed");
            $basket->delete();
            Response::redirect("admin/orderProcessedSuccess");
        } else {
            Response::redirect("admin/orderProcessedFail");
        }
        
        $data = [
            'basket' => $basket,
            'items' => $items,
            'basket_id' => $basket_id,
            'flowers' => $flowers,
            'member' => $member,
        ];
        return View::forge('home/adminBasketConfirm.tpl', $data);
    }
    
    public function action_orderProcessedSuccess() {
        $message =Session::get('message');
        $baskets = Model_Basket::find('all');
        $members = Model_Member::find('all');
        $name = Session::get('member')->name;
        $data = [
            'baskets' => $baskets,
            'members' => $members,
            'name' => $name,
            'message' => $message,
        ];
        return View::forge('home/orderProcessedSuccess.tpl', $data);
    }
    
    public function action_orderProcessedFail() {
        $basket = Session::get('basket');
        $member_id = $basket->member_id;
        $member = Model_Member::find($member_id);
        $items = Model_Item::find('all');
        $flowers = Model_Flower::find('all');
        $basket_id = $basket->id;
        $data = [
            'basket' => $basket,
            'items' => $items,
            'basket_id' => $basket_id,
            'flowers' => $flowers,
            'member' => $member,
        ];
        return View::forge('home/orderProcessedFail.tpl', $data);
    }
}   