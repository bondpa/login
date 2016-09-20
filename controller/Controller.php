<?php

class Controller {
  private $userid = '';
  private $passwd = '';

  public function __construct() {
    echo "constructing Controller object:<br>";

    if(empty($_POST)) {
      echo "inget har skickats med...<br>";
    } else {
      echo "något har skickats med/knapp har tryckts...<br>";
    }

  }
}
