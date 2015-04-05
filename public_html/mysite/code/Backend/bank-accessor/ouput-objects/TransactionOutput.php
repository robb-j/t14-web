<?php

/* 
 * Created by Martin Smith - Feb 2015
 */
	class TransactionOutput extends Object {
		
		// The account that transactions were loaded for
		private $account;
		
		// The transactions that were loaded 
		private $transactions;
		
		// Whether the interaction passed or failed
		private $passed;
		
		// Why the interaction failed, if it failed
		private $reason;
		
		
		//This constructor takes in these parameters and sets the relevant fields
		public function __construct( $givenAccount, $givenTransactions, $passed = true, $reason = "" ){
		
			$this->setAccount($givenAccount);
			$this->setTransactions($givenTransactions);
			$this->setPassed($passed);
			$this->setReason($reason);
		}
		
		public function getAccount(){
			
			return $this->account;
		}
		
		public function getTransactions(){
			
			return $this->transactions;
		}
		
		public function didPass() {
			
			return $this->passed;
		}
		
		public function getReason() {
			
			return $this->reason;
		}
		
		
		
		//These are private as once they are set we don't want them to be able to change
		private function setAccount($givenAccount){
			
			$this->account = $givenAccount;
		
		}
		
		private function setTransactions($givenTransactions){
			
			$this->transactions = $givenTransactions;
		}
		
		private function setPassed($passed) {
			
			$this->passed = $passed;
		}
		
		private function setReason($reason) {
			
			$this->reason = $reason;
		}
	}
?>
