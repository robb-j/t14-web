<?php

/* 
 * Created by Martin Smith - Feb 2015
 */
 
/*
	This gets the information from the mobile app, converts it to 
	the form wanted by BankAccessor and then returns the results 
	as a JSON object back to the app 
*/
class MobileApiController extends Controller {

	//	Sets the list of allowed actions
	private static $allowed_actions = array(
        'login', 'loadTransactions','makeTransfer','logout',"getStatementDates",'newPayments','chooseReward', "performSpin","getAllRewards","getLastPoints","categorisePayments","updateBudget","getUserCategories","loadATMs","loadHeatMap"
    );
    
	//	Initialises the API
    public function init() {
	
	    parent::init();
	    
	    $this->serializer = new SimpleSerializer();
	    
	    
	    // Add the json header
	    $this->response->addHeader("Content-type", $this->serializer->getcontentType());
	    
	    
	    // Make sure the response doesn't cache
	    $this->response->addHeader("Cache-Control", "no-cache, no-store, must-revalidate");
	    $this->response->addHeader("Pragma", "no-cache");
	    $this->response->addHeader("Expires", "0");
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
		
			// Get values to put into response
			$categories = BankAccessor::create()->getUserCategories($output->GetUser()->ID, $output->getToken());
			$newPayments = BankAccessor::create()->newPayments($output->GetUser()->ID, $output->getToken())->getPayments();
			$allProducts = Product::get();
			
			// Just pass the ids of new products, along with the list of them all
			$newProducts = new ArrayList();
			foreach ($output->getAllProducts() as $product) {
				$newProducts->push($product->ID);
			}
			
			$data = array(
				"User" => $output->GetUser(),
				"Token" => $output->getToken(),
				"NewProducts" => $newProducts,
				"AllProducts" => $allProducts,
				"NumNewPayments" => $newPayments->count(),
				"Accounts" => $output->getAccounts(),
				
				"Groups" => BudgetGroup::get()->filter(array(
								'UserID' => $output->GetUser()->ID
							)),
							
				"Categories" =>	$categories,
				
				"RecentGains" => PointGain::get()->filter(array(
								'UserID' => $output->GetUser()->ID
							))->sort('ID', 'DESC')->limit(7),
				
				"RecentRewards" => RewardTaken::get()->filter(array(
								'UserID' => $output->GetUser()->ID
							))->sort('ID', 'DESC')->limit(7),
				
				"Rewards" => Reward::get()

			);
		}else {
			
			$this->response->setStatusCode(400);
			$data = $this->formatError($output->getReason(),true);
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
		
		if ($output->didPass()) {
			
			//	Builds the returned data
			$data = array(
				"Transactions" => $output->getTransactions(),
				"Account" => $output->getAccount()
			);
		}
		else {
			
			$this->response->setStatusCode(400);
			$data = $this->formatError($output->getReason(),BankAccessor::create()->checkUserSession($userID,$token));
		}

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
			
			$this->response->setStatusCode(400);

			$data = $this->formatError("Error making transfer", $userID, $token);
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
		
		if ($output == 0) {
			
			$data = array(
				"Message" => "Successfully logged out",
			);
		}
		else if($output == 1){

			$this->response->setStatusCode(400);

			$data = $this->formatError("Error making transfer", $userID, $token);
			
		}else{
			
			$this->response->setStatusCode(400);

			$data = $this->formatError("Error making transfer", $userID, $token);
		}
		
		$this->response->setBody($this->serializer->serializeArray( $data ));
		$this->response->addHeader("Content-type", $this->serializer->getcontentType());
		return $this->response;
	}
	
	public function getStatementDates(SS_HTTPRequest $request){
	
	// Get inputs from post variables
		$userID = $request->postVar("userID");
		$accountID = $request->postVar("accountID");
		$token = $request->postVar("token");

		// Try to make the transfer
		$output = BankAccessor::create()->getStatementDates($userID, $accountID, $token);
		$data = null;
		
		// Decide what data to give back
		if (sizeof($output)>0) {
			
			$data = array(
				"Dates" => $output
			);
		}else {
			
			$this->response->setStatusCode(400);

			$data = $this->formatError("Error making transfer", $userID, $token);
		}
		
		// Put the data into the response & return it
		$this->response->setBody($this->serializer->serializeArray( $data ));
		$this->response->addHeader("Content-type", $this->serializer->getcontentType());
		return $this->response;
	}
	
	//	####################################
	//	#### Intermediate  Requirements ####
	//	####################################
	
