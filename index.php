<?php session_start();   
// var_dump($_POST);
// var_dump($_SESSION);
// var_dump($_COOKIE);

//INCLUDE THE FILES NEEDED... 
require_once('view/LoginView.php'); 
require_once('view/DateTimeView.php'); 
require_once('view/LayoutView.php'); 
require_once('view/RegisterView.php');  
require_once('model/Connection.php'); 
require_once('controller/Controller.php');  


//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER 
error_reporting(E_ALL); 
ini_set('display_errors', 'On');

$c = new Connection($config);

//CREATE OBJECTS OF THE VIEWS
$v = new LoginView();
$dtv = new DateTimeView();
$lv = new LayoutView();
$rv = new RegisterView();

$controller = new Controller($v, $rv, $lv, $c);
$controller->checkPost();

$lv->render($controller->model->isLoggedIn(), $controller->isInRegisterMode(), $v, $rv, $dtv);
