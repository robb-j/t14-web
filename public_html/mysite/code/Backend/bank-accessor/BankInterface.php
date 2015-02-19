<?php

interface BankInterface{
	
	login( $username, $passwordBits, $indexes );
	login( $username, $password );
	loadTransactions( $userID, $month, $token );
	makeTransfer( $accountAID, $accountBID, $token );

}
?>