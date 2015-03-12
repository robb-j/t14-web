<?php

class Account extends DataObject {

    private static $db = array(
        'AccountType' => 'Varchar(50)',
		'OverdraftLimit' => 'Currency',
		'Balance' => 'Currency',
		'FirstTransaction' => 'Date'
    );
	private static $has_one =  array(
		'User' => 'User',
		'Product' => 'Product'
	);
	private static $has_many = array(
		'Transactions' => 'Transaction'
	);

	
}

?>