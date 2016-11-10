<?php

class Session {
    public function getSessionUserName() {
        return $_SESSION['username'];
    }
    
    public function getSessionPassword() {
        return $_SESSION['passwd'];
    }
    
    public function setSessionUserName($userName) {
        $_SESSION['username'] = $userName;
    }
    
    public function setSessionPassword($password) {
        $_SESSION['passwd'] = $password;
    }
}