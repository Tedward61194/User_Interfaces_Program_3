<?php
class Controller_Base extends Controller {
  public function before() {
    parent::before();
    $sessMember = Session::get('sessMember');
    $this->sessMember = $sessMember;
    $this->is_validated=isset($sessMember);
    $this->is_admin = isset($sessMember) && $sessMember->is_admin;
  }
  
  public function after($response) {
    $response = parent::after($response);
    $response->set_header(
      'Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
    return $response;
  }
}
