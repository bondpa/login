<?php
require_once('model/Session.php');

class Controller {
    private $layoutView;
    private $loginView;
    private $registerView;
    public $model;
    private $session;
     
    public function __construct($loginView, $registerView, $layoutView, $model) {
      $this->loginView = $loginView;
      $this->registerView = $registerView;
      $loginView->isInRegisterMode = false;
      $this->layoutView = $layoutView;
      $this->model = $model;
      $this->session = new Session();
    }
    
    public function isInRegisterMode() {
      return(isset($_GET['register']));
    }  
    
    public function checkPost() {
      if($this->isInRegisterMode()) {
        $this->doRegisterMode();
      } else {
        $this->doLoginMode();
      }
    }
    
    private function doRegisterMode() {
      if($this->isInRegisterMode()) {
        if(!$this->registerView->isUserNameLengthValidated()) {
          $this->registerView->registerMessage = "Username has too few characters, at least 3 characters.";
        } 
        if(!$this->registerView->isPasswordLengthValidated()) {
          $this->registerView->registerMessage = "Password has too few characters, at least 6 characters.";
        }
        if(!$this->registerView->isFormFilled()) {
          $this->registerView->registerMessage = "Password has too few characters, at least 6 characters. Username has too few characters, at least 3 characters.";
        }  
        if(!$this->registerView->doPasswordsMatch()) {
          $this->registerView->registerMessage = "Passwords do not match.";
        }
        if($this->registerView->containsInvalidCharactersInUserName()) {
          $this->registerView->registerMessage = "Username contains invalid characters.";
          $this->registerView->removeInvalidCharactersFromUserName();
        }
        if(!$this->registerView->hasSubmittedForm()) {
          $this->registerView->registerMessage = '';   
        }
      }
    }
      
    private function doLoginMode() {
      if($this->model->isLoggedIn()) {
        $result = $this->model->isAuthorizedUser($this->session->getSessionUserName(), $this->session->getSessionPassword());
        if($result == true) {
          $this->loginView->message = "";
        } else {
          $this->loginView->message = "Wrong name or password";
        }
      }
      
      else {
        if($this->loginView->isRequestPasswordMissing()) {
          $this->loginView->message = "Password is missing";
        }
        if($this->loginView->isRequestUserNameMissing()) {
          $this->loginView->message = "Username is missing";
        }
        if($this->loginView->userCredentialsAreSubmitted()) {
          $result = $this->model->isAuthorizedUser($_POST['LoginView::UserName'], $_POST['LoginView::Password']);
          if($result == true) {
            $this->loginView->message = "Welcome";
            $this->session->setSessionUserName($_POST['LoginView::UserName']);
            $this->session->setSessionPassword($_POST['LoginView::Password']);
          } else {
            $this->loginView->message = "Wrong name or password";
          }
        }
        if($this->loginView->noFormSubmitted()) {
          $this->loginView->message = "";
        }
      }
      
      if($this->loginView->wantsToLogOut()) {
        $this->doLogout();
      }
    } 
    
    private function doLogout() {
      if($this->model->isLoggedIn()) {
        $this->loginView->message = "Bye bye!";
        $_SESSION = array();
        session_destroy();
        $_POST = array();
      } else {
        $this->loginView->message = "";
      }
    }
    
}
