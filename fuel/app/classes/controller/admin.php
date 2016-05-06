<?php
// Teddy Segal

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
    
    public function action_addFlower() {
        $validator = Validation::forge();
        $message = "";

        $validator->add('name', 'name') // field, label
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('valid_string', ['alpha', 'numeric', 'spaces', 'punctuation'])
            ->add_rule('min_length', 3)
        ;
        $validator->add('price', 'price')
            ->add_rule('trim')
            ->add_rule('required')
                ->add_rule('valid_string', ['numeric'])
        ;
        $validator->add('email', 'email')
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('valid_email')
        ;
    
        // specifiy error messages to override rule defaults
        $validator
            ->set_message('required', ':label cannot be empty')
            ->set_message('min_length', 'at least :param:1 char(s)')
            ->set_message('valid_email', 'invalid email')
        ;

        // specify error messages per field to override other messages
        $validator
            ->field('price')
            ->set_error_message('valid_string', 'must be non-negative integer')
        ;
        
        if(isset($_POST['doit'])) {
            $validated = $validator->run($_POST);
            if ($validated) {
                $validData = $validator->validated();
                $message = var_export($validData, true);
                Response::redirect('admin/addFlower/Reentrant');
            }
            
        }
        
        $data = [
            'name' => '',
            'price' => '',
            'description' => '',
            'imagefile' => '',
            'instock' => '',
            'message' => $message,
        ];
        
        $view = View::forge('home/addFlower.tpl', $data);
        $view->set('validator', $validator, false);
        return $view;
    }
    
    public function action_addFlowerReentrant() {
        echo "hi";
        $data = [
            
        ];
    }
    
    public function action_modify() {
        $flower = Session::get('flower');
        
        $data = [
            'flower' => $flower,
        ];
        
        if(isset($_POST['modify'])) {
            $flower->price = filter_input(INPUT_POST, 'price');
            $flower->save();
            Response::redirect('/');
        }
        
        if(isset($_POST['cancel'])) {
            Response::redirect('/');
        }
        
        return View::forge('home/modify.tpl', $data);
    }
}   