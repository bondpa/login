<?php session_start();   
require_once('controller/Controller.php');  

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER 
error_reporting(E_ALL); 
ini_set('display_errors', 'On');

$controller = new \controller\Controller();
$controller->run();



// TODO: 
// namespaces
// kan registrera användare
// kommentarer
// testning
// instruktion på Github
// döp om controller till router
// hasha lösenord
// felhantering
// säkrare sql-variant,
// logga in med cookie
// hitta på sätt att slippa detta fula: if(!$this->layoutView->view->isUserNameLengthValidated()) {