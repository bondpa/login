<?php

class Controller {
    private $userid = '';
    private $passwd = '';
    private $layoutView;
    private $loginView;
    private $registerView;
    public $model;
     
    public function __construct($loginView, $registerView, $layoutView, $model) {
      $this->loginView = $loginView;
      $this->registerView = $registerView;
      $loginView->isInRegisterMode = false;
      $this->layoutView = $layoutView;
      $this->model = $model;
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
    
    public function doRegisterMode() {
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
      
    public function doLoginMode() {
      if($this->model->isLoggedIn()) {
        // check if user exists in database and act accordingly
        $result = $this->model->isAuthorizedUser($_SESSION['username'], $_SESSION['passwd']);
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
          // check if user exists in database and act accordingly
          $result = $this->model->isAuthorizedUser($_POST['LoginView::UserName'], $_POST['LoginView::Password']);
          if($result == true) {
            $this->loginView->message = "Welcome";
            $_SESSION['username'] = $_POST['LoginView::UserName'];
            $_SESSION['passwd'] = $_POST['LoginView::Password'];
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
