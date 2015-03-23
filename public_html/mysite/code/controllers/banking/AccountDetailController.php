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
	}
	
	public function Content() {
		
		$id = $this->request->param('ID');
		$this->Account = Account::get()->byId($id);
		
		//return "Hello World, I made a controller";
		return $this->renderWith("AccountDetailContent");
	}
	
	public function AvailableBalance() {
		
	return $this->Account->Balance + $this->Account->OverdraftLimit;
	}
	
	public function CurrencyClass($value) {
		
		if ($value > 0.0) {
			
			return "currency-green";
		}
		else {
			
			return "currency-red";
		}
	}
}