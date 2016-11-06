<?php

class LayoutView {

  public function render($isLoggedIn, $isInRegisterMode, LoginView $v, RegisterView $rv, DateTimeView $dtv) {
    // var_dump($_POST);
    // var_dump($_SESSION);
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
              ' . $this->response($isLoggedIn, $isInRegisterMode, $v, $rv) . '

              ' . $dtv->show() . '
          </div>
         </body>
      </html>
    ';
  }
  
  private function response($isLoggedIn, $isInRegisterMode, LoginView $v, RegisterView $rv) {
    if($isInRegisterMode) {
      return $rv->response($isLoggedIn);
    } else {
      return $v->response($isLoggedIn);
    }
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
