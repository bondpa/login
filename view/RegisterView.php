<?php
namespace view;

class RegisterView {
	private static $logout = 'RegisterView::Logout';
	private static $name = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $register = 'RegisterView::Register';
	private static $messageId = 'RegisterView::Message';
	private static $minPasswordLength = 6;
	private static $minUserNameLength = 3;
	public $message = '';
	public $registerMessage = '';

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response($isLoggedIn) {
		$response = '';
	    if($isLoggedIn) {
	    	$response .= $this->generateLogoutButtonHTML($this->message);
		} else  {
			$response .= $this->generateRegisterFormHTML($this->registerMessage);
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

	private function generateRegisterFormHTML($message) {
		return '
			<form method="post" >
				<a href="?">Back to login</a>
				<h2>Register new user</h2>
				<fieldset>
					<legend>Register a new user - Write username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>

					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->getrequestusername() .'" /><br>

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" /><br>

					<label for="' . self::$passwordRepeat . '">Repeat Password :</label>
					<input type="password" id="' . self::$passwordRepeat .'" name="' . self::$passwordRepeat . '" /><br>
					
					<input type="submit" name="' . self::$register . '" value="Register" />
				</fieldset>
			</form>
		';
	}
	
	public function isPasswordLengthValidated() {
		$password = $this->getRequestPassword();
		if(strlen($password) < self::$minPasswordLength) {
			return false;
		} else {
			return true;
		}
	}
	
	public function isUserNameLengthValidated() {
		$name = $this->getRequestUserName();
		if(strlen($name) < self::$minUserNameLength) {
			return false;
		} else {
			return true;
		}
	}
	
	public function isFormFilled() {
		$password = $this->getRequestPassword();
		$passwordRepeat = $this->getRequestPasswordRepeat();
		$name = $this->getRequestUserName();
		return strlen($password) != 0 && strlen($passwordRepeat) != 0 && strlen($name) != 0;
	}
	
    public function hasSubmittedForm() {
    	return(isset($_POST[self::$password]) && isset($_POST[self::$passwordRepeat]) && isset($_POST[self::$name]));
    }
    
    public function doPasswordsMatch() {
    	if($this->hasSubmittedForm()) {
	    	return $this->getRequestPassword() === $this->getRequestPasswordRepeat();	
    	} else {
    		return false;
    	}
    }
    
    public function containsInvalidCharactersInUserName() {
        if($this->hasSubmittedForm() && 
        ($this->getRequestUserName() !== strip_tags($this->getRequestUserName()))) {
        	return true;
        } else {
        	return false;
        }
    }
    
    public function removeInvalidCharactersFromUserName() {
	    $_POST[self::$name] = strip_tags($this->getRequestUserName());
    }
	
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	public function getRequestUserName() {
		//return request variable: username
		if(isset($_POST[self::$name])) {
		  $username = $_POST[self::$name];
		} else {
			$username = "";
		}
	    return $username;
	}

	public function getRequestPassword() {
		//return request variable: password
		if(isset($_POST[self::$password])) {
		    $password = $_POST[self::$password];
		} else {
			$password = "";
		}
	    return $password;
	}
	
	private function getRequestPasswordRepeat() {
		//return request variable: password
		if(isset($_POST[self::$passwordRepeat])) {
		    $passwordRepeat = $_POST[self::$passwordRepeat];
		} else {
			$passwordRepeat = "";
		}
	    return $passwordRepeat;
	}
	
}
