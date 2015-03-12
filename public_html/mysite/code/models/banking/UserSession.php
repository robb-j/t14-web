<?php

class UserSession extends DataObject {

    private static $db = array(
        'Expiry' => 'Int',
        'Token' => 'Varchar(64)'
    );
	private static $has_one =  array(
		'User' => 'User'
	);
}

?>