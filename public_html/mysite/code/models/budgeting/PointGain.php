<?php

/* A DataObject that represents a time when a user was given points
 * Created by Rob A - Mar 2015
 */
 
 class PointGain extends DataObject {
	 
	 private static $db = array(
		"Title" => "Varchar(24)",
		"Date" => "Date",
		"Description" => "Text",
		"Points" => "Int"
	 );
	 
	 private static $has_one = array(
		"User" => "User" 
	 );
 }