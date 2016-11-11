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
        return $_SESSION['passwd'];
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
}