	//	Get all of the payments without a category
	public function newPayments(SS_HTTPRequest $request){
	
		// Get inputs from post variables
		$userID = $request->postVar("userID");
		$token = $request->postVar("token");

		// Try to get all uncategorised payments
		$output = BankAccessor::create()->newPayments($userID, $token);
		$data = null;
		
		
		
		// Decide what data to give back
		if ($output->didPass() ) {
			$data = array(
			
				"transactions" => $output-> getPayments()
			);
		}else {
			
			$this->response->setStatusCode(400);

			$data = $this->formatError("Error making transfer", $userID, $token);
		}
		
		// Put the data into the response & return it
		$this->response->setBody($this->serializer->serializeArray( $data ));
		$this->response->addHeader("Content-type", $this->serializer->getcontentType());
		return $this->response;
	}
	
	//	Lets the user categorise their payments
	public function categorisePayments(SS_HTTPRequest $request){
	
		// Get inputs from post variables
		$userID = Convert::raw2sql( $request->postVar("userID") );
		$categorises = $request->postVar("categories");
		$token = Convert::raw2sql( $request->postVar("token") );
		
		if ($categorises == null || count($categorises) == 0) {
			
			$this->response->setStatusCode(400);

			$data = $this->formatError("Error making transfer", $userID, $token);
		}
		
		else {
	
			// Try to categorise payments
			$output = BankAccessor::create()->categorisePayments($userID,$token, $categorises);
			$data = null;
			
			// Decide what data to give back
			if ($output->didPass()) {
				
				$newPayments = BankAccessor::create()->newPayments($userID, $token)->getPayments();
				
				$data = array(
					"changedCategorys" => $output->getChangedCategorys(),
					"newSpin" => $output->allowedNewSpin(),
					"numberOfSpins" => $output->getCurrentSpins(),
					"numNewPayments" => $newPayments->count()
				);
			}else {
				
				$this->response->setStatusCode(400);

				$data = $this->formatError("Error making transfer", $userID, $token);
			}
		}
		
		// Put the data into the response & return it
		$this->response->setBody($this->serializer->serializeArray( $data ));
		$this->response->addHeader("Content-type", $this->serializer->getcontentType());
		return $this->response;
	
	}
	
	public function updateBudget(SS_HTTPRequest $request) {
				
		// Get the params from the request
		$userID = $request->postVar("userID");
		$token = $request->postVar("token");
		$groupData = $request->postVar("groups");
		
		
		// Pass the message onto BankAccessor
		$output = BankAccessor::create()->mobileBudgetEdit($userID, $token, $groupData);
		
		
		if ($output->didPass()) {
			
			// If it passed, put the returned data into json
			$data = array(
				"Groups" => $output->getGroups(),
				"Categories" => $output->getCategories(),
			);
			
		}
		else {
			
			// Otherwise output the error
			$this->response->setStatusCode(400);

			$data = $this->formatError("Error making transfer", $userID, $token);
		}
		
		
		// Parse the keyed-array into a json string & return it
		$this->response->setBody($this->serializer->serializeArray( $data ));
		$this->response->addHeader("Content-type", $this->serializer->getcontentType());
		return $this->response;
	}

	//	Lets the user choose a reward from a list
	public function chooseReward(SS_HTTPRequest $request){
	
	// Get inputs from post variables
		$userID = $request->postVar("userID");
		$token = $request->postVar("token");
		$rewardID = $request->postVar("rewardID");

		// Try to choose a reward for the user 
		$output = BankAccessor::create()->chooseReward($userID, $token, $rewardID);
		$data = null;
		
		// Decide what data to give back
		if ($output->didPass() ) {
			
			$data = array(
				"rewardTaken" => $output->getRewardTaken(),
				"reward" => $output->getReward()
			);
		}else {
			
			$this->response->setStatusCode(400);

			$data = $this->formatError("Error making transfer", $userID, $token);
		}
		
		// Put the data into the response & return it
		$this->response->setBody($this->serializer->serializeArray( $data ));
		$this->response->addHeader("Content-type", $this->serializer->getcontentType());
		return $this->response;
	}
	
	//	Gets the user to perform a spin
	public function performSpin(SS_HTTPRequest $request){
	
		// Get inputs from post variables
		$userID = $request->postVar("userID");
		$token = $request->postVar("token");
		
		// Try to perform a spin
		$output = BankAccessor::create()->performSpin($userID, $token);
		$data = null;
		
		// Decide what data to give back
		if ($output != null ) {
			
			$user = User::get()->byId(Convert::raw2sql($userID));
			
			$data = array(
				"newPoints" => $output->Points,
				"totalPoints" => $user->Points,
				"currentSpins" => $user->NumberOfSpins,
			);
		}else {
			
			$this->response->setStatusCode(400);

			$data = $this->formatError("Error making transfer", $userID, $token);
		}
		
		// Put the data into the response & return it
		$this->response->setBody($this->serializer->serializeArray( $data ));
		$this->response->addHeader("Content-type", $this->serializer->getcontentType());
		return $this->response;
	}
	
