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
		'NumberOfSpins' => 'Int'
    );
	private static $has_many =  array(
		'Accounts' => 'Account',
		'Groups' => 'BudgetGroup',
		'PointsAwarded' => 'PointGain',
		'RewardsTaken' => 'RewardTaken'
	);
	
	
	function onBeforeWrite(){
	
		$key = "pGVsJMJ6z+F7If9+M8FW7njv2NjpSr/VyeCMXSY8DrU=";
		//$iv = "75238a690bcb3f78";
		$iv = substr(openssl_digest($this->getField("Username"), 'sha512'), 0, 16);
		
		$data = $this->getField("Password");
		$crypt = new PHP_Crypt($key, PHP_Crypt::CIPHER_AES_256, PHP_Crypt::MODE_CBC);

		$crypt->IV($iv);
		$encrypted = $crypt->encrypt($data);
	    
		$this->Password = base64_encode($encrypted);
    	
    	parent::onBeforeWrite();
    }
	
	
}

?>