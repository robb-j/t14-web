<?php
	class TransferOutput extends Object {
		
		// The account that transactions were loaded for
		private $payerAccount;
		private $payeeAccount;
		private $amount;
		
		// Whether this interaction passed or failed
		private $didPass;
		
		//This constructor takes in these parameters and sets the relevant fields
		public function __construct( $payerAccount, $payeeAccount, $ammount, $passed = false  ){
		
			$this->setPayerAccount($payerAccount);
			$this->setPayeeAccount($payeeAccount);
			$this->setAmount($ammount );
			$this->setdidPass($passed);
			
		}
		
		public function getPayerAccount(){
			
			return $this->payerAccount;
			
		}
		
		public function getPayeeAccount(){
			
			return $this->payeeAccount;
			
		}
		
		public function getAmount(){
			
			return $this->amount;
			
		}
		
		public function didPass(){
		
			return $this->didPass;
		
		}
		
		//These are private as once they are set we don't want them to be able to change
	
		public function setPayerAccount($payerAccount){
			
			$this->payerAccount = $payerAccount;
			
		}
		
		public function setPayeeAccount($payeeAccount){
			
			$this->payeeAccount = $payeeAccount;
			
		}
		
		public function setAmount($amount){
			
			$this->amount = $amount;
			
		}
		
		private function setDidPass($passed){
		
			$this->didPass = $passed;
		}
		
	}
?>
