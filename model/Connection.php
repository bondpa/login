<?php

require_once('db-config.php');
class Connection {
  public $connection = NULL;

	public function __construct($config) {
    $this->config = $config;
    $connection = new mysqli($this->config['host'], $this->config['login'], $this->config['password'], $this->config['db']);

    if($connection->connect_error) {
      die($connection->connect_error);
    }
    $this->connection = $connection;
	}

  public function saveCookieInformation($userName, $token) {
    $connection = $this->connection;
    
    $query = "update users set token='" . $token . "' where userid ='" . $userName . "'";
    $result = $connection->query($query);
    if(!$result) die($connection->error);
  }

	public function isAuthorizedUser($userName, $password) {
    $connection = $this->connection;
    $authorized = false;
    
    $query = "select * from users where binary userid='" . $userName . "' and binary passwd='" . $password . "'";
    $result = $connection->query($query);
    if(!$result) die($connection->error);
    
    if (mysqli_num_rows($result) == 0) {
      $authorized = false;
    } else {
      $authorized = true;
    }
    
    $result->close();
    
    return $authorized;
	}
	
	public function isLoggedIn() {
    if(!empty($_SESSION['username']) and !empty($_SESSION['passwd'])) {
      return true;  
    } 
    if($this->isRememberedWithCookie()) {
      return true;
    }
	  return false; 
	}
	
	public function isRememberedWithCookie() {
	  if(empty($_COOKIE['user']['username'])) {
	    return false;
	  } else {
  	  $userName = $_COOKIE['user']['username'];
  	  $token = $_COOKIE['user']['token']; 
  	  echo $userName . " " . $token;
	  }
    $connection = $this->connection;
    $rememderedWithCookie = false;
    
    $query = "select * from users where binary userid='" . $userName . "' and token='" . $token . "'";
    $result = $connection->query($query);
    if(!$result) die($connection->error);
    
    if (mysqli_num_rows($result) == 0) {
      $rememderedWithCookie = false;
    } else {
      $rememderedWithCookie = true;
    }
    
    $result->close();
    return $rememderedWithCookie;
	}
	
	
}