	//	Get a list of all rewards offered
	public function getAllRewards(){
	
		//	get all rewards offered
		$output = BankAccessor::create()->getAllRewards();
		$data = null;
		
		// Decide what data to give back
		if (sizeof($output) > 0 ) {
			$data = array(
				"rewards" => $output
			);
		}else {
			
			$this->response->setStatusCode(400);

			$data = $this->formatError("Error making transfer", $userID, $token);
		}
		
		// Put the data into the response & return it
		$this->response->setBody($this->serializer->serializeArray( $data ));
		$this->response->addHeader("Content-type", $this->serializer->getcontentType());
		return $this->response;
	
	}
	
	//	Gets the last n points the user earned
	public function getLastPoints(SS_HTTPRequest $request){
		
		// Get inputs from post variables
		$userID = $request->postVar("userID");
		$token = $request->postVar("token");
		
		//	Get the last n points gained by the user
		$output = BankAccessor::create()->getLastPoints($userID, $token);
		$data = null;
		
		// Decide what data to give back
		if (sizeof($output) > 0 ) {
			$data = array(
				"lastPoints" => $output,
			);
		}else {
			
			$this->response->setStatusCode(400);

			$data = $this->formatError("Error making transfer", $userID, $token);
		}
		
		// Put the data into the response & return it
		$this->response->setBody($this->serializer->serializeArray( $data ));
		$this->response->addHeader("Content-type", $this->serializer->getcontentType());
		return $this->response;
	}
	
	//	Gets all of the users budget categories
	public function getUserCategories(SS_HTTPRequest $request){
		
		// Get inputs from post variables
		$userID = $request->postVar("userID");
		$token = $request->postVar("token");
		
		//	Get the list of all user categories
		$output = BankAccessor::create()->getUserCategories($userID, $token);
		$data = null;
		
		// Decide what data to give back
		if (sizeof($output) > 0 ) {
			$data = array(
				"categories" => $output,
			);
		}else {
			
			$this->response->setStatusCode(400);

			$data = $this->formatError("Error making transfer", $userID, $token);
		}
		
		// Put the data into the response & return it
		$this->response->setBody($this->serializer->serializeArray( $data ));
		$this->response->addHeader("Content-type", $this->serializer->getcontentType());
		return $this->response;
	}
	
	//	################################
	//	#### Advanced  Requirements ####
	//	################################
	
	//	Loads all of the ATM's stored
	public function loadATMs(SS_HTTPRequest $request){
		
		// Get inputs from post variables
		$userID = $request->postVar("userID");
		$token = $request->postVar("token");
		
		//	Load all of the ATM locations
		$output = BankAccessor::create()->loadATMs($userID, $token);
		$data = null;
		
		// Decide what data to give back
		if ($output->count() > 0 ) {
			$data = array(
				"ATMs" => $output
			);
		}else {
			
			$this->response->setStatusCode(400);

			$data = $this->formatError("Error making transfer", $userID, $token);
		}

		// Put the data into the response & return it
		$this->response->setBody($this->serializer->serializeArray( $data ));
		$this->response->addHeader("Content-type", $this->serializer->getcontentType());
		return $this->response;
	}
	
	//	Creates a heatmap for the users transactions 
	public function loadHeatMap(SS_HTTPRequest $request){
		
		// Get inputs from post variables
		$userID = $request->postVar("userID");
		$token = $request->postVar("token");
		$accounts = $request->postVar("accounts");
		$startDate = $request->postVar("startDate");
		$endDate = $request->postVar("endDate");
		
		if ($accounts == null) {
			$accounts = array();
		}
		
		//	Generate a heat map for the user 
		$output = BankAccessor::create()->loadHeatMap($userID, $token, $accounts, $startDate, $endDate);
		$data = null;
		
		// Decide what data to give back
		if (sizeof($output) > 0 ) {
			$data = array(
				"heatMapPoints" => $output
			);
		}else {
			
			$this->response->setStatusCode(400);

			$data = $this->formatError("Error making transfer", $userID, $token);
		}
		
		// Put the data into the response & return it
		$this->response->setBody($this->serializer->serializeArray( $data ));
		$this->response->addHeader("Content-type", $this->serializer->getcontentType());
		return $this->response;
	}
	
	// formats the error messages
	private function formatError($reason, $userID, $token) {
		
		$loggedIn = BankAccessor::create()->checkSessionActive($userID, $token);
		
		return array(
			"Error" => $reason,
			"LoggedIn" => $loggedIn
		);
	}
}
?>