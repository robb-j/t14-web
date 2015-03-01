<?php
	class LoginOutput extends Object {
		
		//the user that was logged in
		private $user;
		
		//the accounts for the given user
		private $accounts;
		
		// All the products available
		private $allProducts;
		
		//The unique token for this session
		private $token;
		
		// Whether this interaction passed or failed
		private $didPass;
		
		
		//This constructor takes in these parameters and sets the relevant fields
		public function __construct( $user, $accounts, $allProducts, $token, $passed = false){
		
			$this->setUser($user);
			$this->setAccounts($accounts);
			$this->setAllProducts($allProducts);
			$this->setToken($token);
			$this->setdidPass($passed);
		}
		
		
		
		// Getters
		public function getUser(){
			
			return $this->user;
			
		}
		
		public function getAccounts(){
			
			return $this->accounts;
			
		}
		
		public function getToken(){
			
			return $this->token;
			
		}
		
		public function didPass(){
		
			return $this->didPass;
		
		}
		
		public function getAllProducts() {
			
			return $this->allProducts;
		}
		
		
		//These are private as once they are set we don't want them to be able to change
		private function setUser($user){
			
			$this->user = $user;
		
		}
		
		private function setAccounts($accounts){
			
			$this->accounts = $accounts;
		
		}
		
		private function setToken($token){
			
			$this->token = $token;
		
		}
		
		private function setDidPass($passed){
		
			$this->didPass = $passed;
		}
		
		private function setAllProducts($allProducts) {
			
			$this->allProducts = $allProducts;
		}
	}
?>
