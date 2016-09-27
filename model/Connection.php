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

}