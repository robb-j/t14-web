<?php

/* 
 * Created by Martin Smith - Feb 2015
 */
class Product extends DataObject {

    private static $db = array(
        'Title' => 'Varchar(50)',
		'Content' => 'HTMLText'
    );
}

?>