<?php

/*
	This gets the information from the mobile app, converts it to 
	the form wanted by BankAccessor and then returns the results 
	as a JSON object back to the app 
*/
class MobileApiController extends Controller {

	//	Sets the list of allowed actions
	private static $allowed_actions = array(
        'login', 'loadTransactions','makeTransfer','logout',"getStatementDates",'newPayments','chooseReward', "performSpin","getAllRewards","getLastPoints"
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
		
			$categories = BankAccessor::create()->getUserCategories($output->GetUser()->ID, $output->getToken());
			
			$data = array(
				"User" => $output->GetUser(),
				"NewProducts" => $output->getAllProducts(),
				"Token" => $output->getToken(),
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
			
			$data = array(
				"Error" => "Error making transfer"
			);
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
	
	//	Lets the user categorise their payments
	public function categorisePayments(SS_HTTPRequest $request){
	
		// Get inputs from post variables
		$userID = $request->postVar("userID");
		$categorises = $request->postVar("categories");
		$token = $request->postVar("token");

		// Try to categorise payments
		$output = BankAccessor::create()->categorisePayments($userID,$token, $categorises);
		$data = null;
		
		// Decide what data to give back
		if ($output->didPass()) {
			
			$data = array(
				"changedCategorys" => $output->getChangedCategorys(),
				"changedTransactions" => $output->getChangedTransactions(),
				"newSpin" => $output->allowedNewSpin(),
				"numberOfSpins" => $output->allowedNewSpin(),
				"successful" => $this->didPass()
			);
		}else {
			
			$data = array(
				"Error" => "Error categorising new payments",
				"Reason" => $output->getReason()
			);
		}
		
		// Put the data into the response & return it
		$this->response->setBody($this->serializer->serializeArray( $data ));
		$this->response->addHeader("Content-type", $this->serializer->getcontentType());
		return $this->response;
	
	}
	
	//	Allows the user to update the information in their budget
	public function updateBudget(SS_HTTPRequest $request){
		
		// Get inputs from post variables
		$userID = $request->postVar("userID");
		$token = $request->postVar("token");
		$updatedGroupNames = $request->postVar("groupNames");
		$updatedCategoryNames = $request->postVar("categoryNames");
		$updatedCategoryBudget = $request->postVar("budgetAmount");
		

		// Try to update the users budget
		$output = BankAccessor::create()->updateBudget( $userID, $token, $updatedGroupNames, $updatedCategoryNames, $updatedCategoryBudget, null, null, null, null);
		$data = null;
		
		// Decide what data to give back
		if ($output->didPass()) {
			
			$data = array(
				"changedCategorys" => $output->getUpdatedCats(),
				"changedGroups" => $output->getUpdatedGroups(),
				"successful" => $this->didPass()
			);
		}else {
			
			$data = array(
				"Error" => "Error categorising new payments"
			);
		}
		
		// Put the data into the response & return it
		$this->response->setBody($this->serializer->serializeArray( $data ));
		$this->response->addHeader("Content-type", $this->serializer->getcontentType());
		return $this->response;
		

		return BankAccessor::create()->deleteBudget($userID, $token, $groupID);

		return BankAccessor::create()->editGroups($userID, $token ,$groupID, $groupName, $updatedCategories, $newCats, $deletedCats);

		return BankAccessor::create()-> createGroup($userID, $token, $groupName, $newCategories);
	
	
	
		
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
			
			$data = array(
				"Error" => "Error choosing a reward"
			);
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
			$data = array(
				"points" => $output->Points
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
			
			$data = array(
				"Error" => "Error getting all rewards"
			);
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
			
			$data = array(
				"Error" => "Error getting last points"
			);
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
			
			$data = array(
				"Error" => "Error getting categories"
			);
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
		if (sizeof($output) > 0 ) {
			$data = array(
				"ATMs" => $output,
			);
		}else {
			
			$data = array(
				"Error" => "Error getting ATM's"
			);
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
		
		//	Generate a heat map for the user 
		$output = BankAccessor::create()->loadHeatMap($userID, $token, $accounts, $startDate, $endDate);
		$data = null;
		
		// Decide what data to give back
		if (sizeof($output) > 0 ) {
			$data = array(
				"heatMapPoints" => $output,
			);
		}else {
			
			$data = array(
				"Error" => "Error getting HeatMap"
			);
		}
		
		// Put the data into the response & return it
		$this->response->setBody($this->serializer->serializeArray( $data ));
		$this->response->addHeader("Content-type", $this->serializer->getcontentType());
		return $this->response;
	}
}
?>