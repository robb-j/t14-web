<?php

class DummyAccessor implements BankInterface {

	public function login($username, $password) {

		$passed = false;
		$mockToken = "xl1ff9ndndj3jdmd9dn2nw91nx";

		if ( strcmp($username, "testuser") === 0  && strcmp($password, "password") === 0) {

			// Just get objects from the ORM & create a token
			$products = Product::get();
			$user = User::get()->toArray()[0];
			$accounts = $user->Accounts();

			return new LoginOutput($user, $accounts, $products, $mockToken, true);
		}
		else {
			return new LoginOutput(null, null, null, null);
		}
	}
	
	public function loginFromMobile( $username, $passwordBits, $indexes ){
	
		$mockToken = "xl1ff9ndndj3jdmd9dn2nw91nx";
	
		if ( strcmp($username, "testuser") === 0 ){
	
			// Just get objects from the ORM & create a token
			$products = Product::get();
			$user = User::get()->toArray()[0];
			$accounts = $user->Accounts();

			return new LoginOutput($user, $accounts, $products, $mockToken, true);
		}
		else {
			return new LoginOutput(null, null, null, null);
		}
	
	}
	
	
	public function loadTransactions( $userID, $month, $year, $token ){
		
		
	}
	
	public function makeTransfer( $accountAID, $accountBID, $amount, $token ){
	
	
	}


}
?>