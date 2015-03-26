<?php

/* A Page that displays a User's Account Details
 * Gives specific information about account type and transactions
 * Created by Yifan W - feb 2015
 */
class AccountDetailController extends BankController {
	
	
	// Set the tab title
	public $TabTitle = "banking";

	public function init() {
		
		parent::init();
		
		
		// Add some custom CSS
		Requirements::css('mysite/css/accountdetail.css');
		
		// Add some javascript
		Requirements::javascript("mysite/js/libs/jquery.js");
		Requirements::javascript("mysite/js/libs/bootstrap.js");
		Requirements::javascript("mysite/js/AccountDetail.js");
	}
	
	public function Content() {
		
		
		// Get the Account
		$id = $this->request->param('ID');
		$account = Account::get()->byId($id);
		$this->Account = $account;
		
		
		// Get provided month & year
		$month = $this->request->param('Month');
		$year = $this->request->param('Year');
		
		
		// If not provided, use today
		if ($month == null) {
			$month = date('m');
		}
		
		if ($year == null) {
			$year = date('y');
		}
		
		// Get the relevant transactions
		$api = new WebApi();
		$trans = $api->loadTransaction($account->UserID, $id, $month, $year);
		$this->FilteredTransactions = $trans->getTransactions();
		
		
		// Get the filtering dates
		$this->FilterDates = $api->getStatementDates($account->UserID, $account->ID);
		
		return $this->renderWith("AccountDetailContent");
	}
	
	public function AvailableBalance() {
		
		return $this->Account->Balance + $this->Account->OverdraftLimit;
	}
}