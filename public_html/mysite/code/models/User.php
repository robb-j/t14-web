<?php

class User extends DataObject {

    private static $db = array(
        'firstName' => 'Varchar(30)',
		'lastName' => 'Varchar(30)',
		'lastFullCategorise' => 'date',
		'dob' => 'date'
    );
	private static $has_many =  array(
		'Accounts' => 'Account'
	);
}

?>