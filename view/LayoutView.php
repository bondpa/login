<?php
require_once('view/DateTimeView.php'); 

class LayoutView {

  public function __construct() {
    $this->dateTimeView = new DateTimeView();
  }
  
  public function render($isLoggedIn, $view) {
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
              ' . $this->response($isLoggedIn, $view) . '

              ' . $this->dateTimeView->show() . '
          </div>
         </body>
      </html>
    ';
  }
  
  private function response($isLoggedIn, $view) {
    return $view->response($isLoggedIn);
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
