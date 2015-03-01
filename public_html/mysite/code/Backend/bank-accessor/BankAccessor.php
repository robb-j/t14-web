<?php

class BankAccessor extends Object implements BankInterface {

	

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
								   
								   
			
			
			//set the user session 
			$token = $this->generateToken();
			
			$userSession= UserSession::create();
			$userSession->UserID = $user->ID;
			$userSession->Expiry = (Time() + 600);
			$userSession->Token = $token;
			$userSession->write();
			
			Cookie::set('BankingSession', $token, 0);
			
			
			return new LoginOutput($user, $accounts, $products, $token , true);
		
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

								   
			//set the user session 
			$token = $this->generateToken();
			
			
			$userSession= UserSession::create();
			$userSession->UserID = $user->ID;
			$userSession->Expiry = (Time() + 600);
			$userSession->Token = $token;
			$userSession->write();
			
			Cookie::set('BankingSession', $token, 0);
			
			return new LoginOutput($user, $accounts, $products, $token, true);
		
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
	
		// Check for SQL injection
		// Check the User is the one with the token
		// get transactions by month/ year
		// return a transaction output
	
	
	}
	
	public function makeTransfer( $userID, $accountAID, $accountBID, $amount, $token ){
	
		// Check for SQL injection
		$sanitisedUserID = Convert::raw2sql($userID);
		$sanitisedAccountAID = Convert::raw2sql($accountAID);
		$sanitisedAccountBID = Convert::raw2sql($accountBID);
		$sanitisedAmount = Convert::raw2sql($amount);
		$sanitisedToken = Convert::raw2sql($token);

		// Check the User is the one with the token		
		$userSession = UserSession::get()->filter(array(
			'Token' => $sanitisedToken
			))[0];
		
		if($userSession != null){
			$actaulUserID = $userSession->UserID;

			if (strcmp($actaulUserID,$sanitisedUserID)===0){
				
				//Gets the accounts
				$accountA = Account::get()->byID($sanitisedAccountAID);
				$accountB = Account::get()->byID($sanitisedAccountBID);
		
				//Checks if the accounts are owned by the same person
				if($accountA != null && $accountA != null){
					$accountAOwner = $accountA->UserID;
					$accountBOwner = $accountB->UserID;
					
					if( $userID =!($accountAOwner && $accountBOwner)){
						return new TransferOutput(null,null,null,false);
					}
				}

				// Check the user has available funds left in accountA inc overdraft
				
				if(($accountA->Balance + $accountA->OverdraftLimit)>=$sanitisedAmount){
				
					// Transfer the money to the account
					$accountA->Balance = $accountA->Balance - amount;
					$accountA->write();
					$accountB->Balance = $accountB->Balance + amount;
					$accountB->write();
					
					// Update the user session
					$userSession->Expiry = $userSession->Expiry + 600;
					return new TransferOutput($accountA,$accountB,$sanitisedAmount,true);
				
				}
			}

		}
		return new TransferOutput(null,null,null,false);

	}
	
	
	//This function gets the current user cookie checks if there is a session and if the session still is active if so it returns the user's ID
	public function getCurrentUser(){
	
	$cookie = Cookie::get('BankingSession');
	if($cookie != null){
		
		$userSession = UserSession::get()->filter(array(
			'Token' => Convert::raw2sql($cookie)
			))[0];
		
		if($userSession != null){
			
			$expiry = $userSession->Expiry;
			
			if($expiry > Time()){
				return $userSession;
			
			}
		
		}
	
	
	}
	return null;
	
	
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
		
		return $token;
	}
}
?>