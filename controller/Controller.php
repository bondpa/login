<?php
require_once('RegisterController.php'); 
require_once('LoginController.php'); 

class Controller {
  private $controller;
   
  public function __construct() {
    if($this->isInRegisterMode()) {
      $this->controller = new RegisterController();
    } else {
      $this->controller = new LoginController();
    }
  }
  
  public function isInRegisterMode() {
    return(isset($_GET['register']));
  }  
  
  public function run() {
    $this->controller->run();
  }
    
}
