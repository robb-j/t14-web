<?php

class Transaction extends DataObject {

    private static $db = array(
        'amount' => 'double',
		'payee' => 'Varchar(50)'
    );
	private static $has_one =  array(
		'account' => 'Account'
	);
}

?>