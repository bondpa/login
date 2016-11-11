# Software for handling logins

Written in PHP in Software Quality course at Linnéuniversitetet
Database settings for user database in db-config-example.php. 
Change the filename to db-config.php

## TODO: 
* handle session hijacking
* make model cleaner
* testing
* instruction on Github
* error handling
* login with cookie
* find way to get rid of this ugly: 
 if(!$this->layoutView->view->isUserNameLengthValidated()) {