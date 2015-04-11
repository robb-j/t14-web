
<?php

/*
 *	Create by Rob A Apr 2015
 * 	The output when you perform a BankAccessor.mobileBudgetUpdate(...)
 */

class MobileBudgetEditOutput extends Object {
	
	private $groups;
	private $categories;
	private $passed;
	private $reason;
	
	
	// Creates a new MobileBudgetEdit Object
	public function MobileBudgetEditOutput($groups = null, $categories = null, $passed = true, $reason = "passed") {
		
		$this->setGroups($groups);
		$this->setCategories($categories);
		$this->setPassed($passed);
		$this->setReason($reason);
	
	}
	
	
	// Internal setters
	private function setGroups($groups) {
		$this->groups = $groups;
	}
	private function setCategories($categories) {
		$this->categories = $categories;
	}
	private function setPassed($passed) {
		$this->passed = $passed;
	}
	private function setReason($reason) {
		$this->reason = $reason;
	}
	
	
	// External getters
	public function getGroups() {
		return $this->groups;
	}
	public function getCategories() {
		return $this->categories;
	}
	public function didPass() {
		return $this->passed;
	}
	public function getReason() {
		return $this->reason;
	}

	
	
	
}

?>