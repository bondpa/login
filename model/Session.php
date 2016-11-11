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
    
    public function getSessionPassword() {
        if(isset($_SESSION['passwd'])) {
            return $_SESSION['passwd'];
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
    
    public function setSessionPassword($password) {
        $_SESSION['passwd'] = $password;
    }
    
    public function setSessionMessage($message) {
        $_SESSION['message'] = $message;
    }
    
	public function isLoggedIn() {
        if(!empty($_SESSION['username']) and !empty($_SESSION['passwd'])) { 
            return true;  
        } else {
	        return false; 
        }
	}
	
}