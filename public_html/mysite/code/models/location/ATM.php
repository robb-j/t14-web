<?php

/* A DataObject that represents an ATM location
 * Created by Rob A - Mar 2015
 */
 
 class ATM extends DataObject {
	 
	 private static $db = array(
		"Title" => "Varchar(24)",
		"Cost" => "Currency",
		"Latitude" => "Double",
		"Longitude" => "Double"
	 );
 }