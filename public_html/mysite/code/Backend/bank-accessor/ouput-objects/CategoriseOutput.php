<?php
	class CategoriseOutput extends ArrayData {

		//	Stores the categories that were edited
		private $changedCategorys;
		
		// Stores the transactions that were edited
		private $changedTransactions;
		
		//	If the user get a new spin
		private $newSpin;
		
		//	How many spins they currently have
		private $currentSpins;
		
		//	Was it successful or not 
		private $successful;
		
		//	Reason if it failed
		private $reason;
		
		
		
		//This constructor takes in these parameters and sets the relevant fields
		public function __construct( $changedCategorys, $changedTransactions, $newSpin, $currentSpins, $sucessful = false, $reason){
			
			$this->setChangedCategorys($changedCategorys);
			$this->setChangedTransactions($changedTransactions);
			$this->setNewSpin($newSpin);
			$this->setCurrentSpins($currentSpins);
			$this->setSuccessful($sucessful);
			$this->setReason($reason);
		}
	
		public function getChangedCategorys() {
		
			return $this->changedCategorys;
		}
		
		public function getChangedTransactions() {
		
			return $this->changedTransactions;
		}
		
		public function allowedNewSpin() {
		
			return $this->newSpin;
		}
		
		public function getCurrentSpins() {
		
			return $this->currentSpins;
		}
		
		public function didPass() {
		
			return $this->successful;
		}
		
		public function getReason() {
		
			return $this->reason;
		}

		//These are private as once they are set we don't want them to be able to change
		private function setChangedCategorys($changedCategorys){
			
			$this->changedCategorys = $changedCategorys;
		}
		
		private function setChangedTransactions($changedTransactions){
			
			$this->changedTransactions = $changedTransactions;
		}
		
		private function setNewSpin($newSpin){
			
			$this->newSpin = $newSpin;
		}
		
		private function setCurrentSpins($currentSpins){
			
			$this->currentSpins= $currentSpins;
		}
		
		private function setSuccessful($sucessful){
			
			$this->successful = $sucessful;
		}
		
		private function setReason($reason){
			
			$this->reason = $reason;
		}
	}
?>