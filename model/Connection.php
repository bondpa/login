<?php
namespace model;

require_once('db-config.php');

class Connection {
  private $connection = NULL;

	public function __construct() {
    $connection = new \mysqli(Configuration::$host, Configuration::$login, Configuration::$password, Configuration::$db);

    if($connection->connect_error) {
      die($connection->connect_error);
    }
    $this->connection = $connection;
	}

	public function isAuthorizedUser($userName, $password) {
    $connection = $this->connection;
    $authorized = false;
    
    // $stmt = $mysqli->prepare("select * from users where binary userid='?' and binary passwd='?'");
    // $stmt->bind_param($userName, $password);
    // $stmt->execute();
    $query = "select * from users where binary userid='" . $userName . "' and binary passwd='" . $password . "'";
    $result = $connection->query($query);
    if(!$result) die($connection->error);
    if (mysqli_num_rows($result) == 0) {
    // if ($stmt->affected_rows == 0) {
      $authorized = false;
    } else {
      $authorized = true;
    }
    
    $result->close();
    // $stmt->close();
    
    return $authorized;
	}
	
	public function isExistingUserName($userName) {
	  $connection = $this->connection;
    $exists = false;    
    $query = "select * from users where binary userid='" . $userName . "'";
    $result = $connection->query($query);
    if(!$result) die($connection->error);
    if (mysqli_num_rows($result) == 0) {
      $exists = false;
    } else {
      $exists = true;
    }
    $result->close();
    return $exists;
	}
	
	public function registerUser($userName, $password) {
    $connection = $this->connection;
    $query = "insert into users (userid, passwd) values('" . $userName . "', '" . $password . "')";
    $result = $connection->query($query);
    if(!$result) die($connection->error);
	}
	
	
}