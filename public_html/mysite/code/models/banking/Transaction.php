<?php

class Transaction extends DataObject {

    private static $db = array(
        'Amount' => 'Currency',
		'Payee' => 'Varchar(50)',
		'Date' => 'Date',
		"Latitude" => "Double",
		"Longitude" => "Double"
    );
	private static $has_one =  array(
		'Account' => 'Account',
		'Category' => 'Category'
	);
}

?>