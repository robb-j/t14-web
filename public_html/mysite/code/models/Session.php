<?php

class Session extends DataObject {

    private static $db = array(
        'Expiry' => 'Date',
    );
	private static $has_one =  array(
		'User' => 'User'
	);
}

?>