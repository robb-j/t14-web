<?php

/* 
 * Created by Martin Smith - Mar 2015
 */
	class DeletedBudgetObject extends ArrayData {

		//	Was it successful or not 
		private $successful;
		
		//	Reason if it failed
		private $reason;
		
		
		
		//This constructor takes in these parameters and sets the relevant fields
		public function __construct( $reason, $sucessful = false){

			$this->setSuccessful($sucessful);
			$this->setReason($reason);
		}
		
		public function didPass() {
		
			return $this->successful;
		}
		
		public function getReason() {
		
			return $this->reason;
		}

		//These are private as once they are set we don't want them to be able to change
		private function setSuccessful($sucessful){
			
			$this->successful = $sucessful;
		}
		
		private function setReason($reason){
			
			$this->reason = $reason;
		}
	}
?>