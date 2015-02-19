<?php

class Transaction extends DataObject {

    private static $db = array(
        'Amount' => 'Double',
		'Payee' => 'Varchar(50)'
    );
	private static $has_one =  array(
		'Account' => 'Account'
	);
}

?>