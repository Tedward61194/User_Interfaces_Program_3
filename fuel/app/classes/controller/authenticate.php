<?php

class Controller_Authenticate extends Controller_Base {

  public function action_login() {
    if (!is_null($this->sessMember)) {
      return Response::redirect("/");
    }
    $data = array(
      /* For name, we want to pass it down from here
       * rather than retrieve it as a flash variable in
       * the Smarty template.
       * 
       * The reason is that username needs to be "escaped"
       */
      'name' => Session::get_flash('name'),
    );
    return View::forge("authenticate/login.tpl", $data);
  }

  public function action_validate() {
    $name = trim(Input::post('name'));
    $password = trim(Input::post('password'));
    $member = Model_Member::find('first', [
        'where'=> [ "name" => $name ],
    ]);
    if (is_null($member)) {
      Session::set_flash('name', $name);
      Session::set_flash('message', 'invalid member');
      return Response::redirect('/authenticate/login');
    }
    elseif (hash('sha256', $password) === $member->password) {
      $sessUser = (object) [
         'id' => $member->id,
         'name' => $member->name,
         'is_admin' => $member->is_admin,
      ];
      Session::set('member', $sessUser);
      return Response::redirect('/');      
    }
    else {
      Session::set_flash('name', $name);
      Session::set_flash('message', 'invalid password');
      return Response::redirect('/authenticate/login');
    }
  }

  public function action_logout() {
    Session::delete('member');
    return Response::redirect('/');      
  }
  
  public function action_noaccess() {
    return View::forge("authenticate/noAccess.tpl");
  }
}
