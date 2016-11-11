<?php 
session_start();   
require_once('controller/Router.php');  
error_reporting(E_ALL); 
ini_set('display_errors', 'On');

$router = new \controller\Router();
$router->run();
