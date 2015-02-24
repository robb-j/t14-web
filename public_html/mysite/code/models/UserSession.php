<?php

class UserSession extends DataObject {

    private static $db = array(
        'Expiry' => 'Date',
        'token' => 'Varchar(64)'
    );
	private static $has_one =  array(
		'User' => 'User'
	);
}

?>