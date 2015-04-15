<?php

/* 
 * Created by Rob Anderson, April 2015
 */
class Help extends DataObject {

    private static $db = array(
        'Title' => 'Varchar(50)',
		'Content' => 'HTMLText'
    );

}