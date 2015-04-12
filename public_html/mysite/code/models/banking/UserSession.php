<?php

/* 
 * Created by Martin Smith - Feb 2015
 */
class UserSession extends DataObject {

    private static $db = array(
        'Expiry' => 'Int',
        'Token' => 'Varchar(64)'
    );
	private static $has_one =  array(
		'User' => 'User'
	);
	
	private static $summary_fields = array(
		"ID" => "ID",
		"Token" => "Token",
		"User.Username" => "User"
	);
}

?>