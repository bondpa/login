<?php
require_once('model/Session.php');
require_once('view/LayoutView.php'); 
require_once('model/Connection.php'); 

class Controller {
    private $layoutView;
    private $dateTimeView;
    public $model;
    private $session;
     
    public function __construct() {
      $this->layoutView = new LayoutView($this->isInRegisterMode());
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
      $this->layoutView->render($this->model->isLoggedIn());
    }
    
    private function doRegisterMode() {
      if($this->isInRegisterMode()) {
        if(!$this->layoutView->view->isUserNameLengthValidated()) {
          $this->layoutView->view->registerMessage = "Username has too few characters, at least 3 characters.";
        } 
        if(!$this->layoutView->view->isPasswordLengthValidated()) {
          $this->layoutView->view->registerMessage = "Password has too few characters, at least 6 characters.";
        }
        if(!$this->layoutView->view->isFormFilled()) {
          $this->layoutView->view->registerMessage = "Password has too few characters, at least 6 characters. Username has too few characters, at least 3 characters.";
        }  
        if(!$this->layoutView->view->doPasswordsMatch()) {
          $this->layoutView->view->registerMessage = "Passwords do not match.";
        }
        if($this->layoutView->view->containsInvalidCharactersInUserName()) {
          $this->layoutView->view->registerMessage = "Username contains invalid characters.";
          $this->layoutView->view->removeInvalidCharactersFromUserName();
        }
        if(!$this->layoutView->view->hasSubmittedForm()) {
          $this->layoutView->view->registerMessage = '';   
        }
      }
    }
      
    private function doLoginMode() {
      if($this->layoutView->view->wantsToLogOut()) {
        $this->doLogout();
        return;
      }
      if($this->model->isLoggedIn()) {
        $this->layoutView->view->message = "";
        return;
      }
      if($this->layoutView->view->isRequestPasswordMissing()) {
        $this->layoutView->view->message = "Password is missing";
      }
      if($this->layoutView->view->isRequestUserNameMissing()) {
        $this->layoutView->view->message = "Username is missing";
      }
      if($this->layoutView->view->userCredentialsAreSubmitted()) {
        $this->doTryToLogin();
      }
      if($this->layoutView->view->noFormSubmitted()) {
        $this->layoutView->view->message = "";
      }
    } 
    
    private function doTryToLogin() {
      $result = $this->model->isAuthorizedUser($this->layoutView->view->getRequestUserName(), 
                                              $this->layoutView->view->getRequestPassword());
      if($result == true) {
        $this->layoutView->view->message = "Welcome";
        $this->session->setSessionUserName($this->layoutView->view->getRequestUserName());
        $this->session->setSessionPassword($this->layoutView->view->getRequestPassword());
      } else {
        $this->layoutView->view->message = "Wrong name or password";
      }
    }
    
    private function doLogout() {
      if($this->model->isLoggedIn()) {
        $this->layoutView->view->message = "Bye bye!";
        $_SESSION = array();
        session_destroy();
        $_POST = array();
      } else {
        $this->layoutView->view->message = "";
      }
    }
    
}
