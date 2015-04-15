<?php

/* A Page that displays a User's Budget
 * Created by Rob A - March 2015
 */
class BudgetController extends BankController {
	
	
	// Set the tab title
	public $TabTitle = "budgeting";
	
	public function init() {
		
		parent::init();
		
		
		// Add some cusomt css
		Requirements::css("mysite/css/budgeting/budget.css");
	}
	
	
	public function Content() {
		
		// Calculate the budgeted, spent and remaining money of the user's budget
		$allGroups = $this->CurrentUser->Groups();
		$budgeted = 0.0;
		$spent = 0.0;
		$remaining = 0.0;
		
		
		// Loop each group
		foreach($allGroups as $group) {
			
			$allCategories = $group->Categories();
			
			// Loop the group's categories
			foreach($allCategories as $category) {
				
				// Sum up the budget and spent
				$budgeted = $budgeted + $category->Budgeted;
				$spent = $spent + $category->Balance;
			}
		}
		
		// Pass these values to the template
		$this->BudgetedAmount = $budgeted;
		$this->BudgetSpent = $spent;
		$this->BudgetLeft = $budgeted - $spent;
		
		
		// Pass the number of new payments to the template too
		$this->NumNewPayments = WebApi::create()->newPayments($this->CurrentUser->ID)->count();
		
		
		// Render with a template
		return $this->renderWith("BudgetContent");
	}
}