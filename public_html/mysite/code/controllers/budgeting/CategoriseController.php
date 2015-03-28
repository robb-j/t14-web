<?php

/* A Page that lets the User give their payments a Category
 * Created by Rob A - March 2015
 */
class CategoriseController extends BankController {
	
	
	// Set the tab title
	public $TabTitle = "budgeting";
	
	
	public function Content() {
		
		// Render with a template
		return $this->renderWith("CategoriseContent");
	}
}