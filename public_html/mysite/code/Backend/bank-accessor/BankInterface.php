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
	public function categorizePayments( $userID, $token, $categorizedItems );
	public function updateBudget( $userID, $token, $budgetAmount, $categoryName, $groupName);
	public function chooseReward( $userID, $token, $rewardID );
	public function performSpin( $userID, $token);
	
	//	Advanced requirements
	
}
?>