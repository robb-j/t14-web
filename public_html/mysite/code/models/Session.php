<?php

class Session extends DataObject {

    private static $db = array(
        'ID' => 'Varchar(64)',
        'Expiry' => 'Date',
    );
	private static $has_one =  array(
		'User' => 'User'
	);
}

?>