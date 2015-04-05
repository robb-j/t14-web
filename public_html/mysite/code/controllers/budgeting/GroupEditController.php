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
		
		$error = Session::get("GroupEditError");
		$success = Session::get("GroupEditSuccess");
		
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
		
		Session::clear("GroupEditError");
		Session::clear("GroupEditSuccess");
		
		$error = false;
		$errorMessage = "";
		
		$groupID = $data["GroupID"];
		$groupName = $data["GroupName"];
		
		$catNames = $data["CategoryNames"];
		$catBudgets = $data["CategoryBudgets"];
		
		
		$newNames = array_key_exists("NewNames", $data) ? $data["NewNames"] : array();
		$newBudgets = array_key_exists("NewBudgets", $data) ? $data["NewBudgets"] : array();
		
		$removedCats = array_key_exists("RemovedCategories", $data) ? array_keys($data["RemovedCategories"]) : array();
		
		
		$updatedCategories = array();
		foreach ($catNames as $id => $name) {
			
			$budget = $catBudgets[$id];
			
			if ( $budget == null || ! is_numeric($budget)) {
				
				$errorMessage = "'" . $budget . "' must be a number";
				$error = true;
				break;
			}
			
			$updatedCategories[$id] = array(
				"Name" => $name,
				"Budget" => $budget
			);
		}
		
		
		$newCategories = array();
		foreach ($newNames as $index => $name) {
			
			$budget = $newBudgets[$index];
			
			if ( $budget == null || ! is_numeric($budget)) {

				$errorMessage = "'" . $budget . "' must be a number";
				$error = true;
				break;
			}
			
			array_push($newCategories, array(
				"Name" => $name,
				"Budget" => $budget
			));
		}
		
		echo " Data";
		print_r($data);
		echo "<p></p>";
		
		echo " Updated";
		print_r($updatedCategories);
		echo "<p></p>";
		
		echo " New";
		print_r($newCategories);
		echo "<p></p>";
		
		echo " Removed";
		print_r($removedCats);
		echo "<p></p>";
		
		
		if ($error) {
			
			Session::set("GroupEditError", $errorMessage);
			
			return $this->redirect("budgeting/edit/group/" . $groupID);
		}
		else if ($data["Mode"] == "edit") {
			
			$output = WebApi::create()->editGroups($this->CurrentUser->ID, $groupID, $groupName, $updatedCategories, $newCategories, $removedCats);
		}
		else {
			
			// If creating do ...
			echo "<p> New </p>";
		}
		
		echo "<p>" . $output->getReason() . "</p>";
		
		
		if ($output->didPass()) {
			
			Session::set("GroupEditSuccess", "Group Successfully Edited");
			
			return $this->redirect("budgeting/edit/group/" . $groupID);
		}
		else {
			
			Session::set("GroupEditError", $output->getReason());
			
			return $this->redirect("budgeting/edit/group/" . $groupID);
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