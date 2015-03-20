<?php

/*
	This phpCrypt program is open source software found at https://github.com/gilfether/phpcrypt
	"phpCrypt is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version."
*/
include_once("phpcrypt-master/phpCrypt.php");
use PHP_Crypt\PHP_Crypt as PHP_Crypt;

class BankAccessor extends Object implements BankInterface {

	//	#############################################
	//	#### Basic Requirements public functions ####
	//	#############################################

	/*
		This is the login function, it takes in the username and password given, the index array (only for the mobile app) and a bool to check if its the mobile logging in
		This returns a loginOutput object no matter if successful or not
	*/
	public function login( $username, $password, $indexes, $mobile){
	
		//	This stops SQL injection
		$sanitisedUsername = Convert::raw2sql($username);
		
		//	This gets the user associated with the username given from the database 
		$user = User::get()->filter(array(
			'Username' => $sanitisedUsername
		))[0];
		
		//	If there is no user then you can't get the password of a null value
		if($user !== null){
		
			//	Gets the password stored in the database for this user
			$databasePass = $user->Password;

			//	If the given password matches the one in the database 
			if($this->checkPassword($databasePass, $password, $sanitisedUsername, $indexes, $mobile) === true){
				
				/*
					If the user if not already logged in, then generate a new authentication token, 
					create the session in the database and return a login output object  
				*/
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
		
		//	Return an unsuccessful LoginOutput object
		return new LoginOutput(null, null, null, null,false,"Incorrect username or password");
	}

	/*
		This function taken in the userID and the session token, as well as the acountID 
		that the transactions are wanted from plus the month and year wanted
	*/
	public function loadTransactions( $userID, $accountID, $month, $year, $token ){
	
		//	This stops SQL injection
		$sanitisedUserID = Convert::raw2sql($userID);
		$sanitisedAccountID = Convert::raw2sql($accountID);
		$sanitisedMonth = Convert::raw2sql($month);
		$sanitisedYear = Convert::raw2sql($year);
		$sanitisedToken = Convert::raw2sql($token);
		
		//	Gets the user session that is associated with the token	
		$userSession = UserSession::get()->filter(array(
			'Token' => $sanitisedToken
			))[0];
		
		//	If the session exists get the UserID associated with the session
		if($userSession != null){
		
			$actaulUserID = $userSession->UserID;

			/*	
				If the userID given is the same as the one in the database and the user owns the account
				then load the transactions associated with the account given from the specified month
			*/
			if (strcmp($actaulUserID,$sanitisedUserID)===0 && strcmp($actaulUserID,Account::get()->byID($sanitisedAccountID)->UserID)=== 0){
				
				//	Gets the last day in the month specified 
				$lastDay = cal_days_in_month(CAL_GREGORIAN, $sanitisedMonth, $sanitisedYear);
				$start = $sanitisedYear . '-' . $sanitisedMonth . '-0 00:00:00';
				$end = $sanitisedYear . '-' .  $sanitisedMonth . '-' . $lastDay . ' 23:59:59';
				
				//	Load all transaction in the time frame wanted
				$transactions = Transaction::get()->filter(array(
						'Date:GreaterThan' => $start,
						'Date:LessThan' => $end,
						'AccountID' => $sanitisedAccountID
					));
				
				//	Extend the users session 
				$this->updateSession($userSession);
				
				//	Returns the account and a list of transactions
				return new TransactionOutput(Account::get()->byID($sanitisedAccountID),$transactions);
			}
		}
		
		//	Returns a failed TransactionOutput object
		return new TransactionOutput(null,null);
	}
	
	/*
		This function takes in a userID and token, as well as the accounts that money 
		will be transferred between with an amount to be transferred 
	*/
	public function makeTransfer( $userID, $accountAID, $accountBID, $amount, $token ){
	
		//	This stops SQL injection
		$sanitisedUserID = Convert::raw2sql($userID);
		$sanitisedAccountAID = Convert::raw2sql($accountAID);
		$sanitisedAccountBID = Convert::raw2sql($accountBID);
		$sanitisedAmount = Convert::raw2sql($amount);
		$sanitisedToken = Convert::raw2sql($token);

		//	Gets the user session that is associated with the token	
		$userSession = UserSession::get()->filter(array(
			'Token' => $sanitisedToken
			))[0];
		
		//	If the token is associated with an account, both accountID's are not null, the amount is >0 and they aren't the same accounts
		if($userSession != null && $sanitisedAccountAID != null && $sanitisedAccountBID != null && $sanitisedAmount>0 && $sanitisedAmount !=null && $sanitisedAccountAID != $sanitisedAccountBID ){
		
			//	Get the userID from the session
			$actaulUserID = $userSession->UserID;

			//	If the given user is the same one associated with the session
			if (strcmp($actaulUserID,$sanitisedUserID)===0){
				
				//	Gets the accounts
				$accountA = Account::get()->byID($sanitisedAccountAID);
				$accountB = Account::get()->byID($sanitisedAccountBID);
		
				//	Check if the accounts are owned by the same person
				if($accountA != null && $accountA != null){
				
					$accountAOwner = $accountA->UserID;
					$accountBOwner = $accountB->UserID;
					
					if( $userID =!($accountAOwner && $accountBOwner)){
						
						// If they are not return a failed TransferOutput
						return new TransferOutput(null,null,null,false,null,null);
					}
				}

				// Check the user has available funds left in accountA inc overdraft
				if(($accountA->Balance + $accountA->OverdraftLimit)>=$sanitisedAmount){
				
				
					// Transfer the money to and from the accounts
					$accountA->Balance = $accountA->Balance - $amount;
					$accountA->write();
					$accountB->Balance = $accountB->Balance + $amount;
					$accountB->write();
					
					//	Create a transaction for each of the accounts 
					$this->createTransaction(0-$amount, $accountB->AccountType,$accountA);
					$this->createTransaction(0+$amount, $accountA->AccountType,$accountB);

					// Update the user session
					$this->updateSession($userSession);
					
					// Returns a successful TransferOutput
					return new TransferOutput($accountA,$accountB,$sanitisedAmount,true,$accountA->Balance, $accountB->Balance );
				}
			}
		}
		
		//	Returns a failed TransferOutput
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
			
			//	Returns the compiled arrayList
			return $arrayList;
		}
		
		// returns an empy array
		return array();
	}
	
	// This function logout the user based on their userID and token
	public function logout($userID, $token){
	
		//	Gets the session associated with the ID and Token
		$userSession = UserSession::get()->filter(array(
			'UserID' => Convert::raw2sql($userID),
			'Token' => Convert::raw2sql($token)
		))[0];
		
		//	If there was such a session
		if($userSession != null){
		
			// Expire the token
			$userSession->Expiry = Time()-10;
			$userSession->write();
			
			//	Only stores the last n UserSessions for that user
			$this->deleteUserSessions($userSession->UserID);
			
			//	Return a successful logout
			return true;
		}
		
		//	return a failed logout 
		return false;
	}
	
	//	##############################################
	//	#### Basic Requirements private functions ####
	//	##############################################
	
	// This only keeps the last n userSession for the user
	private function deleteUserSessions($userID){
		
		//	Gets all of the sessions from the user and sorts them by expiry time
		$userSession = UserSession::get()->filter(array(
			'UserID' => Convert::raw2sql($userID)
		))->sort('Expiry');
	
		// Only keeps the 10 latest and deletes the rest
		$count=0;
		foreach($userSession as $session) {
		
				$count++;
				
				if($count>10){
					$session->delete();
					
				}
			}
	}
	
	//	This decides which function is used to check the users password based on if its the mobile app logging in
	private function checkPassword($databasePassword, $givenPassword, $username, $indexes, $mobile){
	
		if($mobile){
				return $this->checkPasswordMobile($databasePassword, $givenPassword, $indexes ,$username);
		}else{
		
			return $this->checkPasswordWeb( $databasePassword, $givenPassword, $username);		
		}
	}
	
	/*	
		This function taken in the password held in the database, the username
		of the person wanting to log in and the password they gave, and checks 
		if the password they gave was the same as in the database
	*/
	private function checkPasswordWeb( $databasePassword, $givenPassword,$username){
		
		//	call the decrypt of password 
		$plaindatabasePassword = $this->decrypt($databasePassword,$username);

		// If the trimmed versions of both are the same then return true else return false
		if( strcmp(trim($plaindatabasePassword), trim($givenPassword)) === 0){
			
			//	This wipes the plain text password from ram
			$plaindatabasePassword = $this->generateToken();
			return true;
		}else{
		
			//	This wipes the plain text password from ram
			$plaindatabasePassword = $this->generateToken();
			return false;		
		}
	}
	
	/*
		This checks if the password they give is the same as the one held in the database,
		but since it is the mobile it only checks the position specified in the index array
	*/
	private function checkPasswordMobile( $databasePassword, $givenPassword, $indexes ,$username){
	
		//	call the decrypt of password
		$plaindatabasePassword = $this->decrypt($databasePassword,$username);
		
		// check the password against the database one at the positions specified 
		if(strlen($givenPassword) === 3 &&  sizeof($indexes)=== 3 && 
		   is_int($indexes[0]) && is_int($indexes[1]) && is_int($indexes[2]) &&
		   strcmp($plaindatabasePassword[$indexes[0]],$givenPassword[0])===0 && 
		   strcmp($plaindatabasePassword[$indexes[1]],$givenPassword[1])===0 && 
		   strcmp($plaindatabasePassword[$indexes[2]],$givenPassword[2])===0){
	
			//	This wipes the plain text password from ram
			$plaindatabasePassword = $this->generateToken();
			return true;
			
		}else{
			
			//	This wipes the plain text password from ram
			$plaindatabasePassword = $this->generateToken();
			return false;
		}
	}

	//	This decrypts the password held in the database 
	private function decrypt( $password,$username){
		
		//	This is the key used for encryption/decryption
		$key = "pGVsJMJ6z+F7If9+M8FW7njv2NjpSr/VyeCMXSY8DrU=";
		
		//	Sets the initialisation vector from the first 16 characters of the hashed username
		$iv = substr(openssl_digest($username, 'sha512'), 0, 16);
		
		//	Created the crypt object
		$crypt = new PHP_Crypt($key, PHP_Crypt::CIPHER_AES_256, PHP_Crypt::MODE_CBC);

		//	Sets the initialisation vector
		$crypt->IV($iv);

		//	returns the decrypted version
		return $crypt->decrypt( base64_decode($password));
	}
	
	//	This generates the sudo unique authentication token
	private function generateToken(){
	
		//	Its of length 64 and is chosen from a list of the below characters
		$length = 64;
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$token = '';

		//	For 0 to the length choose a random character from the list above
		for ($i = 0; $i < $length; $i++) {
		
			$token .= $characters[mt_rand(0, strlen($characters) - 1)];
		}
		
		// Return the new token
		return $token;
	}
	
	//	This checks if the user is logged in based on the user object
	private function checkIfUserLoggedIn($user){
	
		//	Check the User is the one with the token		
		$userSession = UserSession::get()->filter(array(
			'UserID' => $user->ID
		));
			
			//	For each of the users sessions check if one is still active
			foreach($userSession as $row) {
			
				if($row->Expiry >=Time()){
				
					//	If there is one still active then return true
					return true;
				}
			}
			
			//	If non are still active return false
			return false;
	}
	
	//	This creates the session in the database based on their user object and token
	private function createSession($user, $token){
	
		//	Create a new row and fills in the relevant fields
		$userSession= UserSession::create();
		$userSession->UserID = $user->ID;
		$userSession->Expiry = (Time() + 600);
		$userSession->Token = $token;
		
		//	Then write this to the database
		$userSession->write();
		
		$this->deleteUserSessions($user->ID);
		
		return true;
	}
	
	//	Updates the users session from their session object
	private function updateSession($userSession){
	
		//	Increases the Expiry by 600 seconds
		$userSession->Expiry = $userSession->Expiry + 600;
		$userSession->write();
		
		return true;
	}
	
	//	Creates a new Transaction for an account, with the amount, the payee and the account needing the new transaction
	private function createTransaction($amount, $payee, $account){
	
		//	Create a new row and fills in the relevant fields 
		$transaction = Transaction::create();
		$transaction->Amount = $amount;
		$transaction->Payee = $payee;
		$transaction->Date = date("d M Y");
		$transaction->AccountID = $account->ID;
		
		//	Then write this to the database
		$transaction->write();

		// If this is the accounts first transaction then update the date of the first transaction carried out
		if($account->FirstTransaction === null){
			$account->FirstTransaction = date("M Y");
			$account->write();
		}
	}
	
	//	####################################################
	//	#### Intermediate Requirements public functions ####
	//	####################################################
	
	public function newPayments( $userID, $token ){
	
	}
	
	public function categorizePayments( $userID, $token, $categorizedItems ){
	
	}
	
	public function updateBudget( $userID, $token, $budgetAmount, $categoryName, $groupName){
	
	}
	
	public function chooseReward( $userID, $token, $rewardID ){
	
	}
	
	public function performSpin( $userID, $token){
	
	}	
}
?>