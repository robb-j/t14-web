<?php

class BankAccessor implements BankInterface {

	

	public function loginFromMobile( $username, $passwordBits, $indexes ){
		
		//check for SQL injection 
		$sanitisedUsername = Convert::raw2sql($username);
		
		// get pass where username = ""
		$databasePass = User::get()->filter(array(
			'Username' => $sanitisedUsername
		))[0];
		
		//If there is no user then you can't get the password of a null value
		if($databasePass !== null){
			$databasePass = $databasePass->Password;
		}
		
		//Send password to be decrypted
		if( strlen($passwordBits) === 3 && sizeof($indexes)===3 && $this->checkPasswordMobile($databasePass, $passwordBits, $indexes) ){
		
			$user = User::get()->filter(array(
			'Username' => $sanitisedUsername
			))[0];
			
			$accounts = $user->Accounts();
			
			$products = DB::query('SELECT P.Title, P.Content 
								   FROM product P 
                                   Where P.ID NOT IN  
								   (Select product.ID 
								   From product, user, account
								   Where product.ID = account.ProductID AND user.ID = account.UserID AND user.username <> \'' . Convert::raw2sql($sanitisedUsername)  . '\' )');
								   
								   
			
			

			return new LoginOutput($user, $accounts, $products, $this->generateToken(), true);
		
		}else{
			
			return new LoginOutput(null, null, null, null);
		
		}
		//If they are equal
			// generate token
			// send back loginOutput
		//else
			// send back unsuccessful
	
	
	}
	
	public function login( $username, $password){
	
		//check for SQL injection 
		$sanitisedUsername = Convert::raw2sql($username);
		
		$databasePass = User::get()->filter(array(
			'Username' => $sanitisedUsername
		))[0];
		
		//If there is no user then you can't get the password of a null value
		if($databasePass !== null){
			$databasePass = $databasePass->Password;
		}

		//Send password to be decrypted
		if($this->checkPassword($databasePass, $password) === true){
		
			//This returns the first user as we are assuming there is no duplicate usernames
			$user = User::get()->filter(array(
			'Username' => $sanitisedUsername
			))[0];
			
			//This returns a HasManyList use [x] to access elements
			$accounts = $user->Accounts();
			
			/*
			*
			* This is broken not sure how to fix it 
			*
			*/
			$products = DB::query('SELECT P.Title, P.Content 
								   FROM Product P 
                                   Where P.ID NOT IN  
								   (Select Product.ID 
								   From Product, User, Account
								   Where Product.ID = Account.ProductID AND User.ID = Account.UserID AND User.Username <> \'' . $sanitisedUsername  . '\' )');

			return new LoginOutput($user, $accounts, $products, $this->generateToken(), true);
		
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
	
		// call the decrypt of password 
		$plaindatabasePassword = $this->decrypt($databasePassword);
		// check return
		// pass back fail/pass
		if( strcmp($plaindatabasePassword, $givenPassword) === 0){
			$plaindatabasePassword = null;
			return true;
		}else{
			$plaindatabasePassword = null;
			return false;
		
		}
	
		
	
	
	}
	
	private function checkPasswordMobile( $databasePassword, $givenPassword, $digits){
	
		// call the decrypt of password 
		$plaindatabasePassword = $this->decrypt($databasePassword);
		// check return with positions
		
		if(strcmp($plaindatabasePassword{$digits[0]},$givenPassword[0]) ===0 && 
		   strcmp($plaindatabasePassword{$digits[1]},$givenPassword[1])===0 && 
		   strcmp($plaindatabasePassword{$digits[2]},$givenPassword[2])===0){
		
			$plaindatabasePassword = null;
			return true;
		}else{
			$plaindatabasePassword = null;
			return false;
		
		}
		
		
		// pass back fail/pass
	
	}
	
	private function decrypt( $password){
	
		// decrypt the AES password
		// return password
		return $password;
	
	}
	
	private function generateToken(){
	
		$length =64;
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$token = '';

		for ($i = 0; $i < $length; $i++) {
			$token .= $characters[mt_rand(0, strlen($characters) - 1)];
		}

    

		echo"|".$token."|";
		return $token;
	}
}
?>