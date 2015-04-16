<?php

/* 
 * Created by Martin Smith - Mar 2015
 */
	class BudgetUpdate extends Object {
		
		//	The updated groups
		private $updatedGroups;
		
		//	The updated categories
		private $updatedCats;
		
		//	If the task was successful
		private $successful;
		
		
		
		//This constructor takes in these parameters and sets the relevant fields
		public function __construct( $updatedGroups, $updatedCategories, $passed = false){
		
			$this->setUpdatedGroups($updatedGroups);
			$this->setUpdatedCats($updatedCategories);
			$this->setSuccessful($passed);
		}

		// Getters
		public function getUpdatedGroups(){
			
			return $this->updatedGroups;
		}
		
		public function getUpdatedCats(){
			
			return $this->updatedCats;
		}
		
		public function didPass(){
			
			return $this->successful;
		}
		
		//These are private as once they are set we don't want them to be able to change
		private function setUpdatedGroups($updatedGroups){
			
			$this->updatedGroups = $updatedGroups;
		}
		
		private function setUpdatedCats($updatedCategories){
			
			$this->updatedCategories = $updatedCategories;
		}
		
		private function setUpdatedSuccessful($passed){
			
			$this->successful = $passed;
		}
	}
?>