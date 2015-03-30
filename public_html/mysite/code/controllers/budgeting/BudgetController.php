<?php

/* A Page that displays a User's Budget
 * Created by Rob A - March 2015
 */
class BudgetController extends BankController {
	
	
	// Set the tab title
	public $TabTitle = "budgeting";
	
	public function init() {
		
		parent::init();
		
		Requirements::css("mysite/css/budgeting/budget.css");
	}
	
	
	public function Content() {
		
		
		$allGroups = $this->CurrentUser->Groups();
		$budgeted = 0.0;
		
		foreach($allGroups as $group) {
			
			$allCategories = $group->Categories();
			
			foreach($allCategories as $category) {
				
				$budgeted = $budgeted + $category->Budgeted;
			}
		}
		
		$this->BudgetedAmount = $budgeted;
		
		
		$this->NumNewPayments = WebApi::create()->newPayments($this->CurrentUser->ID)->count();
		
		
		
		// Render with a template
		return $this->renderWith("BudgetContent");
	}
}