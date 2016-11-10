<?php
require_once('view/DateTimeView.php'); 
require_once('view/RegisterView.php');  
require_once('view/LoginView.php'); 

class LayoutView {
  public $view;

  public function __construct($isInRegisterMode) {
    $this->dateTimeView = new DateTimeView();
    if($isInRegisterMode) {
      $this->view = new RegisterView();
    } else {
      $this->view = new LoginView();
    }
  }
  
  public function render($isLoggedIn) {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->renderIsLoggedIn($isLoggedIn) . '

          <div class="container">
              ' . $this->response($isLoggedIn) . '

              ' . $this->dateTimeView->show() . '
          </div>
         </body>
      </html>
    ';
  }
  
  private function response($isLoggedIn) {
    return $this->view->response($isLoggedIn);
  }

  private function renderIsLoggedIn($isLoggedIn) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }
}
