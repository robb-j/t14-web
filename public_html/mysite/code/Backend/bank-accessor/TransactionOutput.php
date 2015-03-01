<?php
	class TransactionOutput extends Object {
		
		// The account that transactions were loaded for
		private $account;
		
		// The transactions that were loaded 
		private $transactions;
		
		//This constructor takes in these parameters and sets the relevant fields
		public function __construct( $givenAccount, $givenTransactions ){
		
			$this->setAccount($givenAccount);
			$this->setTransactions($givenTransactions);

		}
		
		public function getAccount(){
			
			return $this->account;
			
		}
		
		public function getTransactions(){
			
			return $this->transactions;
			
		}
		
		//These are private as once they are set we don't want them to be able to change
		private function setAccount($givenAccount){
			
			$this->account = $givenAccount;
		
		}
		
		private function setTransactions($givenTransactions){
			
			$this->transactions = $givenTransactions;
		}
	}
?>
