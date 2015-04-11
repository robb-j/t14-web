<?php

/* 
 * Created by Martin Smith - Feb 2015
 */
interface BankInterface {
	
	//	Basic requirements
	public function login( $username, $password, $indexes, $mobile );
	public function loadTransactions( $userID, $accountID, $month, $year, $token );
	public function makeTransfer( $userID, $accountAID, $accountBID, $amount, $token );
	public function getCurrentUser();
	public function getNewProductsForUser( $user );
	public function logout( $userID, $token );
	public function getStatementDates( $userID, $accountID, $token) ;
	
	//	Intermediate requirements
	public function newPayments( $userID, $token );
	public function categorisePayments( $userID, $token, $categorisedItems );
	public function deleteBudget( $userID, $token, $groupID );
	public function editGroups( $userID, $token, $groupID, $groupName, $updatedCategories, $newCats, $deletedCats );
	public function createGroup($userID, $token, $groupName, $newCategories );
	public function chooseReward( $userID, $token, $rewardID );
	public function mobileBudgetEdit($usedID, $token, $allGroupsData);
	public function performSpin( $userID, $token );
	public function getAllRewards();
	public function getLastPoints($userID, $token );
	public function getLastRewards( $userID, $token );
	public function getUserCategories( $userID, $token );
	
	//	Advanced requirements
	public function loadATMs($userID, $token);
	public function loadHeatMap($userID, $token, $accounts, $startDate, $endDate);
}
?>