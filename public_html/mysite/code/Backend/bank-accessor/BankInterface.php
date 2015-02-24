<?php

interface BankInterface {
	
	public function loginFromMobile( $username, $passwordBits, $indexes );
	public function login( $username, $password );
	public function loadTransactions( $userID, $accountID, $month, $year, $token );
	public function makeTransfer( $userID, $accountAID, $accountBID, $amount, $token );

}
?>