<?php

class DummyAccessor implements BankAccessor{
	
	private static $mockToken = “xl1ff9ndndj3jdmd9dn2nw91nx”;

	public function login($username, $password) {

		$passed = false;

		if ( strcmp($username, “testuser”) === 0  && strcmp($password, “password”) === 0) {

			// Just get objects from the ORM & create a token
			$products = Product::get();
			$user = User::get()->toArray()[0];

			return new LoginOutput($user, $products, $mockToken);
		}
		else {
			return new LoginOutput(“Failed to Authenticate”);
		}
	}
	
	login( $username, $passwordBits, $indexes ){
	
		if ( strcmp($username, “testuser”) === 0 ){
	
		// Just get objects from the ORM & create a token
			$products = Product::get();
			$user = User::get()->toArray()[0];

			return new LoginOutput($user, $products, $mockToken);
		}
		else {
			return new LoginOutput(“Failed to Authenticate”);
		}
	
	
	}
	
	
	loadTransactions( $userID, $month, $token ){
	
	
	}
	
	makeTransfer( $accountAID, $accountBID, $token ){
	
	
	}


}
?>