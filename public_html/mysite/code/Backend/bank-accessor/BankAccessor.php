<?php

/*
	This phpCrypt program is open source software found at https://github.com/gilfether/phpcrypt
	"phpCrypt is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version."
*/
include_once("phpcrypt-master/phpCrypt.php");
use PHP_Crypt\PHP_Crypt as PHP_Crypt;

class BankAccessor extends Object implements BankInterface {

	public function login( $username, $password, $indexes, $mobile){
	
		//check for SQL injection 
		$sanitisedUsername = Convert::raw2sql($username);
		
		$user = User::get()->filter(array(
			'Username' => $sanitisedUsername
		))[0];
		
		//If there is no user then you can't get the password of a null value
		if($user !== null){
		
			$databasePass = $user->Password;

			//Send password to be decrypted
			if($this->checkPassword($databasePass, $password, $sanitisedUsername, $indexes, $mobile) === true){
				
				if( !$this->checkIfUserLoggedIn($user)){

					$token = $this->generateToken();

					$this->createSession($user, $token);
					
					return new LoginOutput($user, $user->Accounts(), $this->getNewProductsForUser($user), $token, true,"Success");
				}else{
				
					//	Return an unsuccessful LoginOutput object
					return new LoginOutput(null, null, null, null,false,"You are already logged in!");
				}
			}
		}

		return new LoginOutput(null, null, null, null,false,"Incorrect username or password");
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
				
				$transactions = Transaction::get()->filter(array(
						'Date:GreaterThan' => $start,
						'Date:LessThan' => $end
					));
					
				$this->updateSession($userSession);
				
				return new TransactionOutput(Account::get()->byID($sanitisedAccountID),$transactions);
			}
		}
		
		return new TranasctionOutput(null,null);
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
		
		if($userSession != null && $sanitisedAccountAID != null && $sanitisedAccountBID != null && $sanitisedAmount>=0 && $sanitisedAmount !=null ){
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
						return new TransferOutput(null,null,null,false,null,null);
					}
				}

				// Check the user has available funds left in accountA inc overdraft
				
				if(($accountA->Balance + $accountA->OverdraftLimit)>=$sanitisedAmount){
				
				
					// Transfer the money to the account
					$accountA->Balance = $accountA->Balance - $amount;
					$accountA->write();
					$accountB->Balance = $accountB->Balance + $amount;
					$accountB->write();
					
					$this->createTransaction(0-$amount, $accountB->AccountType,$accountA);
					$this->createTransaction(0+$amount, $accountA->AccountType,$accountB);

					// Update the user session
					$this->updateSession($userSession);
					
					return new TransferOutput($accountA,$accountB,$sanitisedAmount,true,$accountA->Balance, $accountB->Balance );
				
				}
			}

		}
		return new TransferOutput(null,null,null,false,null,null);
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
	
	//	This function compiles an array list of all the products a user doesn't currently have
	public function getNewProductsForUser($user){
	
		if($user != null){
		
			//	This query gets a list off all products the user has and removes them from the list of all products
			$products = DB::query('SELECT P.ID
								   FROM Product P 
                                   Where P.ID NOT IN  
								   (Select Product.ID 
								   From Product, User, Account
								   Where Product.ID = Account.ProductID AND User.ID = Account.UserID AND User.Username = \'' . Convert::raw2sql($user->Username)  . '\' )');

			// This ceates and array list with the products from the above query
			$arrayList = new ArrayList();	
			
			foreach($products as $row) {
			
				$theRowID =  $row['ID'];
				$arrayList->push(Product::get()->byID($theRowID));
			}
			
			return $arrayList;
		}
		
		return array();
	}
	
	public function logout($userID, $token){
	
		$userSession = UserSession::get()->filter(array(
			'UserID' => Convert::raw2sql($userID),
			'Token' => Convert::raw2sql($token)
		))[0];
		
		if($userSession != null){
			$userSession->Expiry = Time()-10;
			$userSession->write();
			
			//Only stores the last n UserSessions for that user
			$this->deleteUserSessions($userSession->UserID);
			
			return true;
		}
		return false;
	
	}
	
	private function deleteUserSessions($userID){
		
		$userSession = UserSession::get()->filter(array(
			'UserID' => Convert::raw2sql($userID)
		))->sort('Expiry');
	
		$count=0;
		foreach($userSession as $session) {
				$count++;
				if($count>10){
					$session->delete();
					
				}
			}
	
	
	}
	
	private function checkPasswordWeb( $databasePassword, $givenPassword,$username){
		
		// call the decrypt of password 
		$plaindatabasePassword = $this->decrypt($databasePassword,$username);

		if( strcmp(trim($plaindatabasePassword), trim($givenPassword)) === 0){
			$plaindatabasePassword = "";
			return true;
		}else{
			$plaindatabasePassword = "";
			return false;		
		}
	}
	
	private function checkPasswordMobile( $databasePassword, $givenPassword, $indexes ,$username){
		// call the decrypt of password 
		$plaindatabasePassword = $this->decrypt($databasePassword,$username);
		
		// check return with positions
		if(strlen($givenPassword) === 3 &&  sizeof($indexes)=== 3 && 
		   is_int($indexes[0]) && is_int($indexes[1]) && is_int($indexes[2]) &&
		   strcmp($plaindatabasePassword[$indexes[0]],$givenPassword[0])===0 && 
		   strcmp($plaindatabasePassword[$indexes[1]],$givenPassword[1])===0 && 
		   strcmp($plaindatabasePassword[$indexes[2]],$givenPassword[2])===0){
	
	
			$plaindatabasePassword = "";
			return true;
			
		}else{
			
			$plaindatabasePassword = "";
			return false;
		}
	}
	
	
	
	private function checkPassword($databasePassword, $givenPassword, $username, $indexes, $mobile){
	
		if($mobile){
				return $this->checkPasswordMobile($databasePassword, $givenPassword, $indexes ,$username);
		}else{
		
			return $this->checkPasswordWeb( $databasePassword, $givenPassword, $username);		
		}
	}
	
	
	
	private function decrypt( $password,$username){
		
		$key = "pGVsJMJ6z+F7If9+M8FW7njv2NjpSr/VyeCMXSY8DrU=";
		
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
	private function checkIfUserLoggedIn($user){
		// Check the User is the one with the token		
		$userSession = UserSession::get()->filter(array(
			'UserID' => $user->ID
		));
			
			
			$count = 0;
			foreach($userSession as $row) {
			
				if($userSession[$count]->Expiry >=Time()){
				
					return true;
				}
				
				$count++;
			}
			
			return false;
	}
	
	private function createSession($user, $token){
	
		$userSession= UserSession::create();
		$userSession->UserID = $user->ID;
		$userSession->Expiry = (Time() + 600);
		$userSession->Token = $token;
		$userSession->write();
		
		return true;
	}
	
	private function updateSession($userSession){
	
		// Update the user session
		$userSession->Expiry = $userSession->Expiry + 600;
		$userSession->write();
		
		return true;
	}
	
	private function createTransaction($amount, $payee, $account){
	
		$transaction = Transaction::create();
		$transaction->Amount = $amount;
		$transaction->Payee = $payee;
		$transaction->Date = date("d M Y");
		$transaction->AccountID = $account->ID;
		$transaction->write();

		if($account->FirstTransaction === null){
			$account->FirstTransaction = date("M Y");
			$account->write();
			
		}
	}
}
?>