<?php

/* A DataObject that represents a budgeting category that a user has
 * Created by Rob A - Mar 2015
 */
 
 class Category extends DataObject {
	 
	 private static $db = array(
		"Title" => "Varchar(24)",
		"Budgeted" => "Currency",
		"Balance" => "Currency"
	 );
	 
	 private static $has_one = array(
		 "Group" => "BudgetGroup"
	 );
 }