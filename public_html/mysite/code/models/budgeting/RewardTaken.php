<?php

/* A DataObject that represents a time when the User chose a Reward
 * Created by Rob A - Mar 2015
 */
 
 class RewardTaken extends DataObject {
	 
	 private static $db = array(
		"Date" => "Date"
	 );
	 
	 private static $has_one = array(
		"Reward" => "Reward",
		"User" => "User"
	 );
 }