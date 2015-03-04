<?php

/*
	This phpCrypt program is open source software found at https://github.com/gilfether/phpcrypt
	"phpCrypt is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version."
*/
include_once("phpcrypt-master/phpCrypt.php");
use PHP_Crypt\PHP_Crypt as PHP_Crypt;

class BankAccessor extends Object implements BankInterface {

		
	/*
		This function takes in: 
			The username of the user = $username, 
			The 3 characters chosen from their password = $passwordBits, 
			The locations of these 3 characters = $indexes
	  
		This function checks the password given against the one held in the database for this user
		If the password is correct then it gets an array of their accounts as well as an array of
		all products they don't currently have. Further to this it creates a new cookie for the 
		users session and adds to the UserSession table this new session with the new random 
		authentication token generated.
		
		This function outputs if successful:
			A loginOutput object which contains:
				The User object
				The Users accounts
				The Products they don't own
				The random authentication token
				If the login was successful or not
				
		This function outputs if not successful:
			A loginOutput object which contains:
				All null values except if the login
				was successful which will be false
	*/
	public function loginFromMobile( $username, $passwordBits, $indexes ){
		
		
		
		//	Check for SQL injection 
		$sanitisedUsername = Convert::raw2sql($username);
		
		//	Get pass where username = "x" it selects the first position in the array
		//	as we assume each username is unique
		$user = User::get()->filter(array(
			'Username' => $sanitisedUsername
		))[0];
		
	
		if($user !== null){
			
			//	This gets the password held in the database
			$databasePass = $user->Password;
			
			//	If the password is the correct length, there are 3 indexes and the password matches the one on the database
			if( strlen($passwordBits) === 3 && sizeof($indexes)===3 && $this->checkPasswordMobile($databasePass, $passwordBits, $indexes,$user->Username) ){
				
				//	This gets all of the accounts from the user
				$accounts = $user->Accounts();
				
				//	This gets all of the products the user doesn't already ahve
				$products = $this->getNewProductsForUser($user);
				
				//	Generate a new random authentication token
				$token = $this->generateToken();
				
				//	Set the user session
				$userSession= UserSession::create();
				$userSession->UserID = $user->ID;
				$userSession->Expiry = (Time() + 600);
				$userSession->Token = $token;
				$userSession->write();
				
				// Return a successful LoginOutput object
				return new LoginOutput($user, $accounts, $products, $token , true);
			}
			
		}
		
		// Return an unsuccessful LoginOutput object
		return new LoginOutput(null, null, null, null);
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
		if($this->checkPassword($databasePass, $password,$sanitisedUsername) === true){
		
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
			$products = $this->getNewProductsForUser($user);
			
			
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
		$sanitisedUserID = Convert::raw2sql($userID);
		$sanitisedAccountID = Convert::raw2sql($accountID);
		$sanitisedMonth = Convert::raw2sql($month);
		$sanitisedYear = Convert::raw2sql($year);
		$sanitisedToken = Convert::raw2sql($token);
		
		// Check the User is the one with the token		
		$userSession = UserSession::get()->filter(array(
			'Token' => $sanitisedToken
			))[0];
		
		if($userSession != null){
			$actaulUserID = $userSession->UserID;

			if (strcmp($actaulUserID,$sanitisedUserID)===0){
				
				$lastDay = cal_days_in_month(CAL_GREGORIAN, $sanitisedMonth, $sanitisedYear);
				$start = $sanitisedYear . '-' . $sanitisedMonth . '-0 00:00:00';
				$end = $sanitisedYear . '-' .  $sanitisedMonth . '-' . $lastDay . ' 23:59:59';
				
				$transactions = Transaction::get()->filter(
					array(
						'Date:GreaterThan' => $start,
						'Date:LessThan' => $end
					)
					);
				
				return new TransactionOutput(Account::get()->byID($sanitisedAccountID),$transactions);
				
			}
		}
		
		return new TranasctionOutput(null,null);
		
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
					
					return $userSession->User();
					
					
				}
			
			}
		
		
		}
		return null;
	}
	
	public function getNewProductsForUser($user){
	
		if($user != null){
			$products = DB::query('SELECT P.ID
								   FROM Product P 
                                   Where P.ID NOT IN  
								   (Select Product.ID 
								   From Product, User, Account
								   Where Product.ID = Account.ProductID AND User.ID = Account.UserID AND User.Username = \'' . Convert::raw2sql($user->Username)  . '\' )');

			$arrayList = new ArrayList();	
			foreach($products as $row) {
				$theRowID =  $row['ID'];
				$arrayList->push(Product::get()->byID($theRowID));
			}
			return $arrayList;
		}
		return array();
	}
	
	private function checkPassword( $databasePassword, $givenPassword,$username){
	
		$key = "pGVsJMJ6z+F7If9+M8FW7njv2NjpSr/VyeCMXSY8DrU=";
		$iv = substr(openssl_digest($username, 'sha512'), 0, 16);

		$data = $givenPassword;
		$crypt = new PHP_Crypt($key, PHP_Crypt::CIPHER_AES_256, PHP_Crypt::MODE_CBC);

		$crypt->IV($iv);
		$encrypted = $crypt->encrypt($data);
	    
		$pass = base64_encode($encrypted);
	
		$plainpass = $this->decrypt($pass,$username);
		// call the decrypt of password 
		$plaindatabasePassword = $this->decrypt($databasePassword,$username);

		// check return
		// pass back fail/pass
		if( strcmp($plaindatabasePassword, $plainpass) === 0){
			$plaindatabasePassword = "";
			return true;
		}else{
			$plaindatabasePassword = "";
			return false;
		
		}
	
		
	
	
	}
	
	private function checkPasswordMobile( $databasePassword, $givenPassword, $digits,$username){
		
		// call the decrypt of password 
		$plaindatabasePassword = $this->decrypt($databasePassword,$username);
		
		// check return with positions
		if(strcmp($plaindatabasePassword[$digits[0]],$givenPassword[0]) ===0 && 
		   strcmp($plaindatabasePassword[$digits[1]],$givenPassword[1])===0 && 
		   strcmp($plaindatabasePassword[$digits[2]],$givenPassword[2])===0){
	
	
			$plaindatabasePassword = "";
			return true;
			
		}else{
			
			$plaindatabasePassword = "";
			return false;
		}
		
		
		// pass back fail/pass
	
	}
	
	private function decrypt( $password,$username){
		
		$key = "pGVsJMJ6z+F7If9+M8FW7njv2NjpSr/VyeCMXSY8DrU=";
		//$iv = "75238a690bcb3f78";
		
		
		$iv = substr(openssl_digest($username, 'sha512'), 0, 16);
		
		$crypt = new PHP_Crypt($key, PHP_Crypt::CIPHER_AES_256, PHP_Crypt::MODE_CBC);

		$crypt->IV($iv);
		
		$decrypt = $crypt->decrypt( base64_decode($password));
		return $decrypt;
	
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