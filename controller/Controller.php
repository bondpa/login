<?php
require_once('model/Session.php');
require_once('view/LoginView.php'); 
require_once('view/DateTimeView.php'); 
require_once('view/LayoutView.php'); 
require_once('view/RegisterView.php');  
require_once('model/Connection.php'); 

class Controller {
    private $layoutView;
    private $loginView;
    private $registerView;
    private $dateTimeView;
    public $model;
    private $session;
     
    public function __construct() {
      $this->loginView = new LoginView();
      $this->dateTimeView = new DateTimeView();
      $this->registerView = new RegisterView();
      $this->layoutView = new LayoutView();
      $this->model = new Connection();
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
    
    public function run() {
      $this->checkPost();
      $this->layoutView->render($this->model->isLoggedIn(), 
                                $this->isInRegisterMode(), $this->loginView, 
                                $this->registerView, $this->dateTimeView);
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
      if($this->loginView->wantsToLogOut()) {
        $this->doLogout();
        return;
      }
      if($this->model->isLoggedIn()) {
        $this->loginView->message = "";
        return;
      }
      if($this->loginView->isRequestPasswordMissing()) {
        $this->loginView->message = "Password is missing";
      }
      if($this->loginView->isRequestUserNameMissing()) {
        $this->loginView->message = "Username is missing";
      }
      if($this->loginView->userCredentialsAreSubmitted()) {
        $this->doTryToLogin();
      }
      if($this->loginView->noFormSubmitted()) {
        $this->loginView->message = "";
      }
    } 
    
    private function doTryToLogin() {
      $result = $this->model->isAuthorizedUser($this->loginView->getRequestUserName(), 
                                              $this->loginView->getRequestPassword());
      if($result == true) {
        $this->loginView->message = "Welcome";
        $this->session->setSessionUserName($this->loginView->getRequestUserName());
        $this->session->setSessionPassword($this->loginView->getRequestPassword());
      } else {
        $this->loginView->message = "Wrong name or password";
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
