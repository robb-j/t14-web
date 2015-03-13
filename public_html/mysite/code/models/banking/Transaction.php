<?php

class Transaction extends DataObject {

    private static $db = array(
        'Amount' => 'Currency',
		'Payee' => 'Varchar(50)',
		'Date' => 'Date'
    );
	private static $has_one =  array(
		'Account' => 'Account',
		'Category' => 'Category'
	);
}

?>