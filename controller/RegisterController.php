<?php
namespace controller;

require_once('model/Session.php');
require_once('view/LayoutView.php'); 
require_once('model/Connection.php'); 

class RegisterController {
    private $layoutView;
    public $model;
    private $session;
     
    public function __construct() {
      $this->layoutView = new \view\LayoutView(true);
      $this->model = new \model\Connection();
      $this->session = new \model\Session();
    }
    
    public function run() {
      $this->doRegisterMode();
      $this->layoutView->render($this->session->isLoggedIn());
    }
    
    private function doRegisterMode() {
      if(!$this->layoutView->view->isUserNameLengthValidated()) {
        $this->layoutView->view->registerMessage = 
              "Username has too few characters, at least 3 characters.";
      } 
      if(!$this->layoutView->view->isPasswordLengthValidated()) {
        $this->layoutView->view->registerMessage = 
              "Password has too few characters, at least 6 characters.";
      }
      if(!$this->layoutView->view->isFormFilled()) {
        $this->layoutView->view->registerMessage = 
              "Password has too few characters, at least 6 characters. 
              Username has too few characters, at least 3 characters.";
      }  
      if(!$this->layoutView->view->doPasswordsMatch()) {
        $this->layoutView->view->registerMessage = "Passwords do not match.";
      }
      if($this->layoutView->view->containsInvalidCharactersInUserName()) {
        $this->layoutView->view->registerMessage = 
              "Username contains invalid characters.";
        $this->layoutView->view->removeInvalidCharactersFromUserName();
        return;
      }
      if(!$this->layoutView->view->hasSubmittedForm()) {
        $this->layoutView->view->registerMessage = '';   
      }
      if($this->layoutView->view->isTryingToRegister()) {
          if(!$this->model->isExistingUserName(
            $this->layoutView->view->getRequestUserName())) {
              $this->model->registerUser(
                $this->layoutView->view->getRequestUserName(), 
                $this->layoutView->view->getRequestPassword());
              $this->session->setSessionMessage("Registered new user.");
              $this->session->setSessionNewslyRegisteredUser(
                $this->layoutView->view->getRequestUserName());
              header("Location: /");
          } else {
              $this->layoutView->view->registerMessage = 
                                        "User exists, pick another username.";
          }
      }
    }
}
