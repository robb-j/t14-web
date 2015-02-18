<?php

class Product extends DataObject {

    private static $db = array(
        'title' => 'varchar(50)',
		'content' => 'varchar(40)'
    );
}

?>