<?php
namespace view;
require_once('model/Session.php');

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	public $message = '';
	private $session;
	private $value;

	public function __construct() {
		$this->session = new \model\Session();
	}
	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response($isLoggedIn) {
		$response = '<p><a href="?register">Register a new user</a></p>';
	    if($isLoggedIn) {
	    	$response .= $this->generateLogoutButtonHTML($this->message);
		} else {
			$response .= $this->generateLoginFormHTML($this->message);
		}
		return $response;
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	// value tidigare $this->getRequestUserName()
	private function generateLoginFormHTML($message) {
		
      if($this->session->getSessionUserName() !== "") {
		  $this->value = $this->session->getSessionUserName();
      } else {
    	  $this->value = $this->getRequestUserName(); 	
      }
      
		return '
			<form method="post" >
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>

					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->value .'" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />

					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}
	
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	public function isRequestUserNameMissing() {
		return $this->getRequestUserName() === "";
	}
	
	public function getRequestUserName() {
		if(isset($_POST[self::$name])) {
		  $username = $_POST[self::$name];
		} else {
			$username = "";
		}
	    return $username;
	}

	public function isRequestPasswordMissing() {
		return $this->getRequestPassword() === "";
	}
	
	public function userCredentialsAreSubmitted() {
		return !$this->isRequestPasswordMissing() && !$this->isRequestUserNameMissing();
	}

	public function noFormSubmitted() {
		return empty($_POST);
	}
	
	public function getRequestPassword() {
		if(isset($_POST[self::$password])) {
		    $password = $_POST[self::$password];
		} else {
			$password = "";
		}
	    return $password;
	}
	
	public function wantsToBeLoggedIn() {
		if(isset($_POST[self::$keep])) {
			return true;
		} else {
			return false;
		}
	}
	
	public function wantsToLogOut() {
      if(isset($_POST[self::$logout]) && $_POST[self::$logout] == 'logout') {
      	return true;
      }	else {
      	return false;
      }
	}
	
}
