<?php

class Product extends DataObject {

    private static $db = array(
        'Title' => 'Varchar(50)',
		'Content' => 'HTMLText'
    );
}

?>