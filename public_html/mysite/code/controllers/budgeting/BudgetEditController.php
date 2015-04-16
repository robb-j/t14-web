<?php

/* A Page that lets the User edit their Budget
 * Created by Rob A - March 2015
 */
class BudgetEditController extends BankController {
	
	
	private static $allowed_actions = array(
		"DeleteGroup", "ResetBudget"
	);
	
	// Set the tab title
	public $TabTitle = "budgeting";
	
	
	public function Content() {
		
		if (array_key_exists("delete", $this->request->getVars())) {
			
			$this->DeleteID = $this->request->getVars()["delete"];
		}
		
		if (array_key_exists("reset", $this->request->getVars())) {
			
			$this->Reset = "True";
		}
		
		// Render with a template
		return $this->renderWith("BudgetEditContent");
	}
	
	
	/*
	 *	An action that is called by visiting .../BudgetEditController/DeleteGroup
	 */
	public function DeleteGroup() {
		
		// Get the group id from the url's GET params
		if (array_key_exists("group", $this->request->getVars())) {
			
			
			// Delete the group
			$groupID = $this->request->getVars()["group"];
			$output = WebApi::create()->deleteBudget($this->CurrentUser->ID, $groupID);
			
			
			// If failed redirect back with an error message
			if ($output->didPass() == false) {
				
				$this->ErrorMessage = $output->getReason();
				return $this->index();
			}
			
			// Otherwise give a success message
			else {
				
				$this->SuccessMessage = "Group successfully deleted";
			}
		}
		
		return $this->index();
	}
	
	
	public function ResetBudget() {
		
		
		// Call the web api method
		$api = WebApi::create();
		$output = $api->resetBudget($api->getCurrentUser()->ID);
		
		
		// Redirect back to the user's budget
		return $this->redirect("budgeting/");
	}
}