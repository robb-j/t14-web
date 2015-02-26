<?php

class BankAccessor implements BankInterface {

	public function loginFromMobile( $username, $passwordBits, $indexes ){
		
		//check for SQL injection 
		// get pass where username = ""
		//Send password to be decrypted
		//If they are equal
			// generate token
			// send back loginOutput
		//else
			// send back unsuccessful
	
	
	}
	
	public function login( $username, $password){
	
		//check for SQL injection 
		// get pass where username = ""
		$databasePass = User::get()->byUsername( $username )->Password();
		//Send password to be decrypted
		if(checkPassword($databasePass, $password)){
		
			$user = User::get()->byUsername( $username);
			$accounts = $user->Accounts();
			
			$products = DB::query('SELECT P.Title, P.Content 
								   FROM product P 
                                   Where P.ID NOT IN  
								   (Select product.ID 
								   From product, user, account
								   Where product.ID = account.ProductID AND user.ID = account.UserID AND user.username <> '$username ' )')->toArray();
								   
								   
			
			

			return new LoginOutput($user, $accounts, $products, generateToken(), true);
		
		}else{
			
			return new LoginOutput(null, null, null, null);
		
		}
		//If they are equal
			// generate token
			// send back loginOutput
		//else
			// send back unsuccessful
	
	
	}
	
	public function loadTransactions( $userID, $accountID, $month, $year, $token ){
	
	
	
	}
	
	public function makeTransfer( $userID, $accountAID, $accountBID, $amount, $token ){
	
	
	
	
	}
	
	private function checkPassword( $databasePassword, $givenPassword){
	
		$return = true;
		// call the decrypt of password 
		$plaindatabasePassword = decrypt($databasePassword);
		// check return
		// pass back fail/pass
		if( strcmp($plaindatabasePassword, $givePassword) === 0){
			$plaindatabasePassword = null;
			return $result;
		}else{
			$plaindatabasePassword = null;
			$result = false;
			return $result;
		
		}
	
		
	
	
	}
	
	private function checkPasswordMobile( $databasePassword, $givenPassword, $digits){
	
		// call the decrypt of password 
		// check return with positions
		// pass back fail/pass
	
	}
	
	private function decrypt( $password){
	
		// decrypt the AES password
		// return password
		return $password;
	
	}
	
	private function generateToken(){
	
		$token = "xl1ff9ndndj3jdmd9dn2nw91nx";
		return $token;
	
	}
	
	
}
?>