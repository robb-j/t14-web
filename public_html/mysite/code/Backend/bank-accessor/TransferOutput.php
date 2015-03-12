<?php
	class TransferOutput extends Object {
		
		// The account that transactions were loaded for
		private $payerAccount;
		private $payeeAccount;
		private $amount;
		
		// Whether this interaction passed or failed
		private $didPass;
		
		private $payerNewBalance;
		private $payeeNewBalance;
		
		//This constructor takes in these parameters and sets the relevant fields
		public function __construct( $payerAccount, $payeeAccount, $ammount, $passed = false,$payerNewBalance, $payeeNewBalance  ){
		
			$this->setPayerAccount($payerAccount);
			$this->setPayeeAccount($payeeAccount);
			$this->setAmount($ammount );
			$this->setdidPass($passed);
			$this->setPayerNewBalance($payerNewBalance);
			$this->setPayeeNewBalance($payeeNewBalance);
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
			
		public function getPayerNewBalance(){
		
			return $this->payerNewBalance;
		
		}
		
		public function getPayeeNewBalance(){
		
			return $this->payeeNewBalance;
		
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
		
		private function setPayerNewBalance($payerNewBalance){
		
			$this->payerNewBalance = $payerNewBalance;
		}
		private function setPayeeNewBalance($payeeNewBalance){
		
			$this->payeeNewBalance = $payeeNewBalance;
		}
		
	}
?>
