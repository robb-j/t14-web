<?php

interface BankInterface {
	
	/*public function loginFromMobile( $username, $passwordBits, $indexes );*/
	public function login( $username, $password,$indexes, $mobile);
	public function loadTransactions( $userID, $accountID, $month, $year, $token );
	public function makeTransfer( $userID, $accountAID, $accountBID, $amount, $token );
	public function logout( $userID, $token );
	public function getCurrentUser();
}
?>