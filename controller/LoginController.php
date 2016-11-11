<?php
namespace controller;

require_once('model/Session.php');
require_once('view/LayoutView.php'); 
require_once('model/Connection.php'); 

class LoginController {
    private $layoutView;
    public $model;
    private $session;
     
    public function __construct() {
      $this->layoutView = new \view\LayoutView(false);
      $this->model = new \model\Connection();
      $this->session = new \model\Session();
    }
    
    public function run() {
      $this->doLoginMode();
      $this->layoutView->render($this->session->isLoggedIn());
    }
    
    private function doLoginMode() {
      if($this->session->getSessionMessage() !== "") {
          $this->layoutView->view->message = $this->session->getSessionMessage();
          $this->session->setSessionMessage('');
          return;
      }
      if($this->layoutView->view->wantsToLogOut()) {
        $this->doLogout();
        return;
      }
      if($this->session->isLoggedIn()) {
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
      if($this->session->isLoggedIn()) {
        $this->layoutView->view->message = "Bye bye!";
        $_SESSION = array();
        session_destroy();
        $_POST = array();
      } else {
        $this->layoutView->view->message = "";
      }
    }
    
}
