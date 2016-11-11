<?php
namespace model;

class Session { 
    public function getSessionUserName() {
        if(isset($_SESSION['username'])) {
            return $_SESSION['username'];
        } else {
            return '';
        }
    }
    
    public function getSessionNewlyRegisteredUser() {
        if(isset($_SESSION['newuser'])) {
            return $_SESSION['newuser'];
        } else {
            return '';
        }
    }
    
    public function getSessionMessage() {
        if(isset($_SESSION['message'])) {
            return $_SESSION['message'];
        } else {
            return '';
        }
    }
    
    public function setSessionUserName($userName) {
        $_SESSION['username'] = $userName;
    }
    
    public function setSessionNewslyRegisteredUser($userName) {
        $_SESSION['newuser'] = $userName;
    }
    
    public function setSessionMessage($message) {
        $_SESSION['message'] = $message;
    }
    
	public function isLoggedIn() {
        if(!empty($_SESSION['username'])) { 
            return true; 
        } else {
	        return false; 
        }
	}
	
}