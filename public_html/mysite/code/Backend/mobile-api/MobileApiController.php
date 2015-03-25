<?php

/*
	This gets the information from the mobile app, converts it to 
	the form wanted by BankAccessor and then returns the results 
	as a JSON object back to the app 
*/
class MobileApiController extends Controller {

	//	Sets the list of allowed actions
	private static $allowed_actions = array(
        'login', 'loadTransactions','makeTransfer','logout','newPayments','chooseReward', "performSpin","getAllRewards","getLastPoints"
    );
    
	//	Initialises the API
    public function init() {
	    parent::init();
	    
	    $this->serializer = new SimpleSerializer();
    }
    
    public function index(SS_HTTPRequest $request) {
	    
	    return "Bank Api Index";
    }

	//	############################
	//	#### Basic Requirements ####
	//	############################
	
	//	This gets the information for logging in and returns the result
	public function login(SS_HTTPRequest $request){
	
	  	// Get the username & password
		$username = $request->postVar('username');
		$password = $request->postVar('password');
		
		// Get the indexes of the password
		$indexes = array(
			(int)$request->postVar('index1'), 
			(int)$request->postVar('index2'), 
			(int)$request->postVar('index3')
		);

		// Try to sign in with them
		$output = BankAccessor::create()->login($username,$password,$indexes,true);
		$data = null;
		
		// Decide what data to give back
		if ($output->didPass()) {
			
			$data = array(
				"User" => $output->GetUser(),
				"NewProducts" => $output->getAllProducts(),
				"Token" => $output->getToken(),
				"Accounts" => $output->getAccounts()
			);
		}else {
			
			$data = array(
				"Error" => $output->getReason()
			);
		}

		// Put the data into the response & return it
		$this->response->setBody($this->serializer->serializeArray( $data ));
		$this->response->addHeader("Content-type", $this->serializer->getcontentType());
		return $this->response;
	}

	//	This loads the transactions from a particular month
	public function loadTransactions(SS_HTTPRequest $request) {
		
		
		// Get inputs from post variables
		$userID = $request->postVar("userID");
		$accountID = $request->postVar("accountID");
		$month = $request->postVar("month");
		$year = $request->postVar("year");
		$token = $request->postVar("token");

		// Try to get the account's transactions
		$output = BankAccessor::create()->loadTransactions($userID, $accountID, $month, $year, $token);
		$data = null;
		
		//	Builds the returned data
		$data = array(
			"Transactions" => $output->getTransactions(),
			"Account" => $output->getAccount()
		);

		// Put the data into the response & return it
		$this->response->setBody($this->serializer->serializeArray( $data ));
		$this->response->addHeader("Content-type", $this->serializer->getcontentType());
		return $this->response;
	}
	
	//	This allows the user to transfer money between accounts
	public function makeTransfer(SS_HTTPRequest $request) {
	
		// Get inputs from post variables
		$userID = $request->postVar("userID");
		$accountAID = $request->postVar("accountAID");
		$accountBID = $request->postVar("accountBID");
		$amount = $request->postVar("amount");
		$token = $request->postVar("token");

		// Try to make the transfer
		$output = BankAccessor::create()->makeTransfer($userID, $accountAID, $accountBID, $amount, $token);
		$data = null;
		
		// Decide what data to give back
		if ($output->didPass()) {
			
			$data = array(
				"payerAcc" => $output->getPayerAccount(),
				"payeeAcc" => $output->getPayeeAccount(),
				"amount" => $output->getAmount()
			);
		}else {
			
			$data = array(
				"Error" => "Error making transfer"
			);
		}
		
		// Put the data into the response & return it
		$this->response->setBody($this->serializer->serializeArray( $data ));
		$this->response->addHeader("Content-type", $this->serializer->getcontentType());
		return $this->response;
	}
	
