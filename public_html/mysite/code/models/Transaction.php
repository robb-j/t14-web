<?php

class Transaction extends DataObject {

    private static $db = array(
        'Amount' => 'Double',
		'Payee' => 'Varchar(50)',
		'Date' => 'Date'
    );
	private static $has_one =  array(
		'Account' => 'Account'
	);
	
	/* http://api.silverstripe.org/2.4/class-Date.html */
}

?>