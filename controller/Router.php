<?php
namespace controller;

require_once('RegisterController.php'); 
require_once('LoginController.php'); 

class Router {
  private $controller;
   
  public function __construct() {
    if($this->isInRegisterMode()) {
      $this->controller = new \controller\RegisterController();
    } else {
      $this->controller = new \controller\LoginController();
    }
  }
  
  public function isInRegisterMode() {
    return(isset($_GET['register']));
  }  
  
  public function run() {
    $this->controller->run();
  }
    
}
