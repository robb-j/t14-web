<?php

/* A Page that displays a User's Budget
 * Created by Rob A - March 2015
 */
class BudgetController extends BankController {
	
	
	// Set the tab title
	public $TabTitle = "budgeting";
	
	
	public function Content() {
		
		// Render with a template
		return $this->renderWith("BudgetContent");
	}
}