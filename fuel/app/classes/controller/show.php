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
    $item = Model_Item::find($flower_id);
    $validator = Validation::forge();
    $validator->add('quantity')
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('valid_string', ['numeric'])
    ;
    $doit = Input::post('doit');
    $clear = Input::post('clear');
    $message = '';
    try {
        $validated = $validator->run(Input::post());
        if (!$validated) {
            throw new Exception();
        }
        $validData = $validator->validated();
        $item->quantity = $validData['quantity'];
        $item->save();
        $cart_data = Session::get('cart');
        $cart_data[$flower_id] = $validData['quantity'];
        Session::set('cart', $cart_data);
        Response::redirect("/show/cart");
    } catch (Exception $ex) {
        $message = $ex->getMessage();
        }
    if (!is_null($clear)) {
        Response::redirect("/show/cart");
        //remove flower from cart
    } else {
        $cart_data[$flower_id] = 0;
    }
    $data = [
        'flower_id' => $flower_id,
        'flower' => $flower,
        'quantity' => Input::post('quantity'),
        'message' => $message,
    ];
    $view = View::forge('home/showFlower.tpl', $data);
    $view->set('validator', $validator, false);
    return $view;
  }

  public function action_cart() {
    //if (!(Session::get('member'))) {
    //    Response::redirect("/authenticate/login");
    //}
    $cart_data = Session::get('cart');
    $flowers = Model_Flower::find('all');
    $data = [
        'cart_data' => $cart_data,
        'flowers' => $flowers,
    ];
    
    if (isset($_POST['myOrders'])) {
        Response::redirect("/member/placeOrder");
        
    }
    return View::forge('home/cart.tpl', $data);
  }
  
  public function action_item() {
      $data = [
          
      ];
      return View::forge('home/item.tpl', $data);
  }
}