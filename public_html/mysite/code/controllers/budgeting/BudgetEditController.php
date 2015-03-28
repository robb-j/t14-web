<?php

/* A Page that lets the User edit their Budget
 * Created by Rob A - March 2015
 */
class BudgetEditController extends BankController {
	
	
	// Set the tab title
	public $TabTitle = "budgeting";
	
	
	public function Content() {
		
		// Render with a template
		return $this->renderWith("BudgetEditContent");
	}
}