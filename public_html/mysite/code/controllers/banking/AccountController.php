<?php

/* A Page that displays a User's Accounts
 * The first page they'll see once thay logged in
 * Created by Rob A - feb 2015
 */
class AccountController extends BankController {
	
	
	// Set the tab title
	public $TabTitle = "banking";
	
	
	
	public function Content() {
		
		$this->NewProducts = BankAccessor::create()->getNewProductsForUser($this->CurrentUser);
		
		
		// Render the Account template
		return $this->renderWith("AccountContent");
	}
}