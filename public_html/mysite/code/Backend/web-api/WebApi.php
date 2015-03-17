<?php

class WebApi extends Object{

	public function login($username,$password){
	
		$output = BankAccessor::create()->login($username,$password,null,false);
		if($output->didPass()){
			Cookie::set('BankingSession', $output->getToken(), 0);
		}
		return $output;
	}
	
	public function loadTransaction($userID, $accountID, $month, $year){
	 
		return BankAccessor::create()->loadTransactions( $userID, $accountID, $month, $year, Cookie::get('BankingSession'));
	}
	
	public function makeTransfer($userID, $accountAID, $accountBID, $amount){
	
		return BankAccessor::create()->makeTransfer( $userID, $accountAID, $accountBID, $amount, Cookie::get('BankingSession') );
	}
	
	public function getNewProductsForUser($user){
		return BankAccessor::create()->getNewProductsForUser($user);
	}
	
	public function logout(){
	
		$accessor = BankAccessor::create();
		
		$user = $accessor->getCurrentUser();
		$token = Cookie::get('BankingSession');
		
		if ($accessor->logout($user->ID, $token)) {
			
			Cookie::force_expiry("BankingSession");
			return true;
		}
		return false;
	}
	
	public function getCurrentUser(){
		return BankAccessor::create()->getCurrentUser();
	}
}
?>