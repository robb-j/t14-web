<?php
	class LoginOutput {
		
		//the user that was logged in
		private $user;
		
		//the accounts for the given user
		private $accounts;
		
		//The unique token for this session
		private $token;
		
		//This constructor takes in these parameters and sets the relevant fields
		public function _construct( $user, $accounts, $token ){
		
			setUser($user);
			setAccount($accounts)
			setToken($token)

		}
		
		public getUser(){
			
			return $user;
			
		}
		
		public getAccount(){
			
			return $account;
			
		}
		
		public getToken(){
			
			return $token;
			
		}
		
		//These are private as once they are set we don't want them to be able to change
		private setUser($user){
			
			$this->user = $user;
		
		}
		
		private setAccounts($accounts){
			
			$this->accounts = $accounts;
		
		}
		
		private setToken($token){
			
			$this->token = $token;
		
		}
	}
?>
