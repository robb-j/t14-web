<?php

/* A DataObject that represents a Reward that the user can get
 * Created by Rob A - Mar 2015
 */
 
 class Reward extends DataObject {
	 
	 private static $db = array(
		"Title" => "Varchar(30)",
		"Description" => "Text",
		"Cost" => "Int",
		"EmailContent" => "HTMLText"
	 );
	 
	 private static $summary_fields = array(
		 "Title", "Cost"
	 );
 }