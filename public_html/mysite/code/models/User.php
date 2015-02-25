<?php

class User extends DataObject {

    private static $db = array(
        'FirstName' => 'Varchar(30)',
		'LastName' => 'Varchar(30)',
		'LastFullCategorise' => 'Date',
		'DOB' => 'Date',
		'Password' => 'Varchar(30)',
		'SecondPassword' => 'Varchar(30)'
    );
	private static $has_many =  array(
		'Accounts' => 'Account'
	);
}

?>