	//	This allows the user to logout of the app
	public function logout(SS_HTTPRequest $request){
	
		//	Get the userID and token 
		$userID = $request->postVar("userID");
		$token = $request->postVar("token");
		
		//	Logout the user
		$output = BankAccessor::create()->logout($userID ,$token);
	}
	
	//	####################################
	//	#### Intermediate  Requirements ####
	//	####################################
	
	public function newPayments(SS_HTTPRequest $request){
	
		// Get inputs from post variables
		$userID = $request->postVar("userID");
		$token = $request->postVar("token");

		// Try to make the transfer
		$output = BankAccessor::create()->newPayments($userID, $token);
		$data = null;
		
		// Decide what data to give back
		if (sizeof($output) > 0 ) {
			
			$data = array(
				"transactions" => $output
			);
		}else {
			
			$data = array(
				"Error" => "Error getting new Payments"
			);
		}
		
		// Put the data into the response & return it
		$this->response->setBody($this->serializer->serializeArray( $data ));
		$this->response->addHeader("Content-type", $this->serializer->getcontentType());
		return $this->response;
	
	
	
	}
	
	public function chooseReward(SS_HTTPRequest $request){
	
	// Get inputs from post variables
		$userID = $request->postVar("userID");
		$token = $request->postVar("token");
		$rewardID = $request->postVar("rewardID");

		// Try to make the transfer
		$output = BankAccessor::create()->chooseReward($userID, $token, $rewardID);
		$data = null;
		
		// Decide what data to give back
		if ($output->didPass() ) {
			
			$data = array(
				"rewardTaken" => $output->getRewardTaken()->ID,
				"reward" => $output->getReward()->ID
			);
		}else {
			
			$data = array(
				"Error" => "Error choosing a reward"
			);
		}
		
		// Put the data into the response & return it
		$this->response->setBody($this->serializer->serializeArray( $data ));
		$this->response->addHeader("Content-type", $this->serializer->getcontentType());
		return $this->response;
	
	
	
	
	}
	
	public function performSpin(SS_HTTPRequest $request){
	
		// Get inputs from post variables
		$userID = $request->postVar("userID");
		$token = $request->postVar("token");
		
		// Try to make the transfer
		$output = BankAccessor::create()->performSpin($userID, $token);
		$data = null;
		
		// Decide what data to give back
		if ($output != null ) {
			$data = array(
				"Points" => $output->Points
			);
		}else {
			
			$data = array(
				"Error" => "Error performing a spin"
			);
		}
		
		// Put the data into the response & return it
		$this->response->setBody($this->serializer->serializeArray( $data ));
		$this->response->addHeader("Content-type", $this->serializer->getcontentType());
		return $this->response;
	}
	
	public function getAllRewards(){
	
		$output = BankAccessor::create()->getAllRewards();
		$data = null;
		
		// Decide what data to give back
		if (sizeof($output) > 0 ) {
			$data = array(
				"Rewards" => $output
			);
		}else {
			
			$data = array(
				"Error" => "Error performing a spin"
			);
		}
		
		// Put the data into the response & return it
		$this->response->setBody($this->serializer->serializeArray( $data ));
		$this->response->addHeader("Content-type", $this->serializer->getcontentType());
		return $this->response;
	
	}
	
	public function getLastPoints(SS_HTTPRequest $request){
		
		// Get inputs from post variables
		$userID = $request->postVar("userID");
		$token = $request->postVar("token");
		
		$output = BankAccessor::create()->getLastPoints($userID, $token);
		$data = null;
		
		// Decide what data to give back
		if (sizeof($output) > 0 ) {
			$data = array(
				"LastPoints" => $output
			);
		}else {
			
			$data = array(
				"Error" => "Error performing a spin"
			);
		}
		
		// Put the data into the response & return it
		$this->response->setBody($this->serializer->serializeArray( $data ));
		$this->response->addHeader("Content-type", $this->serializer->getcontentType());
		return $this->response;
	
	
	
	
	}
	
}
?>