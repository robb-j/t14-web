<?php

/* 
 * Created by Martin Smith - Feb 2015
 */
class Transaction extends DataObject {

    private static $db = array(
        'Amount' => 'Currency',
		'Payee' => 'Varchar(50)',
		'Date' => 'Date',
		"Latitude" => "Double",
		"Longitude" => "Double",
		"IsTransfer" => "Boolean"
    );
	private static $has_one =  array(
		'Account' => 'Account',
		'Category' => 'Category'
	);
	
	private static $summary_fields = array(
		"Payee", "Amount"
	);
	
	
	public function getTitle() {
		
		return $this->Amount . ' - ' . $this->Payee;
	}
}

?>