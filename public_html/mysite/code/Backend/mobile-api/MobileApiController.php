<?php

class MobileApiController extends Controller {

	private static $allowed_actions = array(
        'login', 'loadTransactions'
    );
    
    public function init() {
	    parent::init();
	    
	    $this->serializer = new SimpleSerializer();
    }
    
    public function index(SS_HTTPRequest $request) {
	    
	    return "Bank Api Index";
    }

	public function login(SS_HTTPRequest $request){
	
		  	
	  	// Get the username & password
		$username = $request->postVar('username');
		$password = $request->postVar('password');
		
		
		// Get the indexies of the password
		$indexes = array(
			$request->postVar('index1'), 
			$request->postVar('index2'), 
			$request->postVar('index3')
		);
		
		
		// Try to sign in with them
		$output = BankAccessor::create()->loginFromMobile($username,$password,$indexes);
		
		$data = null;
		
		// Decide what data to give back
		if ($output->didPass()) {
			
			$data = array(
				"User" => $output->GetUser(),
				"NewProducts" => $output->getAllProducts(),
				"Token" => $output->getToken(),
				"Accounts" => $output->getAccounts()
			);
		}
		else {
			
			$data = array(
				"Error" => "Error logging in"
			);
		}
		
		
		// Put the data into the response & return it
		$this->response->setBody($this->serializer->serializeArray( $data ));
		$this->response->addHeader("Content-type", $this->serializer->getcontentType());
		return $this->response;
	}
	
	
	
	
	
	public function loadTransactions(SS_HTTPRequest $request) {
		
		
		// Get inputs from post variables
		$userID = $request->postVar("userID");
		$accountID = $request->postVar("accountID");
		$month = $request->postVar("month");
		$year = $request->postVar("year");
		$token = $request->postVar("token");
		
		
		
		// Try to get the account's transactions
		$output = BankAccessor::create()->loadTransactions($userID, $accountID, $month, $year, $token);
		
		
		
		//if ($output->didPass()) {
			
			$data = array(
				"Transactions" => $output->getTransactions(),
				"Account" => $output->getAccount()
			);
		//}
		
		
		// Put the data into the response & return it
		$this->response->setBody($this->serializer->serializeArray( $data ));
		$this->response->addHeader("Content-type", $this->serializer->getcontentType());
		return $this->response;
	}


}
?>