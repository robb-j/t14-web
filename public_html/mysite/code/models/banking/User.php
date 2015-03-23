<?php

/*
	This phpCrypt program is open source software found at https://github.com/gilfether/phpcrypt
	"phpCrypt is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version."
*/
//include_once("t14-web/public_html/mysite/code/backend/bank-accessor/phpcrypt-master/phpCrypt.php");
use PHP_Crypt\PHP_Crypt as PHP_Crypt;

class User extends DataObject {

    private static $db = array(
	
		'Username' => 'Varchar(30)',
        'FirstName' => 'Varchar(30)',
		'LastName' => 'Varchar(30)',
		'Email' => 'Varchar(30)',
		'LastFullCategorise' => 'Date',
		'DOB' => 'Date',
		'Password' => 'Varchar(30)',
		'NumberOfSpins' => 'Int',
		'Points' => 'Int'
    );
	private static $has_many =  array(
		'Accounts' => 'Account',
		'Groups' => 'BudgetGroup',
		'PointsAwarded' => 'PointGain',
		'RewardsTaken' => 'RewardTaken'
	);

	//	This encrypts the users password before write
	function onBeforeWrite(){
	
			$user = User::get()->filter(array(
					'Username' => $this->getField("Username")
				));
				
			if($user[0] !== null){
				$userPass = $user[0]->Password;
			
				
				if($userPass !== null) {

				} else {
					//	This is the key used for encryption/decryption
					$key = "pGVsJMJ6z+F7If9+M8FW7njv2NjpSr/VyeCMXSY8DrU=";
					
					//	Sets the initialisation vector from the first 16 characters of the hashed username
					$iv = substr(openssl_digest($this->getField("Username"), 'sha512'), 0, 16);
					
					//	Created the crypt object
					$crypt = new PHP_Crypt($key, PHP_Crypt::CIPHER_AES_256, PHP_Crypt::MODE_CBC);
					
					//	Sets the initialisation vector
					$crypt->IV($iv);
					
					echo "  The field =|".$this->getField("Password")."|";
					//	Encrypts the data getting added to the Password field
					$encrypted = $crypt->encrypt($this->getField("Password"));

					//	Adds the base64 encoded version to the field
					$this->Password = base64_encode($encrypted);
					
				}
			}else{
			
				//	This is the key used for encryption/decryption
				$key = "pGVsJMJ6z+F7If9+M8FW7njv2NjpSr/VyeCMXSY8DrU=";
				
				//	Sets the initialisation vector from the first 16 characters of the hashed username
				$iv = substr(openssl_digest($this->getField("Username"), 'sha512'), 0, 16);
				
				//	Created the crypt object
				$crypt = new PHP_Crypt($key, PHP_Crypt::CIPHER_AES_256, PHP_Crypt::MODE_CBC);
				
				//	Sets the initialisation vector
				$crypt->IV($iv);
				
				echo "  The field =|".$this->getField("Password")."|";
				//	Encrypts the data getting added to the Password field
				$encrypted = $crypt->encrypt($this->getField("Password"));

				//	Adds the base64 encoded version to the field
				$this->Password = base64_encode($encrypted);
			}
			
			
		
			
		
		
		
		
			//	Finishes the write operation
			parent::onBeforeWrite();
		
    }
	
	
}

?>