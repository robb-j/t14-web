<?php
	class TransactionOutput {
		
		// The account that transactions were loaded for
		private $account;
		
		// The transactions that were loaded 
		private $transactions;
		
		//This constructor takes in these parameters and sets the relevant fields
		public function _construct( $account, $transactions ){
		
			setAccount($account)
			setTransactions($transactions)

		}
		
		public getAccount(){
			
			return $account;
			
		}
		
		public getTransactions(){
			
			return $transactions;
			
		}
		
		//These are private as once they are set we don't want them to be able to change
		private setAccount($account){
			
			$this->account = $account;
		
		}
		
		private setTransactions($transactions){
			
			$this->transactions = $transactions;
		
		}
	}
?>
