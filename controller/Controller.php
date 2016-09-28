<?php

class Controller {
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
      if(empty($_POST)) {
        $this->loginView->message = "";
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
        if(!empty($_SESSION['username']) and !empty($_SESSION['passwd'])) {
          // check if user exists in database and act accordingly
          $result = $this->model->isAuthorizedUser($_SESSION['username'], $_SESSION['passwd']);
          if($result == true) {
            $this->loginView->message = "Welcome";
            $this->model->isLoggedIn = true;
          } else {
            $this->loginView->message = "Wrong name or password";
            $this->model->isLoggedIn = false;
          }
        }
        if(!empty($_POST['LoginView::Password']) and !empty($_POST['LoginView::UserName'])) {
          // check if user exists in database and act accordingly
          $result = $this->model->isAuthorizedUser($_POST['LoginView::UserName'], $_POST['LoginView::Password']);
          if($result == true) {
            $this->loginView->message = "Welcome";
            $this->model->isLoggedIn = true;
            $_SESSION['username'] = $_POST['LoginView::UserName'];
            $_SESSION['passwd'] = $_POST['LoginView::Password'];
          } else {
            $this->loginView->message = "Wrong name or password";
          }
        }
        if(isset($_POST['LoginView::Logout']) && $_POST['LoginView::Logout'] == 'logout') {
          $this->loginView->message = "Bye bye!";
          $this->model->isLoggedIn = false;
          $_SESSION = array();
          session_destroy();
        }
      }
    } 
    
}
