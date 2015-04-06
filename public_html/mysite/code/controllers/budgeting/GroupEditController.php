<?php

/* A Page that lets the User edit a Group of their Budget
 * Created by Rob A - March 2015
 */
class GroupEditController extends BankController {
	
	
	// An Action for the Form to use
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
		
		// Get Session messages from previous submissions
		$error = Session::get("GroupEditError");
		$success = Session::get("GroupEditSuccess");
		
		
		// Display the messages, if there were any
		if ($error != null) {
			
			$this->ErrorMessage = $error;
			Session::clear("GroupEditError");
		}
		if ($success != null) {
			
			$this->SuccessMessage = $success;
			Session::clear("GroupEditSuccess");
		}
		
		
		// Get the group to edit
		$groupID = $this->request->param("ID");
		$group = BudgetGroup::get()->byId($groupID);
		
		
		// Make sure we can edit this group
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
		
		// Clear previous messages
		Session::clear("GroupEditError");
		Session::clear("GroupEditSuccess");
		
		$error = false;
		$errorMessage = "";
		
		
		// Get the group ID & name
		$groupID = array_key_exists("GroupID", $data) ? $data["GroupID"] : "";
		$groupName = $data["GroupName"];
		
		
		// Get the updated names & budgets
		$catNames = array_key_exists("CategoryNames", $data) ? $data["CategoryNames"] : array();
		$catBudgets = array_key_exists("CategoryBudgets", $data) ? $data["CategoryBudgets"] : array();
		
		
		// Get the new names & budgets
		$newNames = array_key_exists("NewNames", $data) ? $data["NewNames"] : array();
		$newBudgets = array_key_exists("NewBudgets", $data) ? $data["NewBudgets"] : array();
		
		
		// Get the ids of removed categories
		$removedCats = array_key_exists("RemovedCategories", $data) ? array_keys($data["RemovedCategories"]) : array();
		
		
		// Format the category updates
		$updatedCategories = array();
		foreach ($catNames as $id => $name) {
			
			$budget = $catBudgets[$id];
			
			// Check the budget was set & cast to a float
			if ( $budget == null || ! is_numeric($budget)) {
				
				$errorMessage = "'" . $budget . "' must be a number";
				$error = true;
				break;
			}
			else {
				
				$budget = floatval($budget);
			}
			
			$updatedCategories[$id] = array(
				"Name" => $name,
				"Budget" => $budget
			);
		}
		
		
		// Format the new categories
		$newCategories = array();
		foreach ($newNames as $index => $name) {
			
			$budget = $newBudgets[$index];
			
			if ( $budget == null || ! is_numeric($budget)) {

				$errorMessage = "'" . $budget . "' must be a number";
				$error = true;
				break;
			}
			else {
				
				$budget = floatval($budget);
			}
			
			array_push($newCategories, array(
				"Name" => $name,
				"Budget" => $budget
			));
		}
		
		// If we've already error'd present that
		if ($error) {
			
			Session::set("GroupEditError", $errorMessage);
			return $this->redirect("budgeting/edit/group/" . $groupID);
		}
		else if ($data["Mode"] == "edit") {
			
			
			// Do an edit
			$output = WebApi::create()->editGroups($this->CurrentUser->ID, $groupID, $groupName, $updatedCategories, $newCategories, $removedCats);
			
			if ($output->didPass()) {
				Session::set("GroupEditSuccess", "Group Successfully Edited");
			}
			else {
				Session::set("GroupEditError", $output->getReason());
			}
			
			return $this->redirect("budgeting/edit/group/" . $groupID);
		}
		else {
			
			// Create the group
			$output = WebApi::create()->createGroup($this->CurrentUser->ID, $groupName, $newCategories);
			
			if ($output->didPass()) {
				Session::set("GroupEditSuccess", "Group Successfully Created");
				return $this->redirect("budgeting/edit/group/" . $output->getCreatedGroup()->ID);
			}
			else {
				Session::set("GroupEditError", $output->getReason());
				return $this->redirect("budgeting/edit/group/new");
			}
		}
	}
	
	
	/*
	 *	The function called by BankController's HandleForm for cancel
	 */
	public function cancelEdit($data) {
		
		// Redirect back to the edit page
		return $this->redirect("budgeting/edit");
	}
}