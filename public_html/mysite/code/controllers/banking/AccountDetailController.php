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
		
		$id = $this->request->param('ID');
		$account = Account::get()->byId($id);
		$this->Account = $account;
		$month = $this->request->param('Month');
		$year = $this->request->param('Year');
		
		if ($month == null) {
			$month = date('m');
		}
		
		if ($year == null) {
			$year = date('y');
		}
		
		$api = new WebApi();
		$trans = $api->loadTransaction($account->UserID, $id, $month, $year);
		$this->FilteredTransactions = $trans->getTransactions();
		
		return $this->renderWith("AccountDetailContent");
	}
	
	public function AvailableBalance() {
		
		return $this->Account->Balance + $this->Account->OverdraftLimit;
	}
}