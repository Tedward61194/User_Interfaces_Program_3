<?php
// Teddy Segal

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
    $member = Session::get('member');
    $validator = Validation::forge();
    $validator->add('quantity')
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('valid_string', ['numeric'])
    ;
    $message = '';
    try {
        $validated = $validator->run(Input::post());
        if (!$validated) {
            throw new Exception();
        }
        $validData = $validator->validated();
        $cart_data = Session::get('cart');
        $cart_data[$flower_id] = $validData['quantity'];
        Session::set('cart', $cart_data);
        Response::redirect("/show/cart");
    } catch (Exception $ex) {
        $message = $ex->getMessage();
    }
    $data = [
        'flower_id' => $flower_id,
        'flower' => $flower,
        'quantity' => Input::post('quantity'),
        'message' => $message,
        'member' => $member,
    ];
    
    if(isset($_POST['clear'])) {
        $cart_data = Session::set('cart', []);
        Response::redirect("show/cart");
    }
    
    if(isset($_POST['modify'])) {
        Session::set('flower', $flower);
        Response::redirect("admin/modify");
  }
    
    $view = View::forge('home/showFlower.tpl', $data);
    $view->set('validator', $validator, false);
    return $view;
  }

  public function action_cart() {
    $cart_data = Session::get('cart');
    $flowers = Model_Flower::find('all');
    $data = [
        'cart_data' => $cart_data,
        'flowers' => $flowers,
    ];
    
    if(isset($_POST['myOrders'])) {
        Response::redirect("/member/placeOrder");    
    }
    return View::forge('home/cart.tpl', $data);
  }
  
    public function action_myBasket($basket_id) {
        $basket = Model_Basket::find($basket_id);
        $items = Model_Item::find('all');
        $flowers = Model_Flower::find('all');
        $data = [
            'basket' => $basket,
            'items' => $items,
            'basket_id' => $basket_id,
            'flowers' => $flowers,
        ];
        return View::forge('home/myBasket.tpl', $data);
    }
  
    public function action_adminBasket($basket_id) {
        $basket = Model_Basket::find($basket_id);
        $member_id = $basket->member_id;
        $member = Model_Member::find($member_id);
        $items = Model_Item::find('all');
        $flowers = Model_Flower::find('all');
        $data = [
            'basket' => $basket,
            'items' => $items,
            'basket_id' => $basket_id,
            'flowers' => $flowers,
            'member' => $member,
        ];
      
        if (isset($_POST['processOrder'])) {
            Session::set('basket', $basket);
            Response::redirect("admin/processOrderConfirm");//, $basket_id);
        }
        return View::forge('home/adminBasket.tpl', $data);
    }
}