<?php

interface BankInterface {
	
	//	Basic requirements
	public function login( $username, $password, $indexes, $mobile );
	public function loadTransactions( $userID, $accountID, $month, $year, $token );
	public function makeTransfer( $userID, $accountAID, $accountBID, $amount, $token );
	public function getCurrentUser();
	public function getNewProductsForUser( $user );
	public function logout( $userID, $token );
	
	//	Intermediate requirements
	public function newPayments( $userID, $token );
	public function categorisePayments( $userID, $token, $categorisedItems );
	public function updateBudget( $userID, $token, $updatedGroupNames, $updatedCategoryNames, $updatedCategoryBudget, $deletedCategories, $deletedGroups, $newCategories, $newGroups);
	public function chooseReward( $userID, $token, $rewardID );
	public function performSpin( $userID, $token);
	public function getAllRewards();
	public function getLastPoints($userID, $token);
	
	//	Advanced requirements
	public function loadATMs($userID, $token);
	public function loadHeatMap($userID, $token, $accounts, $duration);
}
?>