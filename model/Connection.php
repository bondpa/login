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
    
    $stmt = $connection->prepare("select * from users where binary userid=? and binary passwd=?");
    $stmt->bind_param('ss', $userName, $password);
    $stmt->execute();
    $res = $stmt->get_result();
    $row_cnt = mysqli_num_rows($res);
    if(!$res) die($connection->error);
    if ($row_cnt == 0) {
      $authorized = false;
    } else {
      $authorized = true;
    }
    $stmt->close();
    return $authorized;
	}
	
	public function isExistingUserName($userName) {
	  $connection = $this->connection;
    $exists = false;    
    $stmt = $connection->prepare("select * from users where binary userid=?");
    $stmt->bind_param('s', $userName);
    $stmt->execute();
    $res = $stmt->get_result();
    $row_cnt = mysqli_num_rows($res);
    if(!$res) die($connection->error);
    if ($row_cnt == 0) {
      $exists = false;
    } else {
      $exists = true;
    }
    $stmt->close();
    return $exists;
	}
	
	public function registerUser($userName, $password) {
    $connection = $this->connection;
    $stmt = $connection->prepare("insert into users (userid, passwd) values(?, ?)");
    $stmt->bind_param('ss', $userName, $password);
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->close();
	}
	
	
}