<?php

/* 
 * Created by Martin Smith - Feb 2015
 */
class Account extends DataObject {

    private static $db = array(
        'AccountType' => 'Varchar(50)',
		'OverdraftLimit' => 'Currency',
		'Balance' => 'Currency',
		'FirstTransaction' => 'Date'
    );
	private static $has_one =  array(
		'User' => 'User',
		'Product' => 'Product'
	);
	private static $has_many = array(
		'Transactions' => 'Transaction'
	);
	
	
	public static $summary_fields = array(
		"AccountType" => "Title",
		"Product.Title" => "Product",
		"Balance" => "Balance",
		"Transactions.count" => "Transactions"
	);
	
	
	public function getTitle() {
		
		return $this->AccountType;
	}

	
}

?>