<?php

class Controller {
    private $keepMeLoggedIn = false;
    private $userid = '';
    private $passwd = '';
    private $layoutView;
    private $loginView;
    public $model;
     
    public function __construct($loginView, $layoutView, $model) {
      // echo "constructing Controller object:<br>";
      $this->loginView = $loginView;
      $this->layoutView = $layoutView;
      $this->model = $model;
    }
  
    public function checkPost() {
      if(isset($_POST['LoginView::KeepMeLoggedIn'])) {
        $this->keepMeLoggedIn = true;
      }
      if($this->model->isLoggedIn()) {
        // check if user exists in database and act accordingly
        $result = $this->model->isAuthorizedUser($_SESSION['username'], $_SESSION['passwd']);
        if($result == true) {
          $this->loginView->message = "";
        } else {
          $this->loginView->message = "Wrong name or password";
        }
      } else {
        // not logged in, test to autenicate with cookie
        $result = $this->model->isRememberedWithCookie();
        if($result == true) {
          $this->loginView->message = "Welcome back with cookie";
        }
        if(empty($_POST)) {
          $this->loginView->message = "";
          if($this->keepMeLoggedIn) {
            $this->loginView->message = "Welcome back with cookie";
          }
        } else {
          if(!empty($_POST['LoginView::Password'])) {
            // echo "password is set and equals " . $_POST['LoginView::Password'] . "<br>";
          } else {
            $this->loginView->message = "Password is missing";
          }
          if(!empty($_POST['LoginView::UserName'])) {
            // echo "username is set and equals " . $_POST['LoginView::UserName'] . "<br>";
          } else {
            $this->loginView->message = "Username is missing";
          }
          if(!empty($_POST['LoginView::Password']) and !empty($_POST['LoginView::UserName'])) {
            // check if user exists in database and act accordingly
            $result = $this->model->isAuthorizedUser($_POST['LoginView::UserName'], $_POST['LoginView::Password']);
            if($result == true) {
              $this->loginView->message = "Welcome";
              $_SESSION['username'] = $_POST['LoginView::UserName'];
              $_SESSION['passwd'] = $_POST['LoginView::Password'];
              if($this->keepMeLoggedIn) {
                $token = rand();
                $user = array(
                  'username' => $_POST['LoginView::UserName'],
                  'token' => $token 
                );     
                setcookie("loginCredentials", serialize($user), time() + 7200); 
                $this->loginView->message = "Welcome and you will be remembered";
                // tell model to store token in database
                $this->model->saveCookieInformation($user['username'], $token);
              }
            } else {
              $this->loginView->message = "Wrong name or password";
            }
          }
        }
      }
      if(isset($_POST['LoginView::Logout']) && $_POST['LoginView::Logout'] == 'logout') {
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
    
}
