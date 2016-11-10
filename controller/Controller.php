<?php
require_once('model/Session.php');
require_once('view/LoginView.php'); 
require_once('view/LayoutView.php'); 
require_once('view/RegisterView.php');  
require_once('model/Connection.php'); 

class Controller {
    private $layoutView;
    private $view;
    private $dateTimeView;
    public $model;
    private $session;
     
    public function __construct() {
      if($this->isInRegisterMode()) {
        $this->view = new RegisterView();
      } else {
        $this->view = new LoginView();
      }
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
      $this->layoutView->render($this->model->isLoggedIn(), $this->view);
    }
    
    private function doRegisterMode() {
      if($this->isInRegisterMode()) {
        if(!$this->view->isUserNameLengthValidated()) {
          $this->view->registerMessage = "Username has too few characters, at least 3 characters.";
        } 
        if(!$this->view->isPasswordLengthValidated()) {
          $this->view->registerMessage = "Password has too few characters, at least 6 characters.";
        }
        if(!$this->view->isFormFilled()) {
          $this->view->registerMessage = "Password has too few characters, at least 6 characters. Username has too few characters, at least 3 characters.";
        }  
        if(!$this->view->doPasswordsMatch()) {
          $this->view->registerMessage = "Passwords do not match.";
        }
        if($this->view->containsInvalidCharactersInUserName()) {
          $this->view->registerMessage = "Username contains invalid characters.";
          $this->view->removeInvalidCharactersFromUserName();
        }
        if(!$this->view->hasSubmittedForm()) {
          $this->view->registerMessage = '';   
        }
      }
    }
      
    private function doLoginMode() {
      if($this->view->wantsToLogOut()) {
        $this->doLogout();
        return;
      }
      if($this->model->isLoggedIn()) {
        $this->view->message = "";
        return;
      }
      if($this->view->isRequestPasswordMissing()) {
        $this->view->message = "Password is missing";
      }
      if($this->view->isRequestUserNameMissing()) {
        $this->view->message = "Username is missing";
      }
      if($this->view->userCredentialsAreSubmitted()) {
        $this->doTryToLogin();
      }
      if($this->view->noFormSubmitted()) {
        $this->view->message = "";
      }
    } 
    
    private function doTryToLogin() {
      $result = $this->model->isAuthorizedUser($this->view->getRequestUserName(), 
                                              $this->view->getRequestPassword());
      if($result == true) {
        $this->view->message = "Welcome";
        $this->session->setSessionUserName($this->view->getRequestUserName());
        $this->session->setSessionPassword($this->view->getRequestPassword());
      } else {
        $this->view->message = "Wrong name or password";
      }
    }
    
    private function doLogout() {
      if($this->model->isLoggedIn()) {
        $this->view->message = "Bye bye!";
        $_SESSION = array();
        session_destroy();
        $_POST = array();
      } else {
        $this->view->message = "";
      }
    }
    
}
