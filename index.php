<?php 
session_start();   
require_once('controller/Router.php');  

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER 
error_reporting(E_ALL); 
ini_set('display_errors', 'On');

$router = new \controller\Router();
$router->run();



// TODO: 
// *namespaces
// *kan registrera användare
// hantera session hijacking
// dela upp modellen och göra den tydligare
// kommentarer
// testning
// instruktion på Github
// *döp om controller till router
// hasha lösenord
// felhantering
// säkrare sql-variant,
// logga in med cookie
// hitta på sätt att slippa detta fula: if(!$this->layoutView->view->isUserNameLengthValidated()) {