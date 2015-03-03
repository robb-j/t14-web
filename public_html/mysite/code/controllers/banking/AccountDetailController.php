<?php

/* A Page that displays a User's Accounts
 * The first page they'll see once thay logged in
 * Created by Rob A - feb 2015
 */
class AccountDetailController extends BankController {
	
	
	// Set the tab title
	public $TabTitle = "banking";
	
	
	
	public function Content() {
		
		return "Hello World, I made a controller";
	}
}