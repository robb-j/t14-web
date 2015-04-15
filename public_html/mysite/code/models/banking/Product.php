<?php

/* 
 * Created by Martin Smith - Feb 2015
 */
class Product extends DataObject {

    private static $db = array(
        'Title' => 'Varchar(50)',
		'Content' => 'HTMLText'
    );
	
	//	Provides the user updates on products
	public function onAfterWrite() {
	
		//	Get all the accounts with this product
		$updatedAccounts = Account::get()->filter(array(
			"ProductID" => $this->getField("ID")
		));
		
		//	For each of the accounts with the product inform the user of the change
		foreach($updatedAccounts as $account){
		
			//	Get the user who own the account
			$user = $account->User();
			
			//	If they have an email 
			if($user->Email !== null){
			
				//	Create an email form the template and send it 
				$email = new Email();
				$email
					->setFrom("products@t14.banking.co.uk")
					->setTo($user->Email)
					->setSubject("Product update:")
					->setTemplate('ProductUpdate')
					->populateTemplate(new ArrayData(array(
						'user' => $user->FirstName,
						'title' => $this->getField("Title"),
						'accountName' =>$account->AccountType,
						'content' => $this->getField("Content")
					)));

				$email->send();
			}
		}
		
		//	If no accounts have the product its a new product so inform people of the new product
		if( sizeof($updatedAccounts) === 0){
		
			//	Get all users who have asked for updates
			$users = User::get()->filter(array("NewProductUpdate"=>1));
			
			foreach($users as $user){
			
				//	If the user has an email address
				if($user->Email !== null){
				
					//	Create an email form the template and send it 
						$email = new Email();
						$email
							->setFrom("products@t14.banking.co.uk")
							->setTo($user->Email)
							->setSubject("New Product available")
							->setTemplate('ProductNew')
							->populateTemplate(new ArrayData(array(
								'user' => $user->FirstName,
								'title' => $this->getField("Title"),
								'content' => $this->getField("Content")
							)));

						$email->send();
				}
			}
		}
		
		//	Finishes the write operation
		parent::onAfterWrite();
    }
}
?>