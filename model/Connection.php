<?php

require_once('db-config.php');
// echo $config['host'];
class Connection {

	public function connect($config) {
    $this->config = $config;
    $connection = new mysqli($this->config['host'], $this->config['login'], $this->config['password'], $this->config['db']);

    if($connection->connect_error) {
      die($connection->connect_error);
    }

    $query = "select * from users";

    $result = $connection->query($query);

    if(!$result) die($connection->error);

    $rows = $result->num_rows;

    for($j = 0; $j < $rows; ++$j) {
      $result->data_seek($j);
      $row = $result->fetch_array(MYSQLI_ASSOC);

      echo 'id: ' . $row['id'] . '<br>';
      echo 'userid: ' . $row['userid'] . '<br>';
      echo 'passwd: ' . $row['passwd'] . '<br><br>';
    }

    $result->close();

    $connection->close();
	}

}

