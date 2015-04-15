<?php

/* 
 * Created by Martin Smith - Feb 2015
 */
 
/*	
	This converts the information given from the website into what is needed by BankAccessor
*/
class WebApi extends Object{

	//	############################
	//	#### Basic Requirements ####
	//	############################
	
	//	This gets the username and password and creates a cookie if the login is successful
	public function login($username,$password){
	
		// null and false are because their is no indexes array and its not the mobile app logging in
		$output = BankAccessor::create()->login($username,$password,null,false);
		
		//	If the login was successful create a cookie and return the loginOutput object
		if($output->didPass()){
		
			Cookie::set('BankingSession', $output->getToken(), 0);
		}
		
		return $output;
	}
	
	//	Loads the transactions for a particular account on a particular month
	public function loadTransaction($userID, $accountID, $month, $year){
	 
		//	Adds the token from the cookie "Cookie::get('BankingSession')"
		return BankAccessor::create()->loadTransactions( $userID, $accountID, $month, $year, Cookie::get('BankingSession'));
	}
	
	//	Transfers money between 2 accounts
	public function makeTransfer($userID, $accountAID, $accountBID, $amount){
	
		//	Adds the token from the cookie "Cookie::get('BankingSession')"
		return BankAccessor::create()->makeTransfer( $userID, $accountAID, $accountBID, $amount, Cookie::get('BankingSession') );
	}
	
	// Gets the current user logged on 
	public function getCurrentUser(){
		return BankAccessor::create()->getCurrentUser();
	}
	
	// Gets a list of all products that a user doesn't already have
	public function getNewProductsForUser($user){
		return BankAccessor::create()->getNewProductsForUser($user);
	}
	
	//	Logs the user out 
	public function logout(){
	
		$accessor = BankAccessor::create();
		
		//	Gets the current user and their token
		$user = $accessor->getCurrentUser();
		$token = Cookie::get('BankingSession');
		
		//	If the logout was successful delete the cookie
		if ($accessor->logout($user->ID, $token) == 0) {
			
			Cookie::force_expiry("BankingSession");
			return true;
		}
		
		return false;
	}
	
	public function getStatementDates($userID,$accountID){
	
		return BankAccessor::create()->getStatementDates( $userID, $accountID, Cookie::get('BankingSession'));
	}
	
	//	####################################
	//	#### Intermediate  Requirements ####
	//	####################################
	
	public function newPayments($userID){
	
		//	Adds the token from the cookie "Cookie::get('BankingSession')"
		return BankAccessor::create()->newPayments( $userID, Cookie::get('BankingSession') );
	}
	
	public function categorizePayments($userID,$categorisation){
	
		//	Adds the token from the cookie "Cookie::get('BankingSession')"
		return BankAccessor::create()->categorisePayments($userID, Cookie::get('BankingSession'),$categorisation);
	}

	public function deleteBudget($userID, $groupID){
	
		//	Adds the token from the cookie "Cookie::get('BankingSession')"
		return BankAccessor::create()->deleteBudget($userID,Cookie::get('BankingSession'),$groupID);
	}
	
	public function editGroups($userID, $groupID, $groupName, $updatedCategories, $newCats, $deletedCats){
	
		//	Adds the token from the cookie "Cookie::get('BankingSession')"
		return BankAccessor::create()->editGroups($userID,Cookie::get('BankingSession'),$groupID, $groupName, $updatedCategories, $newCats, $deletedCats);
	}
	
	public function createGroup($userID, $groupName, $newCategories){
	
		//	Adds the token from the cookie "Cookie::get('BankingSession')"
		return BankAccessor::create()-> createGroup($userID,Cookie::get('BankingSession'),$groupName, $newCategories);
	}
	
	public function chooseReward($userID, $rewardID){
	
		//	Adds the token from the cookie "Cookie::get('BankingSession')"
		return BankAccessor::create()->chooseReward( $userID, Cookie::get('BankingSession') , $rewardID);
	}
	
	public function performSpin($userID){
	
		//	Adds the token from the cookie "Cookie::get('BankingSession')"
		return BankAccessor::create()->performSpin( $userID, Cookie::get('BankingSession') );
	}
	
	public function getAllRewards(){
	
		return BankAccessor::create()->getAllRewards( );
	}
	
	public function getLastPoints($userID){
	
		//	Adds the token from the cookie "Cookie::get('BankingSession')"
		return BankAccessor::create()->getLastPoints( $userID, Cookie::get('BankingSession') );
	}
	
	public function getUserCategories($userID){
	
		//	Adds the token from the cookie "Cookie::get('BankingSession')"
		return BankAccessor::create()->getUserCategories( $userID, Cookie::get('BankingSession') );
	}
	
	public function getLastRewards($userID){
	
		//	Adds the token from the cookie "Cookie::get('BankingSession')"
		return BankAccessor::create()->getLastRewards( $userID, Cookie::get('BankingSession') );
	
	}
	
	//	################################
	//	#### Advanced  Requirements ####
	//	################################
	
	public function loadATMs($userID){
	
		//	Adds the token from the cookie "Cookie::get('BankingSession')"
		return BankAccessor::create()->loadATMs( $userID, Cookie::get('BankingSession') );
	}
	
	public function loadHeatMap($userID, $accounts, $startDate, $endDate){
	
		//	Adds the token from the cookie "Cookie::get('BankingSession')"
		return BankAccessor::create()->loadHeatMap( $userID, Cookie::get('BankingSession'), $accounts, $startDate, $endDate );
	}
}
?>