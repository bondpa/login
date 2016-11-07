<?php

class RegisterView {
	private static $login = 'RegisterView::Login';
	private static $logout = 'RegisterView::Logout';
	public static $name = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $register = 'RegisterView::Register';
	private static $cookieName = 'RegisterView::CookieName';
	private static $cookiePassword = 'RegisterView::CookiePassword';
	private static $keep = 'RegisterView::KeepMeLoggedIn';
	private static $messageId = 'RegisterView::Message';
	public $isInRegisterMode = false;
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
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	private function getrequestusername() {
		//return request variable: username
		if(isset($_POST[self::$name])) {
		  $username = $_POST[self::$name];
		} else {
			$username = "";
		}
	    return $username;
	}

	private function getrequestpassword() {
		//return request variable: password
	    $password = $_post(self::$password);
	    return $password;
	}
	
}
