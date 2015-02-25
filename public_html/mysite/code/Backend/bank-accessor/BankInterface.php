<?php

interface BankInterface {
	
	public function loginFromMobile( $username, $passwordBits, $indexes, $key );
	public function login( $username, $password, $key );
	public function loadTransactions( $userID, $accountID, $month, $year, $token, $key );
	public function makeTransfer( $userID, $accountAID, $accountBID, $amount, $token );

}
?>