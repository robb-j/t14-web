<?php

/* A Page that lets the User edit a Group of their Budget
 * Created by Rob A - March 2015
 */
class GroupEditController extends BankController {
	
	private static $allowed_actions = array(
		"GroupEditForm",
	);
	
	// Set the tab title
	public $TabTitle = "budgeting";
	
	
	public function init() {
		
		parent::init();
		
		
		// Add custom js
		Requirements::javascript($this->ThemeDir() . "/js/GroupEdit.js");
	}
	
	
	public function Content() {
		
		// Get the group to edit
		$groupID = $this->request->param("ID");
		$group = BudgetGroup::get()->byId($groupID);
		
		
		if ($group && $group->UserID == $this->CurrentUser->ID) {
			
			// If there is a group, set editing mode
			$this->Group = $group;
			$this->Mode = "edit";
		}
		else if ($groupID == 'new') {
			
			// If not, set to new mode
			$this->Mode = "new";
		}
		else {
			
			// Otherwise, return an error
			return "Failed to load group";
		}
		
		return $this->renderWith("GroupEditContent");
	}
	
	public function GroupEditForm($request) {
		
		// Defer the call to out parent
		return parent::HandleForm($request);
	}
	
	
	
	/*
	 *	The function called by BankController's HandleForm for submission
	 */
	public function submitEdit($data) {
		
		if ($data["Mode"] == "edit") {
			
			// If editing do ...
			echo "<p> Edit </p>";
		}
		else {
			
			// If creating do ...
			echo "<p> New </p>";
		}
		
		// Print the data for debug
		print_r($data);
	}
	
	
	/*
	 *	The function called by BankController's HandleForm for cancel
	 */
	public function cancelEdit($data) {
		
		// Redirect back to the edit page
		return $this->redirect("budgeting/edit");
	}
}