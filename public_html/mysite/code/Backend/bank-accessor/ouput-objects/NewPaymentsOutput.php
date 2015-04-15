<?php

/* 
 * Created by Martin Smith - Feb 2015
 */
	class NewPaymentsOutput extends Object {
		
		//Array of payments
		private $payments;
		
		// Whether this interaction passed or failed
		private $didPass;
		
		private $reason;
		
		
		//This constructor takes in these parameters and sets the relevant fields
		public function __construct( $payments, $passed = false, $reason){
		
			$this->setPayments($payments);
			$this->setdidPass($passed);
			$this->setReason($reason);
		}

		// Getters
		public function getPayments(){
			
			return $this->payments;
			
		}
		
		public function didPass(){
		
			return $this->didPass;
		
		}

		public function getReason(){
			
			return $this->reason;
		}
		
		
		//These are private as once they are set we don't want them to be able to change
		private function setPayments($payments){
			
			$this->payments = $payments;
		
		}

		private function setDidPass($passed){
		
			$this->didPass = $passed;
		}

		private function setReason($reason){
		
			$this->reason = $reason;
		}
	}
?>
