<?php

interface BankInterface {
	
	public function login( $username, $password,$indexes, $mobile);
	public function loadTransactions( $userID, $accountID, $month, $year, $token );
	public function makeTransfer( $userID, $accountAID, $accountBID, $amount, $token );
	public function getCurrentUser();
	public function getNewProductsForUser($user);
	public function logout( $userID, $token );
	
}
?>