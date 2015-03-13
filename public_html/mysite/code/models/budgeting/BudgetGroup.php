<?php

/* A DataObject that represents a Group of a User's budgeting categories
 * Created by Rob A - Mar 2015
 */
 
 class BudgetGroup extends DataObject {
	 
	 private static $db = array(
		"Title" => "Varchar(24)"
	 );
	 
	 private static $has_one = array(
		"User" => "User" 
	 );
	 
	 private static $has_many = array(
		"Categories" => "Category" 
	 );
 }