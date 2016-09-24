<?php

class Controller {
    private $userid = '';
    private $passwd = '';
    private $layoutView;
    private $loginView;
    private $model;
  
    public function __construct($loginView, $layoutView, $model) {
      // echo "constructing Controller object:<br>";
      $this->loginView = $loginView;
      $this->layoutView = $layoutView;
      $this->model = $model;
    }
  
    public function checkPost() {
      if(empty($_POST)) {
        //echo "inget har skickats med...<br>";
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
      }
    } 
    
}
