<?php

/* 
 * Created by Martin Smith - Mar 2015
 */
	class CreateBudgetObject extends ArrayData {
		
		//	Stores the newly created categories
		private $newCats;
		
		//	Stores the created group object
		private $createdGroup;
		
		//	Was it successful or not 
		private $successful;
		
		//	Reason if it failed
		private $reason;
		
		
		
		//This constructor takes in these parameters and sets the relevant fields
		public function __construct( $createdGroup, $newCats, $reason, $sucessful = false){
			
			$this->setNewCats($newCats);
			$this->setCreatedGroup($createdGroup);
			$this->setSuccessful($sucessful);
			$this->setReason($reason);
		}
	
		public function getNewCats(){
			
			return $this->newCats;
		}
		
		public function getCreatedGroup(){
			
			return $this->createdGroup;
		}
		
		public function didPass() {
		
			return $this->successful;
		}
		
		public function getReason() {
		
			return $this->reason;
		}

		//These are private as once they are set we don't want them to be able to change
		private function setNewCats($newCats){
			
			$this->newCats = $newCats;
		}
		
		private function setCreatedGroup($createdGroup){
			
			$this->createdGroup = $createdGroup;
		}
		
		private function setSuccessful($sucessful){
			
			$this->successful = $sucessful;
		}
		
		private function setReason($reason){
			
			$this->reason = $reason;
		}
	}
?>