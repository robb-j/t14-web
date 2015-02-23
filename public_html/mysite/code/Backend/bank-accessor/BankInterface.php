<?php

interface BankInterface {
	
	public function loginFromMobile( $username, $passwordBits, $indexes );
	public function login( $username, $password );
	public function loadTransactions( $userID, $month, $token );
	public function makeTransfer( $accountAID, $accountBID, $token );

}
?>