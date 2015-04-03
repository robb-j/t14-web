<?php
	class CategoriseOutput extends ArrayData {

		//	Stores the categories that were edited
		$changedCategorys;
		
		//	If the user get a new spin
		$newSpin;
		
		//	How many spins they currently have
		$currentSpins;
		
		//	Was it successful or not 
		$successful;
		
		//This constructor takes in these parameters and sets the relevant fields
		public function __construct( $changedCategorys, $newSpin, $currentSpins, $sucessful){
			
			$this->setChangedCategorys($changedCategorys);
			$this->setNewSpin($newSpin);
			$this->setCurrentSpins($currentSpins);
			$this->setSuccessful($sucessful);
		}
	
		public function getChangedCategorys() {
		
			return $this->changedCategorys;
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

		//These are private as once they are set we don't want them to be able to change
		private function setChangedCategorys($changedCategorys){
			
			$this->changedCategorys = $changedCategorys;
		}
		
		private function setNewSpin($newSpin){
			
			$this->newSpin = $newSpin;
		}
		
		private function setCurrentSpins($currentSpins){
			
			$this->currentSpins= $currentSpins;
		}
		
		private function setSuccessful($sucessful){
			
			$this->sucessful = $sucessful;
		}
	}
?>