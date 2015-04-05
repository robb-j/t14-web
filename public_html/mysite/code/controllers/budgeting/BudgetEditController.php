<?php

/* A Page that lets the User edit their Budget
 * Created by Rob A - March 2015
 */
class BudgetEditController extends BankController {
	
	
	private static $allowed_actions = array(
		"DeleteGroup",
	);
	
	// Set the tab title
	public $TabTitle = "budgeting";
	
	
	public function Content() {
		
		if (array_key_exists("delete", $this->request->getVars())) {
			
			$this->DeleteID = $this->request->getVars()["delete"];
		}
		
		// Render with a template
		return $this->renderWith("BudgetEditContent");
	}
	
	public function DeleteGroup() {
		
		if (array_key_exists("group", $this->request->getVars())) {
			
			$groupID = $this->request->getVars()["group"];
			
			$output = WebApi::create()->deleteBudget($this->CurrentUser->ID, $groupID);
			
			
			if ($output->didPass() == false) {
				
				$this->ErrorMessage = $output->getReason();
				return $this->index();
			}
			else {
				
				$this->SuccessMessage = "Group successfully deleted";
			}
		}
		
		return $this->index();
	}
}