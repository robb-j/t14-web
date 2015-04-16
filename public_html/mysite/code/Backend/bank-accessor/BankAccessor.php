<?php

/* 
 * Created by Martin Smith - Feb 2015
 */
 
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
				
					//	If the user is already logged in somewhere else end that session
					$userSession = UserSession::get()->filter(array(
						"UserID" => $user->ID,
						'Expiry:GreaterThan' => time()
					))[0];
					
					//	Create the new session
					$userSession->Expiry = time() -10;
					$userSession->write();
					
					$token = $this->generateToken();
					
					$this->createSession($user, $token);

					return new LoginOutput($user, $user->Accounts(), $this->getNewProductsForUser($user), $token, true,"Success");
					
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
		
		//	Gets the user session that is associated with the token	
		$userSession = $this->checkUserSession($userID,$token);
		$theAccount = Account::get()->byID($sanitisedAccountID);
		//	If the session exists get the UserID associated with the session
		if($userSession != null && $theAccount != null){
		
			$actaulUserID = $userSession->UserID;
			/*	
				If the userID given is the same as the one in the database and the user owns the account
				then load the transactions associated with the account given from the specified month
			*/
			if ( strcmp($actaulUserID,$theAccount->UserID)=== 0 && is_numeric($sanitisedMonth) && 
			is_numeric($sanitisedYear) &&  $sanitisedMonth >=1 && $sanitisedMonth<=12 && $sanitisedYear >0){
				
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
		return new TransactionOutput(null,null, false, "You do not own this Account");
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
		$userSession = $this->checkUserSession($userID,$token);
		
		//	If the token is associated with an account, both accountID's are not null, the amount is >0 and they aren't the same accounts
		if($userSession != null && $sanitisedAccountAID != null && $sanitisedAccountBID != null && $sanitisedAmount>0 && $sanitisedAmount !=null && $sanitisedAccountAID != $sanitisedAccountBID ){
		
			//	Get the userID from the session
			$actaulUserID = $userSession->UserID;

			//	Gets the accounts
			$accountA = Account::get()->byID($sanitisedAccountAID);
			$accountB = Account::get()->byID($sanitisedAccountBID);
	
			//	Check if the accounts are owned by the same person
			if($accountA !== null && $accountB !== null){
			
				$accountAOwner = $accountA->UserID;
				$accountBOwner = $accountB->UserID;
				
				if( $actaulUserID !== $accountAOwner || $actaulUserID !== $accountBOwner){
					
					// If they are not return a failed TransferOutput
					return new TransferOutput(null,null,null,false,null,null);
				}
			
		
				// Check the user has available funds left in accountA inc overdraft
				if(($accountA->Balance + $accountA->OverdraftLimit)>=$sanitisedAmount){
				
				
					// Transfer the money to and from the accounts
					$accountA->Balance = $accountA->Balance - $amount;
					$accountA->write();
					$accountB->Balance = $accountB->Balance + $amount;
					$accountB->write();
					
					//	Create a transaction for each of the accounts 
					$this->createTransaction(0-$amount, $accountB->AccountType,$accountA,"to");
					$this->createTransaction(0+$amount, $accountA->AccountType,$accountB,"from");

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
			
			$userSession = $this->getUserSession($cookie);
			
			if($userSession != null){
				
				$expiry = $userSession->Expiry;
				
				if($expiry > Time()){
					
					$this->updateSession($userSession);
					
					return $userSession->User();
				}
			}
		}
		return null;
	}
	
	//	This function compiles an array list of all the products a user doesn't currently have
	public function getNewProductsForUser($user){
	
		
		if($user != null &&  is_object( $user)){
			$sanitisedUser =Convert::raw2sql($user->Username);
			//	This query gets a list off all products the user has and removes them from the list of all products
			$products = DB::query('SELECT P.ID
								   FROM Product P 
                                   Where P.ID NOT IN  
								   (Select Product.ID 
								   From Product, User, Account
								   Where Product.ID = Account.ProductID AND User.ID = Account.UserID AND User.Username = \'' . $sanitisedUser  . '\' )');

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
		
			//	If the session has already not expired
			if($userSession->Expiry < time()){
			
				return 1;
			}else{
			
				// Expire the token
				$userSession->Expiry = Time()-10;
				$userSession->write();
				
				//	Only stores the last n UserSessions for that user
				$this->deleteUserSessions($userSession->UserID);
				
				//	Return a successful logout
				return 0;
			}
		}
		
		//	return a failed logout 
		return 2;
	}
	
	public function getStatementDates($userID, $accountID, $token){
	
		//	This stops SQL injection
		$sanitisedUserID = Convert::raw2sql($userID);
		$sanitisedAccountID = Convert::raw2sql($accountID);

		
		//	Gets the user session that is associated with the token	
		$userSession = $this->checkUserSession($userID,$token);
		$theAccount = Account::get()->byID($sanitisedAccountID);
		
		//	If the session exists get the UserID associated with the session
		if($userSession != null && $theAccount != null){
		
			$actaulUserID = $userSession->UserID;
	
			//	If the userID given is the same as the one in the database and the user owns the account
			if (strcmp($actaulUserID,$theAccount->UserID)=== 0){
			
				//	If they have transactions
				if(	$theAccount->FirstTransaction !=null){
				
					//	Get all of the transactions from that account and sort by the date
					$allTransactions = Transaction::get()->filter(array(
						'AccountID' => $sanitisedAccountID
					))->sort('Date');
					
					$allDates = new ArrayList();
					
					//	For everyone of the transactions found
					foreach($allTransactions as $transaction){
					
						$found = false;
						$count = 0;
						
						//	Split the date up
						$arrayExploded = explode('-',$transaction->Date);
						
						//	While the month not found and not at the end of the array
						while ($found !== true && $count < sizeof($allDates)){
						
							//	If the month/year is found move on 
							if ($allDates[$count]->getMonth() === $arrayExploded[1] &&  $allDates[$count]->getYear() === $arrayExploded[0]){
							
								$found = true;
							}
							
							$count++;
						}
						
						//	If the month/year wasn't found add it to the array of all statement dates
						if($found !=true){
						
							$allDates->push(new DateObject($arrayExploded[2],$arrayExploded[1],$arrayExploded[0]));
						
						}
					}
					
					// Update the user session
					$this->updateSession($userSession);
			
					return $allDates;
				}
			}
		}
		return array();
	}
	
	//Checks if the user session is still active
	public function checkSessionActive($userID,$token){
	
		$output = $this->checkUserSession($userID, $token);

		if($output === null){
		
			return false;
		
		}else{
		
			return true;
		}
		
	}
	
	
	//	##############################################
	//	#### Basic Requirements private functions ####
	//	##############################################
	
	//	Checks if the users session is still valid
	private function checkUserSession($userID, $token){
	
		//	Gets the user session that is associated with the token	
		$userSession = UserSession::get()->filter(array(
			'Token' => Convert::raw2sql($token)
			))[0]; 
			
		if($userSession !== null && $userSession->UserID !== null &&
		   $userID != null && strcmp($userSession->UserID,$userID)===0 &&
		   $userSession->Expiry !== null && 
		   DateTime::createFromFormat("U", "$userSession->Expiry")->getTimestamp()> time()){
		   
			return $userSession;
		}else{
		
			return null;
		}
	}
	
	// This only keeps the last n userSession for the user
	private function deleteUserSessions($userID){
		
		//	Gets all of the sessions from the user and sorts them by expiry time
		$userSession = UserSession::get()->filter(array(
			'UserID' => Convert::raw2sql($userID)
		))->sort('Expiry ', 'DESC');
	
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
		$userSession->Expiry = (Time() + 600);
		$userSession->write();
		
		return true;
	}

	
	//	Creates a new Transaction for an account, with the amount, the payee and the account needing the new transaction
	private function createTransaction($amount, $payee, $account, $direction){
	
		//	Create a new row and fills in the relevant fields 
		$transaction = Transaction::create();
		$transaction->Amount = $amount;
		$transaction->Payee = "Transfer ".$direction." account ".$payee;
		$transaction->Date = date("d M Y");
		$transaction->AccountID = $account->ID;
		$transaction->OffBudget = 1;
		
		//	Then write this to the database
		$transaction->write();

		// If this is the accounts first transaction then update the date of the first transaction carried out
		if($account->FirstTransaction === null){
			$account->FirstTransaction = date("M Y");
			$account->write();
		}
	}
	
	private function getUserSession($token){
	
		//	Gets the user session that is associated with the token	
		$userSession = UserSession::get()->filter(array(
			'Token' => Convert::raw2sql($token)
			))[0];
	
		return $userSession;
	}
	
	//	####################################################
	//	#### Intermediate Requirements public functions ####
	//	####################################################
	
	//	Gets all of the Transactions without a category
	public function newPayments( $userID, $token ){
	
		//	Gets the user session from the token
		$userSession = $this->checkUserSession($userID,$token);
		$sanitisedUserID = Convert::raw2sql($userID);
		
		//	If the session exists and is valid
		if($userSession != null ){

			$user = User::get()->byID($sanitisedUserID);
			
			if ($user != null){
				
				//	Complies an array of all the users transactions without a category
				$arrayList = new ArrayList();	
				$accounts = $user->Accounts();
				foreach( $accounts  as $row) {
			
					$theRowID =  $row->ID;
					
					$transactions = Transaction::get()->filter(array(
						'AccountID' => $theRowID,
						'CategoryID' => 0,
						"OffBudget" => 0
					));

						foreach($transactions as $transaction){
						
							$arrayList->push($transaction);
						}
				}
		
				//	Update the session 
				$this->updateSession($userSession);
				
				//	Returns the array
				return new NewPaymentsOutput($arrayList,true,"Passed");
					
			}
		}
		return new NewPaymentsOutput(null,false,"failed to authenticate");
	}
	
	//	Allows the user to categorise all of their payments 
	public function categorisePayments( $userID, $token, $categorisedItems ){
		
		//	Gets the user session from the token
		$userSession = $this->checkUserSession($userID,$token);
		$sanitisedUserID = Convert::raw2sql($userID);
	
		if($userSession !== null){
		
			/*	
			This checks if all of the inputs are valid before trying to do anything
			*/
			foreach ($categorisedItems as $transID => $catID) {
				
				if((int)$catID === -1){
					$transaction = Transaction::get()->byID(Convert::raw2sql($transID));
					if ($transaction === null ||  $transaction->Account()->UserID !== $sanitisedUserID){
			
						return new CategoriseOutput(null, null, null, null, false, "Transaction not found for this user");
					}
				}else{
					//	Get the corresponding transaction and category objects
					$transaction = Transaction::get()->byID(Convert::raw2sql($transID));
					$category = Category::get()->byID(Convert::raw2sql($catID));
					
					//	If the objects are not null and the account and budget are owned by the user
					if ($transaction === null || $category === null || $transaction->Account()->UserID !== $sanitisedUserID || $category->Group()->UserID !== $sanitisedUserID){
						return new CategoriseOutput(null, null, null, null, false, "Transaction or Category not found for this user");
					}
				}
			}

			$catArray = new ArrayList();
			$transArray = new ArrayList();
			
			//	For every item in the key value array
			foreach ($categorisedItems as $transID => $catID) {
				
				if((int)$catID === -1){
					$transaction = Transaction::get()->byID(Convert::raw2sql($transID));
					$transaction->OffBudget = 1;
		
					//	Then write this to the database
					$transaction->write();
					$transArray->push($transaction);
					
				}else{

					//	Get the corresponding transaction and category objects
					$transaction = Transaction::get()->byID(Convert::raw2sql($transID));
					$category = Category::get()->byID(Convert::raw2sql($catID));
					
					//	If the objects are not null and the account and budget are owned by the user
					if ($transaction !== null && $category !== null && $transaction->Account()->UserID === $sanitisedUserID && $category->Group()->UserID === $sanitisedUserID){
						
						//	Change the categoryID
						$transaction->CategoryID = Convert::raw2sql($catID);
						$transaction->write();
						
						//	Increase or decrease the balance of the category
						$category->Balance = $category->Balance - $transaction->Amount;
						$category->write();
					}
					
					//	Compiles an array of the categories edited
					if (!$catArray->exists($category)) {
						$catArray->push($category);
					}
				
					$transArray->push($transaction);
				}
			}
			
			$newSpin = false;
			$currentSpins = 0;
			$user = User::get()->byID($sanitisedUserID);

			//	If the user has categorised all their payments  and they haven't done a categorise today
			if( sizeof($this->newPayments( $userID, $token )->getPayments()) === 0 && strtotime($user->LastFullCategorise) < strtotime(date("Y-m-d"))){
				
				//	Give the user an new spin
				$newSpin = true;
				
				if($user != null){
					
					$user->NumberOfSpins = $user->NumberOfSpins +1;
					$user->LastFullCategorise= date("d M Y");
					$user->write();
					
					$currentSpins = $user->NumberOfSpins;
				}
			}
			
			//	Update the session 
			$this->updateSession($userSession);
			
			return new CategoriseOutput($catArray, $transArray, $newSpin, $currentSpins, true, "Passed");
		}
		
		return new CategoriseOutput(null, null, null, null, false,"Failed to authenticate user session");
	}

	public function deleteBudget($userID, $token, $groupID){
	
		//Check user session
		$userSession = $this->checkUserSession($userID,$token);
		$sanitisedUserID = Convert::raw2sql($userID);
	
		if($userSession !== null){
		
			//	Delete the specified groups based on the groupID
			$group =  BudgetGroup::get()->byID(Convert::raw2sql($groupID));
			
			//	If the user owns the group
			if( $group !== null && $group->UserID === $sanitisedUserID ){
			
				//	Get all of the groups categories 
				$categories = Category::get()->filter(array(
					"GroupID" => $group->ID
				));
				
				//	If their is categories to delete
				if (sizeof($categories)>0){
				
					if(!$this->deleteCategories($sanitisedUserID, $categories)){
						return new DeletedBudgetObject("Categories don't belong to user", false);
					}
				}
				
				$group->delete();
				
				//	Update the session 
				$this->updateSession($userSession);
				return new DeletedBudgetObject("Passed",true);
			}
			return new DeletedBudgetObject("Budget group doesn't belong to user", false);
			
		}
		return new DeletedBudgetObject("Failed to authenticate user session", false);
	}
	
	public function editGroups($userID, $token, $groupID, $groupName, $updatedCategories, $newCats, $deletedCats){
		
		//Check user session
		$userSession = $this->checkUserSession($userID,$token);
		$sanitisedUserID = Convert::raw2sql($userID);
	
		if($userSession !== null){
		
			//	Get the Group the user wants to edit
			$group = BudgetGroup::get()->byID(Convert::raw2sql($groupID));
			
			//	If the group exists and the user owns it 
			if($group !== null && $group->UserID === $sanitisedUserID){
		
				//	If they want to change the title of the group change it 
				if($groupName != null && strcmp($group->Title, $groupName) !== 0 ){
				
					$group->Title = $groupName;
					$group->write();
				}
				
				//	If there are categories to update
				if(sizeof($updatedCategories)>0){
				
					//	Check all the inputs and check them
					foreach ($updatedCategories as $categoryID => $infoArray){
				
						if(isset($infoArray["Name"]) && isset($infoArray["Budget"]) &&  is_numeric($infoArray["Budget"])){
						
							$newName = Convert::raw2sql($infoArray["Name"]);
							$newBudget = Convert::raw2sql($infoArray["Budget"]);
							
						}else{
						
							return new CreateBudgetObject(null,null, "Failed due to new categories being in an incorrect format", false);
						}
						
						$category = Category::get()->byId(Convert::raw2sql($categoryID));
						
						if( $newName === null && $newBudget === null || $category === null || $category->Group()->UserID !== $sanitisedUserID){
						
							return new EditBudgetObject(null, null, null,"Failed due to categories being in the wrong format or not belonging to the user or not being found", false);
						}
					}
				}
				
				//	If there are categories to delete
				if(sizeof($deletedCats)>0){
				
					//	Check the inputs
					foreach ( $deletedCats as  $deletedCatIDs){
				
						$category = Category::get()->byId(Convert::raw2sql($deletedCatIDs));
						
						if( $category === null || $category->Group()->UserID !== $sanitisedUserID){
							return new EditBudgetObject(null, null, null,"Failed due to categories not being found or not being owned by the user", false);
						}
					}
				}
				
				$result = new ArrayList();
				
				//	If there are new categories to create
				if(sizeof($newCats)>0){
				
					//	Create them
					$result = $this->createCategories($groupID, $newCats);
					
					//	If 1 or more category couldn't be made error
					if(sizeof($result) !== sizeof($newCats)){
					
						return new EditBudgetObject(null, null, null,"Failed due to categories being in the wrong format", false);
					}
				}
				
				//	If there are categories to delete
				if(sizeof($deletedCats)>0){
				
					//	Delete the categories
					foreach ($deletedCats as $toDelCatID) {
		
						$toDelCategory =  Category::get()->byID(Convert::raw2sql($toDelCatID));

						if($toDelCategory !== null && $toDelCategory->Group()->UserID === $sanitisedUserID ){

							$toDelCategory->delete();
						}
					}
				}
				
				$editedCategoriesArray = new ArrayList();
				
				//	If there are categories to update
				if(sizeof($updatedCategories)>0){
				
					//	Update all of the categories
					foreach ($updatedCategories as $categoryID => $infoArray){
				
						$newName = Convert::raw2sql($infoArray["Name"]);
						$newBudget = Convert::raw2sql($infoArray["Budget"]);
						$category = Category::get()->byId(Convert::raw2sql($categoryID));
						
						if( $category !== null && $category->Group()->UserID === $sanitisedUserID){
							
							if($newName !== null && strcmp($category->Title, $newName) !==0){
								$category->Title = $newName;
							
							
							}
							if($newBudget !== null && $category->Budgeted !== $newBudget){
								$category->Budgeted = $newBudget;
								$category->Balance = 0;
							}
							
							$category->write();
							$editedCategoriesArray->push($category);
						}
					}
				}
				
				//	Update the session 
				$this->updateSession($userSession);
			
				return new EditBudgetObject($group, $result, $editedCategoriesArray, "Passed", true);
			}
			return new EditBudgetObject(null, null, null,"Budget group doesn't belong to user or wasn't found", false);
		}
		return new EditBudgetObject(null, null, null,"Failed to authenticate user session", false);
	}
	
	public function createGroup($userID, $token, $groupName, $newCategories){
	
		//Check user session
		$userSession = $this->checkUserSession($userID,$token);
		$sanitisedUserID = Convert::raw2sql($userID);
	
		if($userSession !== null){

			//	If the groups has a name
			if($groupName !== null){
				
				//	If there are categories
				if(sizeof($newCategories)>0){
				
					//	Check the inputs of the categories
					foreach ($newCategories as $newCategory){
				
						if(isset($newCategory["Name"]) && isset($newCategory["Budget"]) && is_numeric($newCategory["Budget"])){
						
							$newName = Convert::raw2sql($newCategory["Name"]);
							$newBudget = Convert::raw2sql($newCategory["Budget"]);
						}else{
						
							return new CreateBudgetObject(null,null, "Failed due to new categories being in an incorrect format", false);
						}
						
						if( $newName === null || $newBudget === null){
							return new CreateBudgetObject(null,null, "Failed due to new categories being in an incorrect format", false);
						}
					}
				}
				
				//Create group
				$theNewGroup = BudgetGroup::create();
				$theNewGroup->Title = Convert::raw2sql($groupName);
				$theNewGroup->UserID = $sanitisedUserID;
				
				//	Then write this to the database
				$theNewGroup->write();
				$result = new ArrayList();
				
				//	If there are categories create them
				if(sizeof($newCategories)>0){
				
					$result = $this->createCategories($theNewGroup->ID, $newCategories);
					
					//	If not all categories could be created
					if(sizeof($result) !== sizeof($newCategories)){
					
						return new CreateBudgetObject(null,null, "Failed due to new categories being in an incorrect format", false);
					}
				}
				
				//	Update the session 
				$this->updateSession($userSession);
			
				return new CreateBudgetObject($theNewGroup,$result, "Passed", true);
			}
			return new CreateBudgetObject(null,null,"GroupName not provided", false);
		}
		return new CreateBudgetObject(null,null,"Failed to authenticate user session", false);
	}
	
	
	public function mobileBudgetEdit($userID, $token, $allGroupsData) {
		
		/*
		## POST VAR USAGE
		Group = data[n];
		Group  ID = data[n][id]
		GroupMode = data[n][mode]
		GroupName = data[n][title]
		GroupCats = data[n][categories]
		A Category   = data[n][categories][m]
		Category  ID = data[n][categories][m][id]
		CategoryMode = data[n][categories][m][mode]
		CategoryName = data[n][categories][m][title]
		CategoryBudg = data[n][categories][m][budget]
		
		
		##Algorithm:
		Determines what to do with an item based on it's 'mode'
		
		Loop through groups:
			If create Group
				Delete the group

			Else If create group
				Create the group
			
			If the group exists or is new
				Update the group's name
				Update the group's budget
				
				Loop through group's categories: 
					If delete category
						Delete the category
					
					Else If the categroy is new
						Create the category
					
					If the category exists or is new
						Update the category's name
						Update the category's budget
		
		
		Set user's last budget updated date to today
		*/
		
		
		$userSession = $this->checkUserSession($userID, $token);
		$sanitisedUserID = Convert::raw2sql($userID);
		
		// Check the user is signed in
		if ($userSession == null) {
			
			return new MobileBudgetEditOutput(null, null, false, "Failed to authenticate user session");
		}
		
		
		// Check they provided group data
		if ($allGroupsData == null) {
			
			return new MobileBudgetEditOutput(null, null, false, "Incorrect Data Passed");
		}
		
		
		// Loop all the groups
		foreach ($allGroupsData as $groupData) {
			
			if (array_key_exists("mode", $groupData)) {
				
				$mode = Convert::raw2sql($groupData["mode"]);
				$group = null;
				
				
				if ($mode == "create") {
					
					// Create the group if needed
					$group = BudgetGroup::create();
					$group->UserID = $sanitisedUserID;
				}
				else if (array_key_exists("id", $groupData)) {
					
					// Othwerwise, get it from the database, if it belongs to the user
					$gID = Convert::raw2sql($groupData["id"]);
					
					$theGroup = BudgetGroup::get()->byId($gID);
					if ($theGroup->UserID == $sanitisedUserID) {
						
						$group = $theGroup;
					}
					else {
						
						// Remove references to the group
						$theGroup == null;
					}
				}
				
				
				// Delete it if wanted
				if ($group && $mode == "delete") {
					
					$group->delete();
				}
				
				// Otherwise edit it
				else if ($group) {
					
					
					// Set the title if provided with one
					if (array_key_exists("title", $groupData)) {
						
						$group->Title = Convert::raw2sql($groupData["title"]);
					}
					
					// Store the categories that were created, to add them back to this group
					$addedCategories = array();
					
					
					// Work through the categories
					if (array_key_exists("categories", $groupData)) {
						
						$allCatsData = Convert::raw2sql($groupData["categories"]);
						
						foreach ($allCatsData as $categoryData) {
							
							if (array_key_exists("mode", $categoryData)) {
								
								
								// Get the mode
								$mode = Convert::raw2sql($categoryData["mode"]);
								$category = null;
								
								
								if ($mode == "create") {
									
									// Create category
									$category = Category::create();
									array_push($addedCategories, $category);
								}
								else if (array_key_exists("id", $categoryData)){
									
									// Or get it from the Database
									$cID = Convert::raw2sql($categoryData["id"]);
									$category = Category::get()->byId($cID);
								}
								
								
								if ($category && $mode == "delete") {
									
									// Delete the category if wanted
									$category->delete();
								}
								else if ($category) {
									
									// Otherwise edit it
									
									// If there's a title update that
									if (array_key_exists("title", $categoryData)) {
										
										$category->Title = Convert::raw2sql($categoryData["title"]);
									}
									
									// If there's a budget update that
									if (array_key_exists("budget", $categoryData)) {
										
										$category->Budgeted = Convert::raw2sql($categoryData["budget"]);
										$category->Balance = 0;
									}
									
									
									// Write changes to the categroy table
									$category->write();
								}
							}
						}
					}
					
					
					// Added new categories to the group
					foreach ($addedCategories as $cat) {
						
						$group->Categories()->add($cat);
					}
					
					// Write changes to the Group table
					$group->write();
				}
			}
		}
		
		
		// Get all Categories & Groups 
		$user = User::get()->byId($sanitisedUserID);
		$allGroups = $user->Groups();
		$allCategories = new ArrayList();
		
		foreach ($allGroups as $group) {
			
			foreach ($group->Categories() as $category) {
				$allCategories->push($category);
			}
		}
		
		return new MobileBudgetEditOutput($allGroups, $allCategories);
	}
	
	
	

	//	This lets the user choose a reward and spend their points
	public function chooseReward( $userID, $token, $rewardID ){
	
		//	Gets the user session from the token
		$userSession = $this->checkUserSession($userID,$token);
		$sanitisedUserID = Convert::raw2sql($userID);
		$sanitisedRewardID = Convert::raw2sql($rewardID);
		$reward = Reward::get()->byID($sanitisedRewardID);
		
		if($userSession != null ){
				
			$user = User::get()->byID($sanitisedUserID);
			
			if ($user !== null && $reward !== null){
				
				//	Get info about the users Points and Cost of the reward
				$userPoints = $user->Points;
				$rewardCost = $reward->Cost;
				
				//	If they have enough points
				if((int)$userPoints >= (int)$rewardCost ){
				
					//	Deduct the points
					$user->Points = $user->Points - $rewardCost;
					$user->write();
				
					//	Create a new row and fills in the relevant fields 
					$rewardTaken = RewardTaken::create();
					$rewardTaken->RewardID = $reward->ID;
					$rewardTaken->Date = date("d M Y");
					$rewardTaken->UserID= $user->ID;
					
					//	Then write this to the database
					$rewardTaken->write();
					//	if the user has provided an email
					if($user->Email !== null){
						//	Create an email form the template and send it 
						$email = new Email();
						$email
							->setFrom("rewards@t14.banking.co.uk")
							->setTo($user->Email)
							->setSubject("Reward Claimed: ".$reward->Title)
							->setTemplate('RewardTaken')
							->populateTemplate(new ArrayData(array(
								'user' => $user->FirstName,
								'prizeTitle' => $reward->Title,
								'prizeLeft' => $user->Points,
								'costPoints' => $rewardCost
							)));

						$email->send();
					
					
					}
					
					//	Update the session 
					$this->updateSession($userSession);
			
					//	Return the new reward
					return new RewardTakenOutput($reward, $rewardTaken, true);
					
				}
			}
		}
		return new RewardTakenOutput(null, null, false);
	}
	
	//	This allows the user to perform a spin to get points
	public function performSpin( $userID, $token){
	
		//	Gets the user session from the token
		$userSession = $this->checkUserSession($userID,$token);
		$sanitisedUserID = Convert::raw2sql($userID);
		
		if($userSession != null ){

			$user = User::get()->byID($sanitisedUserID);
			
			if ($user != null){
				
				//	If the user has enough spins left
				if( $user->NumberOfSpins > 0){
				
					//	Get a random number between 0-100 and get the relevant points to add
					$result = mt_rand( 0 , 100);
					
					if ($result >=0 && $result <=50) {
					
						$pointsToBeAdded = 20;
					} elseif ($result > 50 && $result <=75) {
					
						$pointsToBeAdded = 40;
					} elseif ($result >75 && $result <=88) {
					
						$pointsToBeAdded = 60;
					}elseif ($result >88 && $result <=95) {
					
						$pointsToBeAdded = 80;
					}elseif ($result >95 && $result <=100) {
					
						$pointsToBeAdded = 100;
					}else{
						return null;
					}
					
					//	Update the users points and reduce the number of spins
					$user->Points = $user->Points + $pointsToBeAdded;
					$user->NumberOfSpins = $user->NumberOfSpins -1;

					$user->write();
					
					//	Create a new row in the pointsGain table
					$pointGain = PointGain::create();
					$pointGain->Title = "Spin";
					$pointGain->Description = "Gain of " . $pointsToBeAdded . " points";
					$pointGain->Date = date("d M Y");
					$pointGain->Points = $pointsToBeAdded;
					$pointGain->UserID = $sanitisedUserID;
					
					//	Then write this to the database
					$pointGain->write();
					
					//	Update the session
					$this->updateSession($userSession);
					
					//	Update the session 
					$this->updateSession($userSession);
			
					//	Returns the number of points gained
					return $pointGain;
					
				}
			}
		}

		return null;
	}	
	
	//	Get a list of all the rewards we offer
	public function getAllRewards(){
		return Reward::get();
	}
	
	//	Get the last n set of points the user gained
	public function getLastPoints($userID, $token){
	
		//	Gets the user session from the token
		$userSession = $this->checkUserSession($userID,$token);
		$sanitisedUserID = Convert::raw2sql($userID);
		
		if($userSession != null ){

			$arrayList = new ArrayList();	
			
			//	Get all of the points and sort by the ID
			$pointsGained = PointGain::get()->filter(array(
				'UserID' => $sanitisedUserID
			))->sort('ID', 'DESC');
			
			//	If they have gained less than 7 sets set to current max
			if(sizeof($pointsGained) > 7 ){
				$size = 7;
			}else{
				$size = sizeof($pointsGained);
			}
			
			//	Push the first n to the array
			for( $i=0; $i<$size; $i++){
				$arrayList->push($pointsGained[$i]);
			
			}
			//	Update the session 
			$this->updateSession($userSession);
			
			//	Return the array of last points gained
			return $arrayList;
			
		}
		
		return array();
	}
	
	//	Get the last n set of rewards the user got
	public function getLastRewards($userID, $token){
	
		//	Gets the user session from the token
		$userSession = $this->checkUserSession($userID,$token);
		$sanitisedUserID = Convert::raw2sql($userID);
		
		if($userSession != null ){
		
			$arrayList = new ArrayList();	
			
			//	Get all of the rewardsTaken and sort by the ID
			$rewardGained = RewardTaken::get()->filter(array(
				'UserID' => $sanitisedUserID
			))->sort('ID', 'DESC');
			
			//	If they have gained less than 7 sets set to current max
			if(sizeof($rewardGained) > 7 ){
				$size = 7;
			}else{
				$size = sizeof($rewardGained);
			}
			
			//	Push the first n to the array
			for( $i=0; $i<$size; $i++){
				$arrayList->push($rewardGained[$i]);
			
			}
			
			//	Update the session 
			$this->updateSession($userSession);
			
			//	Return the array of last points gained
			return $arrayList;
			
		}
		
		return array();
	}
	
	
	public function getUserCategories($userID, $token){

	
	//	Gets the user session from the token
		$userSession = $this->checkUserSession($userID,$token);
		$sanitisedUserID = Convert::raw2sql($userID);
		
		if($userSession != null ){
			
			//	Get all groups the user owns 
			$groups = BudgetGroup::get()->filter(array(
							'UserID' => $sanitisedUserID 
					  ));
					  
			$arrayList = new ArrayList();	
			
			//	For every group get all categories 
			foreach( $groups as $group){
			
				$categories = Category::get()->filter(array(
								'GroupID' => Convert::raw2sql($group->ID)
							  ));
				
				//	Push all of the categories to an array 
				foreach( $categories as $catgory){
				
					$arrayList->push($catgory);
				}
			}
			
			//	Update the session 
			$this->updateSession($userSession);
			
			return $arrayList;
		}
		
		return array();
	}
	
	public function monthlyAccountUpdate(){
	
		//Get everyuser that asks for updates
		$users = User::get()->filter(array(
			"MonthlyEmail" => 1
		));
		if($users  !== null){
		
			foreach($users as $user){
			
				//	If they have an email
				if($user->Email !== null){
				
					//	Get all their accounts 
					$accounts = Account::get()->filter(array("UserID"=>$user->ID));

					//	Create an email form the template and send it 
					$email = new Email();
					$email
						->setFrom("updates@t14.banking.co.uk")
						->setTo($user->Email)
						->setSubject("Monthly Account Update")
						->setTemplate('MonthlyUpdate')
						->populateTemplate(new ArrayData(array(
							'user' => $user->FirstName,
							'accounts' => $accounts
						)));

					$email->send();
				
				
				}
			}
		}
	}
		
	public function resetBudget($userID, $token){
	
		//	Get the user sessions 
		$userSession = $this->checkUserSession($userID,$token);
		$sanitisedUserID = Convert::raw2sql($userID);
		
		//	If the session exists
		if($userSession != null ){
			
			//	Get all of the users categories
			$categories = $this->getUserCategories($userID,$token);
			
			//	If they have categories reset balance to 0
			if(sizeof($categories) > 0){
			
				foreach($categories as $category){
					
					if($category !== null){
					
						$category->Balance = 0;
						$category->write();
					}
				}
			}
		}
	}

	//	#####################################################
	//	#### Intermediate Requirements private functions ####
	//	#####################################################
	
	private function deleteCategories($userID, $categories){
	
		//Check all categories are owned by user 
		foreach ($categories as $catID) {
	
			$category =  Category::get()->byID(Convert::raw2sql($catID->ID));
			
			//	Check the inputs
			if($category === null || $category->Group()->UserID !== $userID ){
			
				return false;
			}
		}
		
		//	Delete all of the categories 
		foreach ($categories as $catID) {
	
			$category =  Category::get()->byID(Convert::raw2sql($catID->ID));
			
			//	If the user own the category and exists delete it 
			if($category !== null && $category->Group()->UserID === $userID ){
			
				$category->delete();
			}
		}
		return true;
	}
	
	private function createCategories($groupID, $newCategories){
	
		//	If there are categories to make
		if(sizeof($newCategories)>0){
		
			//	Check all of the inputs
			foreach ($newCategories as $newCategory){
				
				//	Check the inputs
				if(isset($newCategory["Name"]) && isset($newCategory["Budget"]) && is_numeric($newCategory["Budget"])){
						
					$newName = Convert::raw2sql($newCategory["Name"]);
					$newBudget = Convert::raw2sql($newCategory["Budget"]);
				}else{
				
					//	If they are wrong return an empty array
					return array();
				}
				
				//	If either are not null return an empty array
				if( $newName === null || $newBudget === null){
				
					return array();
				}
			}
		
		
			$newCatObjects = new ArrayList();
			
			//	Then create all of the associated categories that have been added
			foreach ($newCategories as $newCategory){

				//	Get the params
				$newName = Convert::raw2sql($newCategory["Name"]);
				$newBudget = Convert::raw2sql($newCategory["Budget"]);
				
				//	If there are params
				if( $newName !== null && $newBudget !== null){
					
					//	Create the category
					$theNewCat = Category::create();
					$theNewCat->Title = $newName;
					$theNewCat->Budgeted = $newBudget;
					$theNewCat->GroupID = $groupID;
					$theNewCat->Balance = 0;

					//	Then write this to the database
					$theNewCat->write();
					
					//	push to the array of created Categories
					$newCatObjects->push($theNewCat);
				}
			}
			return $newCatObjects;
		}
		return array();
	}
	
	//	################################################
	//	#### Advanced Requirements public functions ####
	//	################################################
	
	public function loadATMs($userID, $token){

		//	Gets the user session from the token
		$userSession = $this->checkUserSession($userID,$token);
		
		if($userSession != null ){
		
			//	Update the session 
			$this->updateSession($userSession);
			
			//	Returns all of the ATM's held in the database
			return ATM::get();
		}
		
		return new ArrayList();
	}
	
	public function loadHeatMap($userID, $token, $accounts, $startDate, $endDate){

		//	Get the user sessions 
		$userSession = $this->checkUserSession($userID,$token);
		$sanitisedUserID = Convert::raw2sql($userID);
		
		//	If the session exists
		if($userSession != null ){
			
			if($accounts === null){
				$accounts = new ArrayList;
				$allAccounts = Account::get()->filter(array(
					"UserID" => $sanitisedUserID
				));
			
				foreach ($allAccounts as $acc) {
					$accounts->push( $acc->ID);
				}
			}
			
			//	If there is no specified start date use the beginning on unix time
			if($startDate === null){
			
				$startDate = '1970-01-0 00:00:00';
			}
			
			//	If there is no end date specified use today
			if($endDate === null){
			
				$endDate = date("Y-m-d",time()).' 23:59:59';
			}
			
			$transactions = new ArrayList();
			
			//	For every account the user wants the data for
			foreach( $accounts as $account){
			
				//	Get the account object
				$theAccount = Account::get()->byID(Convert::raw2sql($account));
				
				
				//	If the account object it not null and is owned by the user
				if($theAccount !== null && $theAccount->UserID === $sanitisedUserID){
				
					//	Get all of the transactions by that account in the time frame 
					$accountTransactions = Transaction::get()->filter(array(
					
						"AccountID" => Convert::raw2sql($account),
						'Date:GreaterThan' =>  Convert::raw2sql($startDate),
						'Date:LessThan' =>  Convert::raw2sql($endDate)
					));
					
					//	Add all of these transactions to an array
					foreach($accountTransactions as $transaction){
						
						$transactions->push($transaction);
					}
				}
			}

			//	If there was transactions
			if(sizeof($transactions) >0){
			
				
				$groups = new ArrayList();
				
				//	Add the first transaction to a hew HeatMapGroup 
				$groups->push( new HeatMapGroup($transactions[0]->Longitude,$transactions[0]->Latitude,20));
				
				//	Increase the amount spent in the group 
				$groups[0]->addAmount($transactions[0]->Amount);
				
				//	For every transaction in the array
				for($i = 1 ; $i<sizeof($transactions) ; $i++){
				
					$hasLatitude = $transactions[$i]->Latitude != null && $transactions[$i]->Latitude != 0;
					$hasLongitude = $transactions[$i]->Longitude != null && $transactions[$i]->Longitude != 0;
					$found= false;
					
					//	At every position in the groups array
					for($j = 0 ; $j < $groups->count(); $j++){
						
						//	If the transaction is "close" to the centre of the groups first transaction group it with that
						if($hasLatitude && $hasLongitude && $groups[$j]->close($transactions[$i]->Longitude,$transactions[$i]->Latitude)){
						
							$groups[$j]->addAmount($transactions[$i]->Amount);
							$found = true;
							break;
						
						//	If at the end of the groups array add to the end position a new group
						}
					}
					if(!$found && $hasLatitude && $hasLongitude){
						$groups->push( new HeatMapGroup($transactions[$i]->Longitude,$transactions[$i]->Latitude,20));
						$groups[sizeof($groups) -1]->addAmount($transactions[$i]->Amount);
					}
				}
				
				//	Update the session 
				$this->updateSession($userSession);
				
				return $groups;
			}
			
			//	Update the session 
			$this->updateSession($userSession);
		}
		return null;
	}
}
?>