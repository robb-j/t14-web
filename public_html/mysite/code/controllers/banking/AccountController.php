<?php

/* A Page that displays a User's Accounts
 * The first page they'll see once thay logged in
 * Created by Rob A - feb 2015
 */
class AccountController extends BankController {
	
	
	private static $allowed_actions = array(
		"Logout"
	);
	
	
	
	// Set the tab title
	public $TabTitle = "banking";
	
	
	
	public function Content() {
		
		// Pass the new products to the template
		$this->NewProducts = WebApi::create()->getNewProductsForUser($this->CurrentUser);
		
		
		// Render the Account template
		return $this->renderWith("AccountContent");
	}
	
	public function Logout() {
		
		// Perform the logut
		WebApi::create()->logout();
		
		
		// Redirect to login screen
		return $this->redirect("login/");
	}
}