<?php
	class EditBudgetObject extends ArrayData {

		//	Stores the group that was edited
		private $group;
		
		// Stores the categories that were created
		private $newCategories;
		
		//	Stores the edited categories
		private $editedCategories;

		//	Was it successful or not 
		private $successful;
		
		//	Reason if it failed
		private $reason;

		//This constructor takes in these parameters and sets the relevant fields
		public function __construct( $group, $newCategories, $editedCategories, $reason, $sucessful = false){
			
			$this->setGroup($group);
			$this->setNewCategories($newCategories);
			$this->setEditedCategories($editedCategories);
			$this->setSuccessful($sucessful);
			$this->setReason($reason);
		}
	
		private function getGroup(){
			
			return $this->group ;
		}
		
		private function getNewCategories(){
			
			return $this->newCategories;
		}
		
		private function getEditedCategories(){
			
			return $this->editedCategories;
		}
		
		public function didPass() {
		
			return $this->successful;
		}
		
		public function getReason() {
		
			return $this->reason;
		}

		//These are private as once they are set we don't want them to be able to change
		private function setGroup($group){
			
			$this->group = $group;
		}
		
		private function setNewCategories($newCategories){
			
			$this->newCategories = $newCategories;
		}
		
		private function setEditedCategories($editedCategories){
			
			$this->editedCategories= $editedCategories;
		}
		
		private function setSuccessful($sucessful){
			
			$this->successful = $sucessful;
		}
		
		private function setReason($reason){
			
			$this->reason = $reason;
		}
	}
?>