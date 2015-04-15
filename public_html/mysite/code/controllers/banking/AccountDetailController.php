<?php

/* A Page that displays a User's Account Details
 * Gives specific information about account type and transactions
 * Created by Yifan W - feb 2015
 * Tidied by Rob A - Apr 2015
 */
class AccountDetailController extends BankController {
	
	
	// Set the tab title
	public $TabTitle = "banking";

	public function init() {
		
		parent::init();
		
		
		// Add some custom CSS
		Requirements::css('mysite/css/banking/accountdetail.css');
		
		
		// Add some javascript
		Requirements::javascript("mysite/js/AccountDetail.js");
	}
	
	public function Content() {
		
		// Create a WebApi to access the database
		$api = new WebApi();
		
		
		// Get the params from the URL
		$accountID = $this->request->param('ID');
		$month = $this->request->param('Month');
		$year = $this->request->param('Year');
		
		
		// If dates are not provided, use today
		if ($month == null) {
			$month = date('m');
		}
		
		if ($year == null) {
			$year = date('y');
		}
		
		
		// Get the relevant transactions
		$output = $api->loadTransaction($this->CurrentUser->ID, $accountID, $month, $year);
		
		
		if ($output->didPass()) {
			
			$this->FilteredTransactions = $output->getTransactions();
			$this->Account = $output->getAccount();
			
			
			// Get the filtering dates
			$this->FilterDates = $api->getStatementDates($this->CurrentUser->ID, $accountID);
			
			
			// Give the template the current filter, if we have one
			$this->CurrentFilter = new DateObject("1", $month, $year);
			
			
			return $this->renderWith("AccountDetailContent");
		}
		else {
			
			return "<div class='main-section'><h3> Failed to access Account: " . $output->getReason() . "</h3></div>";
		}
	}
	
	public function AvailableBalance() {
		
		return $this->Account->Balance + $this->Account->OverdraftLimit;
	}
}