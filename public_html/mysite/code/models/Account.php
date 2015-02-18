<?php

class Account extends DataObject {

    private static $db = array(
        'accountType' => 'Varchar(50)',
		'overdraftLimit' => 'int',
		'balance' => 'double'
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