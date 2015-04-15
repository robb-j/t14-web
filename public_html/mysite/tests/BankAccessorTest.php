<?php

/**
 * This tests BankAccessor
 * Martin S  - 27/02/2015
 */
class BankAccessorTest extends SapphireTest {

	//	The test data is held here
	static $fixture_file = 'mysite/tests/TestUsers.yml';
	

	/**
	 * @Before
	 */
	public function setup() {
		
		// Something that happens before EACH test
		parent::setup();
		
	}
	
	/**
	 * @TearDown
	 */
	public function tearDown() {
		
		// Something that happens after EACH test
		parent::tearDown();
	}
	/*
	
		Basic Tests
		
	*/
	
	//	#######################################
	//	#### Tests for Login using the web ####
	//	#######################################
	
	public function testLoginCorrectUsernameCorrectPasswordCorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myThirdPerson');
		$this->assertEquals($user->Username, $accessor->login($user->Username,"Password",null,false)->getUser()->Username);
    }
	
	public function testLoginIncorrectUsernameCorrectPasswordCorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myThirdPerson');
		
		$this->assertEquals($expected, $accessor->login("WrongUser","Password",null,false)->getUser());
    }
	
	public function testLoginCorrectUsernameIncorrectPasswordCorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myThirdPerson');
		
		$this->assertEquals($expected, $accessor->login($user->Username,"WrongPassword",null,false)->getUser());
    }
	
	public function testLoginCorrectUsernameCorrectPasswordIncorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myThirdPerson');
		
		$this->assertEquals($expected, $accessor->login($user->Username,"Password",null,true)->getUser());
    }
	
	public function testLoginIncorrectUsernameIncorrectPasswordCorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myThirdPerson');
		
		$this->assertEquals($expected, $accessor->login("WrongUser","WrongPassword",null,false)->getUser());
    }
	
	public function testLoginIncorrectUsernameCorrectPasswordIncorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myThirdPerson');
		
		$this->assertEquals($expected, $accessor->login("wrongUser","Password",null,true)->getUser());
    }
	
	public function testLoginCorrectUsernameIncorrectPasswordIncorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myThirdPerson');
		
		$this->assertEquals($expected, $accessor->login($user->Username,"WrongPassword",null,true)->getUser());
    }
	
	public function testLoginIncorrectUsernameIncorrectPasswordIncorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myThirdPerson');
		
		$this->assertEquals($expected, $accessor->login("WrongUser","WrongPassword",null,true)->getUser());
    }

	//	##############################################
	//	#### Tests for Login using the mobile app ####
	//	##############################################
	
	public function testLoginCorrectUsernameCorrectPasswordCorrectIndexesCorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = "myThirdPerson";
		$array = array(0,1,2);
		$user = $this->objFromFixture('User','myThirdPerson');
		
		$this->assertEquals($user->Username, $accessor->login($user->Username,"Pas",$array,true)->getUser()->Username);
    }
	
	public function testLoginInCorrectUsernameCorrectPasswordCorrectIndexesCorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = null;
		$array = array(0,1,2);
		$user = $this->objFromFixture('User','myThirdPerson');
		
		$this->assertEquals($expected, $accessor->login("WrongUser","Pas",$array,true)->getUser());
    }
	
	public function testLoginCorrectUsernameIncorrectPasswordCorrectIndexesCorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = null;
		$array = array(0,1,2);
		$user = $this->objFromFixture('User','myThirdPerson');
		
		$this->assertEquals($expected, $accessor->login($user->Username,"Pat",$array,true)->getUser());
    }
	
	public function testLoginCorrectUsernameCorrectPasswordIncorrectIndexesCorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = null;
		$array = array(0,1,8);
		$user = $this->objFromFixture('User','myThirdPerson');
		
		$this->assertEquals($expected, $accessor->login($user->Username,"Pas",$array,true)->getUser());
    }
	
	public function testLoginCorrectUsernameCorrectPasswordCorrectIndexesIncorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = null;
		$array = array(0,1,2);
		$user = $this->objFromFixture('User','myThirdPerson');
		
		$this->assertEquals($expected, $accessor->login($user->Username,"Pas",$array,false)->getUser());
    }
	
	public function testLoginCorrectUsernameIncorrectPasswordSizeCorrectIndexesCorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = null;
		$array = array(0,1,2);
		$user = $this->objFromFixture('User','myThirdPerson');
		
		$this->assertEquals($expected, $accessor->login($user->Username,"Pass",$array,true)->getUser());
    }
	
	public function testLoginCorrectUsernameCorrectPasswordIncorrectIndexesSizeCorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = null;
		$array = array(0,1,2,3);
		$user = $this->objFromFixture('User','myThirdPerson');
		
		$this->assertEquals($expected, $accessor->login($user->Username,"Pas",$array,true)->getUser());
    }
	
	//	######################################
	//	#### Tests for LoginOutput object ####
	//	######################################
	
	public function testLoginOutputDidPassCorrectInformation() {
		
		$accessor = new BankAccessor();
		$expected = true;
		$user = $this->objFromFixture('User','myThirdPerson');
	   
		$this->assertEquals($expected, $accessor->login($user->Username,"Password",null,false)->didPass());
    }
	
	public function testLoginOutputDidPassIncorrectInformation() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myThirdPerson');
	   
		$this->assertEquals($expected, $accessor->login($user->Username,"NotPassword",null,false)->didPass());
    }
	
	public function testLoginOutputCorrectInformationGetCorrectUser() {
		
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myThirdPerson');
		$expected = $user;
		
		$this->assertEquals($expected, $accessor->login($user->Username,"Password",null,false)->getUser());
    }
	
	public function testLoginOutputInCorrectInformationGetCorrectUser() {
		
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myThirdPerson');
		$expected = null;
		
		$this->assertEquals($expected, $accessor->login($user->Username,"NotPassword",null,false)->getUser());
    }
	
	public function testLoginOutputCorrectInformationCorrectAccounts(){
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myThirdPerson');
		
		$accounts = $accessor->login($user->Username,"Password",null,false)->getAccounts();
		if(sizeof($accounts)===2 && (int)$accounts[0]->UserID === 3 && (int)$accounts[1]->UserID === 3){
			$this->assertTrue(true);
		}else{
			$this->assertTrue(false);
		}
	}
	
	public function testLoginOutputInorrectInformationCorrectAccounts(){
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myThirdPerson');
		
		$accounts = $accessor->login($user->Username,"NotPassword",null,false)->getAccounts();
		if($accounts === null){
			$this->assertTrue(true);
		}else{
			$this->assertTrue(false);
		}
	}
	
	public function testLoginOutputCorrectInformationCorrectProducts(){
	
		$accessor = new BankAccessor();
		
		$user = $this->objFromFixture('User','myThirdPerson');
		$products =$accessor->login($user->Username,"Password",null,false)->getAllProducts();

		if(sizeof($products)===1 && (int)$products[0]->ID === 3 ){
			$this->assertTrue(true);
		}else{
			$this->assertTrue(false);
		}
	}
	
	public function testLoginOutputInorrectInformationCorrectProducts(){
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myThirdPerson');
		
		$products = $accessor->login($user->Username,"NotPassword",null,false)->getAllProducts();
		if(sizeof($products)===0 ){
			$this->assertTrue(true);
		}else{
			$this->assertTrue(false);
		}
	}

	public function testLoginOutputCorrectInformationGetAToken() {
		
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myThirdPerson');
		$expected = null;
		
		$this->assertNotEquals($expected, $accessor->login($user->Username,"Password",null,false)->getToken());
    }
	
	public function testLoginOutputInCorrectInformationGetNoToken() {
		
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myThirdPerson');
		$expected = null;
		
		$this->assertEquals($expected, $accessor->login($user->Username,"NotPassword",null,false)->getToken());
    }
	
	//	#######################################
	//	#### Tests for Login SQL Injection ####
	//	#######################################
	
	public function testSQLInjectionLoginUsernameField() {
		
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myThirdPerson');
	   
		$this->assertEquals($expected, $accessor->login($user->Username."; DROP TABLE User","Password",null,false)->getUser());
    }
	
	public function testSQLInjectionLoginPasswordField() {
		
		$accessor = new BankAccessor();
		$expected = null;
	    $user = $this->objFromFixture('User','myThirdPerson');
	   
		$this->assertEquals($expected, $accessor->login($user->Username,"Password; DROP TABLE User",null,false)->getUser());
    }
	
	public function testSQLInjectionLoginIndexesField() {
		
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myThirdPerson');
	   
		$this->assertEquals($user, $accessor->login($user->Username,"Password","DROP TABLE User",false)->getUser());
    }
	
	//	####################################
	//	#### Tests for LoadTransactions ####
	//	####################################
	
	public function testLoadTransactionsCorrectInformation(){
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$transactions = $accessor->loadTransactions( $user->ID, 1, 3, 2015, $session->Token );
		
		$this->assertEquals(3,sizeof($transactions->getTransactions()));

	}
	
	public function testLoadTransactionsUserIDNotMatchToken(){
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$transactions = $accessor->loadTransactions( $user->ID, 1, 3, 2015, "SomeRubbish" );
		
		$this->assertEquals(null,$transactions->getTransactions());

	}
	
	public function testLoadTransactionsDontOwnAccount(){
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$transactions = $accessor->loadTransactions( $user->ID, 3, 3, 2015, $session->Token );
		
		$this->assertEquals(null,$transactions->getTransactions());

	}
	
	public function testLoadTransactionsAccountDoesntExist(){
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$transactions = $accessor->loadTransactions( $user->ID, 999, 3, 2015, $session->Token );
		
		$this->assertEquals(null,$transactions->getTransactions());

	}
	
	public function testLoadTransactionsNoTransactions(){
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$transactions = $accessor->loadTransactions( $user->ID, 1, 7, 2015, $session->Token );
		
		$this->assertEquals(0,sizeof($transactions->getTransactions()));

	}
	
	public function testLoadTransactionsCorrectInformationReturnCorrectAccount(){
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$transactions = $accessor->loadTransactions( $user->ID, 1, 7, 2015, $session->Token );
		
		$this->assertEquals(1,$transactions->getAccount()->ID);

	}
	
	public function testLoadTransactionsInorrectInformationReturnCorrectAccount(){
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$transactions = $accessor->loadTransactions( $user->ID, 1, 7, 2015, "noToken" );
		
		$this->assertEquals(null,$transactions->getAccount());

	}
	
	//	##################################################
	//	#### Tests for LoadTransactions SQL Injection ####
	//	##################################################
	
	public function testSQLInjectionLoadTransactionsUserID() {
		
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
	   
		$this->assertEquals($expected, $accessor->loadTransactions($user->ID."; DROP TABLE User",1,3,2015,$session->Token)->getTransactions());
    }
	
	public function testSQLInjectionLoadTransactionsAccountID() {
		
		$accessor = new BankAccessor();
		$expected = 3;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
	   
		$this->assertEquals($expected, sizeof($accessor->loadTransactions($user->ID,"1; DROP TABLE User",3,2015,$session->Token)->getTransactions()));
    }
	
	public function testSQLInjectionLoadTransactionsMonth() {
		
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
	   
		$this->assertEquals($expected, $accessor->loadTransactions($user->ID,1,"3; DROP TABLE User",2015,$session->Token)->getTransactions());
    }
	
	public function testSQLInjectionLoadTransactionsYear() {
		
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
	   
		$this->assertEquals($expected, $accessor->loadTransactions($user->ID,1,3,"2015; DROP TABLE User",$session->Token)->getTransactions());
    }
	
	public function testSQLInjectionLoadTransactionsToken() {
		
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
	   
		$this->assertEquals($expected, $accessor->loadTransactions($user->ID,1,3,2015,$session->Token."; DROP TABLE User")->getTransactions());
    }
	
	//	################################
	//	#### Tests for MakeTransfer ####
	//	################################
	
	public function testMakeTransferCorrectInformation() {
		
		$accessor = new BankAccessor();
		$expected = true;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$accA = $this->objFromFixture('Account','accountOne');
		$accB = $this->objFromFixture('Account','accountTwo');
		
		$this->assertEquals($expected, $accessor->MakeTransfer($user->ID,$accA->ID,$accB->ID,50,$session->Token)->didPass());
    }
	public function testMakeTransferCorrectInformationANewBalance() {
		
		$accessor = new BankAccessor();
		
		
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$accA = $this->objFromFixture('Account','accountOne');
		$accB = $this->objFromFixture('Account','accountTwo');
		
		$aOldBalance = $accA->Balance;
		$aNewBalance = $accessor->MakeTransfer($user->ID,$accA->ID,$accB->ID,50,$session->Token)->getPayerNewBalance();
		$expected = $aOldBalance - 50;
		
		$this->assertEquals($expected, $aNewBalance );
    }
	
	public function testMakeTransferCorrectInformationBNewBalance() {
		
		$accessor = new BankAccessor();
		
		
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$accA = $this->objFromFixture('Account','accountOne');
		$accB = $this->objFromFixture('Account','accountTwo');
		
		$bOldBalance = $accB->Balance;
		$bNewBalance = $accessor->MakeTransfer($user->ID,$accA->ID,$accB->ID,50,$session->Token)->getPayeeNewBalance();
		$expected = $bOldBalance + 50;
		
		$this->assertEquals($expected, $bNewBalance );
    }

	public function testMakeTransferInorrectInformationTokenDoesntMatch() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$accA = $this->objFromFixture('Account','accountOne');
		$accB = $this->objFromFixture('Account','accountTwo');
		
		$this->assertEquals($expected, $accessor->MakeTransfer($user->ID,$accA->ID,$accB->ID,50,"notToken")->didPass());
    }
	
	public function testMakeTransferAccountANotOwnedByUser() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$accA = $this->objFromFixture('Account','accountThree');
		$accB = $this->objFromFixture('Account','accountTwo');
		
		$this->assertEquals($expected, $accessor->MakeTransfer($user->ID,$accA->ID,$accB->ID,50,$session->Token)->didPass());
    }
	
	public function testMakeTransferAccountBNotOwnedByUser() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$accA = $this->objFromFixture('Account','accountOne');
		$accB = $this->objFromFixture('Account','accountThree');
		
		$this->assertEquals($expected, $accessor->MakeTransfer($user->ID,$accA->ID,$accB->ID,50,$session->Token)->didPass());
    }
	
	 public function testMakeTransferAccountsSameAccount() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$accA = $this->objFromFixture('Account','accountOne');
		
		$this->assertEquals($expected, $accessor->MakeTransfer($user->ID,$accA->ID,$accA->ID,50,$session->Token)->didPass());
    }
	
	public function testMakeTransferAmountNegative() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$accA = $this->objFromFixture('Account','accountOne');
		$accB = $this->objFromFixture('Account','accountTwo');
		
		$this->assertEquals($expected, $accessor->MakeTransfer($user->ID,$accA->ID,$accB->ID,-50,$session->Token)->didPass());
    }
	
	public function testMakeTransferNotEnoughAvailbleMoney() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$accA = $this->objFromFixture('Account','accountOne');
		$accB = $this->objFromFixture('Account','accountTwo');
		
		$this->assertEquals($expected, $accessor->MakeTransfer($user->ID,$accA->ID,$accB->ID,10000000,$session->Token)->didPass());
    }
	
	//	##############################################
	//	#### Tests for Maketransfer SQL Injection ####
	//	##############################################
	
	public function testSQLInjectionMakeTransferUserID() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$accA = $this->objFromFixture('Account','accountOne');
		$accB = $this->objFromFixture('Account','accountTwo');
	   
		$this->assertEquals($expected, $accessor->MakeTransfer($user->ID."; DROP TABLE User",$accA->ID,$accB->ID,50,$session->Token)->didPass());
    }
	
	public function testSQLInjectionMakeTransferAccountAID() {
		
		$accessor = new BankAccessor();
		$expected = true;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
	   	$accA = $this->objFromFixture('Account','accountOne');
		$accB = $this->objFromFixture('Account','accountTwo');
		
		$this->assertEquals($expected, $accessor->MakeTransfer($user->ID,$accA->ID."; DROP TABLE User",$accB->ID,50,$session->Token)->didPass());
    }
	
	public function testSQLInjectionMakeTransferAccountBID() {
		
		$accessor = new BankAccessor();
		$expected = true;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
	   	$accA = $this->objFromFixture('Account','accountOne');
		$accB = $this->objFromFixture('Account','accountTwo');
		
		$this->assertEquals($expected, $accessor->MakeTransfer($user->ID,$accA->ID,$accB->ID."; DROP TABLE User",50,$session->Token)->didPass());
    }
	
	public function testSQLInjectionMakeTransferAmount() {
		
		$accessor = new BankAccessor();
		$expected = true;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
	   	$accA = $this->objFromFixture('Account','accountOne');
		$accB = $this->objFromFixture('Account','accountTwo');
		
		$this->assertEquals($expected, $accessor->MakeTransfer($user->ID,$accA->ID,$accB->ID,"50; DROP TABLE User",$session->Token)->didPass());
    }
	
	public function testSQLInjectionMakeTransferToken() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
	   	$accA = $this->objFromFixture('Account','accountOne');
		$accB = $this->objFromFixture('Account','accountTwo');
		
		$this->assertEquals($expected, $accessor->MakeTransfer($user->ID,$accA->ID,$accB->ID,50,$session->Token."; DROP TABLE User")->didPass());
    }
	
	//	#########################################
	//	#### Tests for getNewProductsForUser ####
	//	#########################################
	
	public function testGetNewProductsCorrectInformation() {
		
		$accessor = new BankAccessor();
		$expected = 1;
		$user = $this->objFromFixture('User','myPerson');

		$this->assertEquals($expected, sizeof($accessor->getNewProductsForUser($user)));
    }
	
	public function testGetNewProductsUserHasGotAllProducts() {
		
		$accessor = new BankAccessor();
		$expected = 0;
		$user = $this->objFromFixture('User','allProductsPerson');

		$this->assertEquals($expected, sizeof($accessor->getNewProductsForUser($user)));
    }
	
	public function testGetNewProductsUserDoesntExist() {
		
		$accessor = new BankAccessor();
		$expected = 0;

		$this->assertEquals($expected, sizeof($accessor->getNewProductsForUser(null)));
    }
	
	//	##############################################
	//	#### Tests for Maketransfer SQL Injection ####
	//	##############################################
	
	public function testSQLInjectionGetNewProductsUser() {
		
		$accessor = new BankAccessor();
		$expected = 0;
		$user = $this->objFromFixture('User','allProductsPerson');

		$this->assertEquals($expected, sizeof($accessor->getNewProductsForUser($user."; DROP TABLE User")));
    }
	
	/*
	
		Intermediate tests
		
	*/
	
	//	#################################
	//	#### Tests for getLastPoints ####
	//	#################################
	
	public function testGetLastPointsAllCorrect() {
		
		$accessor = new BankAccessor();
		$expected = 7;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$this->assertEquals($expected,sizeof($accessor->GetLastPoints($user->ID,$session->Token)));
		
    }
	
	public function testGetLastPointIncorrectUserID() {
		
		$accessor = new BankAccessor();
		$expected = 0;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$this->assertEquals($expected,sizeof($accessor->GetLastPoints(99,$session->Token)));
	
    }
	
	public function testGetLastPointsIncorrectToken() {
		
		$accessor = new BankAccessor();
		$expected = 0;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$this->assertEquals($expected,sizeof($accessor->GetLastPoints($user->ID,"rubbish")));
		
    }
	
	public function testGetLastPointsLessThanSevenPointsGainedObjects() {
		
		$accessor = new BankAccessor();
		$expected = 1;
		$user = $this->objFromFixture('User','allProductsPerson');
		$session =$this->objFromFixture('UserSession','allProductsPersonSession');
		
		$this->assertEquals($expected,sizeof($accessor->GetLastPoints($user->ID,$session->Token)));
		
    }
	
	public function testGetLastPointsNoPointsGainedObjects() {
		
		$accessor = new BankAccessor();
		$expected = 0;
		$user = $this->objFromFixture('User','noAccountsPerson');
		$session =$this->objFromFixture('UserSession','noAccountsPersonSession');
		
		$this->assertEquals($expected,sizeof($accessor->GetLastPoints($user->ID,$session->Token)));
		
    }
	
	//	####################################################
	//	#### Tests for CategorisePayments SQL Injection ####
	//	####################################################
	
	public function testSQLInjectionGetLastPointsUserID() {
		
		$accessor = new BankAccessor();
		$expected = 0;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');

		$this->assertEquals($expected, sizeof($accessor->getLastPoints($user->ID."; DROP TABLE User",$session->Token)));
    }
	
	public function testSQLInjectionGetLastPointsToken() {
		
		$accessor = new BankAccessor();
		$expected = 0;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');

		$this->assertEquals($expected, sizeof($accessor->getLastPoints($user->ID,$session->Token."; DROP TABLE User")));
    }
	
	//	###############################
	//	#### Tests for newPayments ####
	//	###############################
	
	public function testNewPaymentsAllCorrect() {
		
		$accessor = new BankAccessor();
		$expected = 4;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$this->assertEquals($expected,sizeof($accessor->newPayments($user->ID,$session->Token)));
		
    }
	
	public function testNewPaymentsNoTransactions() {
		
		$accessor = new BankAccessor();
		$expected = 0;
		$user = $this->objFromFixture('User','allProductsPerson');
		$session =$this->objFromFixture('UserSession','allProductsPersonSession');
		
		$this->assertEquals($expected,sizeof($accessor->newPayments($user->ID,$session->Token)));
		
    }
	
	public function testNewPaymentsNoAccounts() {
		
		$accessor = new BankAccessor();
		$expected = 0;
		$user = $this->objFromFixture('User','noAccountsPerson');
		$session =$this->objFromFixture('UserSession','noAccountsPersonSession');
		
		$this->assertEquals($expected,sizeof($accessor->newPayments($user->ID,$session->Token)));
		
    }
	
	public function testNewPaymentsIncorrectUserID() {
		
		$accessor = new BankAccessor();
		$expected = 0;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$this->assertEquals($expected,sizeof($accessor->newPayments(5,$session->Token)));
		
    }
	
		public function testNewPaymentsIncorrectUserToken() {
		
		$accessor = new BankAccessor();
		$expected = 0;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$this->assertEquals($expected,sizeof($accessor->newPayments($user->ID,"rubbish")));
		
    }
	
	//	####################################################
	//	#### Tests for CategorisePayments SQL Injection ####
	//	####################################################
	
	public function testSQLInjectionNewPaymentsUserID() {
		
		$accessor = new BankAccessor();
		$expected = 0;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');

		$this->assertEquals($expected, sizeof($accessor->newPayments($user->ID."; DROP TABLE User",$session->Token)));
    }
	
	public function testSQLInjectionNewPaymentsToken() {
		
		$accessor = new BankAccessor();
		$expected = 0;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');

		$this->assertEquals($expected, sizeof($accessor->newPayments($user->ID,$session->Token."; DROP TABLE User")));
    }
	

	
	
	//	################################
	//	#### Tests for ChooseReward ####
	//	################################
	
	public function testChooserewardAllCorrect() {
		
		$accessor = new BankAccessor();
		$expected = true;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$this->assertEquals($expected,$accessor->chooseReward($user->ID,$session->Token,1)->didPass());
		
    }
	
	public function testChooserewardWrongID() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$this->assertEquals($expected,$accessor->chooseReward(9,$session->Token,1)->didPass());
		
    }
	
	public function testChooserewardWrongToken() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$this->assertEquals($expected,$accessor->chooseReward($user->ID,"Rubbish",1)->didPass());
		
    }
	
	public function testChooserewardNoSuchReward() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$this->assertEquals($expected,$accessor->chooseReward($user->ID,$session->Token,99)->didPass());
		
    }
	
	public function testChooserewardNotenoughPoints() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$this->assertEquals($expected,$accessor->chooseReward($user->ID,$session->Token,3)->didPass());
		
    }
	
	public function testChooserewardNoEmailGiven() {
		
		$accessor = new BankAccessor();
		$expected = true;
		$user = $this->objFromFixture('User','allProductsPerson');
		$session =$this->objFromFixture('UserSession','allProductsPersonSession');
		
		$this->assertEquals($expected,$accessor->chooseReward($user->ID,$session->Token,1)->didPass());
		
    }
	
	//	####################################################
	//	#### Tests for CategorisePayments SQL Injection ####
	//	####################################################
	
	public function testSQLInjectionChooseRewardUserID() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');

		$this->assertEquals($expected, $accessor->chooseReward($user->ID."; DROP TABLE User",$session->Token,1)->didPass());
    }
	
	public function testSQLInjectionChooseRewardToken() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');

		$this->assertEquals($expected, $accessor->chooseReward($user->ID,$session->Token."; DROP TABLE User",1)->didPass());
    }
	
	public function testSQLInjectionChooseRewardRewardID() {
		
		$accessor = new BankAccessor();
		$expected = true;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');

		$this->assertEquals($expected, $accessor->chooseReward($user->ID,$session->Token,"1; DROP TABLE User")->didPass());
    }
	
	
	//	###############################
	//	#### Tests for PerformSpin ####
	//	###############################
	
	public function testPerformSpinAllCorrect() {
		
		$accessor = new BankAccessor();
		$expected = 3;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$result = $accessor->PerformSpin($user->ID,$session->Token)->Points;
		if((int)$result > 0){
			
			$this->assertTrue(true);
		}else{
			$this->assertTrue(false);
		}
    }
	
	public function testPerformSpinWrongUserID() {
		
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$this->assertEquals($expected,$accessor->PerformSpin(99,$session->Token));
    }
	public function testPerformSpinWrongSessionToken() {
		
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$this->assertEquals($expected,$accessor->PerformSpin($user->ID,"Somerubish"));
    }
	
	
	
	public function testPerformSpinNoSpinsLeft() {
		
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','allProductsPerson');
		$session =$this->objFromFixture('UserSession','allProductsPersonSession');
		
		$this->assertEquals($expected, $accessor->PerformSpin($user->ID,$session->Token));
    }
	
	public function testPerformSpinAllCorrectPointsAdded() {
		
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$previous = $user->Points;
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$result = $accessor->PerformSpin($user->ID,$session->Token);
		$newPoints = $this->objFromFixture('User','myPerson')->Points;

		if((int)$newPoints > (int)$previous){
			
			$this->assertTrue(true);
		}else{
			$this->assertTrue(false);
		}
    }
	
	public function testPerformSpinAllCorrectSpinsReduced() {
		
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$previous = $user->NumberOfSpins;
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$result = $accessor->PerformSpin($user->ID,$session->Token);
		$newSpins = $this->objFromFixture('User','myPerson')->NumberOfSpins;
		
		if((int)$newSpins===( ((int)$previous) -1)){
			
			$this->assertTrue(true);
		}else{
			$this->assertTrue(false);
		}
    }

	//	####################################################
	//	#### Tests for CategorisePayments SQL Injection ####
	//	####################################################
	
		public function testSQLInjectionPerformSpinUserID() {
		
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');

		$this->assertEquals($expected, $accessor->PerformSpin($user->ID."; DROP TABLE User",$session->Token));
    }
	
	public function testSQLInjectionPerformSpinToken() {
		
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');

		$this->assertEquals($expected, $accessor->PerformSpin($user->ID,$session->Token."; DROP TABLE User"));
    }

	//	#################################
	//	#### Tests for GetAllRewards ####
	//	#################################
	
	public function testGetAllRewards() {
		
		$accessor = new BankAccessor();
		$expected = 3;

		$this->assertEquals($expected, sizeof($accessor->getAllRewards()));
    }
	
	//	######################################
	//	#### Tests for categorisePayments ####
	//	######################################
	
	public function testCategorisePaymentsAllCorrect() {
		
		$accessor = new BankAccessor();
		$expected = true;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$categories = array( 1=>1, 2=>1, 3=>1, 4=>1);

		$this->assertEquals($expected, $accessor->categorisePayments($user->ID, $session->Token,$categories )->didPass());
    }
	
	public function testCategorisePaymentsPaymentsDontExist() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','allProductsPerson');
		$session =$this->objFromFixture('UserSession','allProductsPersonSession');
		$categories = array( 88=>1, 99=>1, 66=>1, 55=>1);

		$this->assertEquals($expected, $accessor->categorisePayments($user->ID, $session->Token,$categories )->didPass());
    }
	
	public function testCategorisePaymentsPaymentsDontBelongToUser() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','allProductsPerson');
		$session =$this->objFromFixture('UserSession','allProductsPersonSession');
		$categories = array( 1=>1, 2=>1, 3=>1, 4=>1);

		$this->assertEquals($expected, $accessor->categorisePayments($user->ID, $session->Token,$categories )->didPass());
    }
	
	//	####################################################
	//	#### Tests for CategorisePayments SQL Injection ####
	//	####################################################
	
	public function testSQLInjectionCategorisePaymentsUserID() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$categories = array( 1=>1, 2=>1, 3=>1, 4=>1);

		$this->assertEquals($expected, $accessor->CategorisePayments($user->ID."; DROP TABLE User",$session->Token,$categories )->didPass());
    }
	
	public function testSQLInjectionCategorisePaymentsToken() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$categories = array( 1=>1, 2=>1, 3=>1, 4=>1);

		$this->assertEquals($expected, $accessor->CategorisePayments($user->ID,$session->Token."; DROP TABLE User",$categories )->didPass());
    }
	
	public function testSQLInjectionCategorisePaymentsCatItems() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$categories = array( 1=>1, 2=>1, 3=>1, 4=>1, "; DROP TABLE User");

		$this->assertEquals($expected, $accessor->CategorisePayments($user->ID,$session->Token,$categories )->didPass());
    }
	
	
	//	################################
	//	#### Tests for deleteBudget ####
	//	################################
	
	public function testDeleteBudgetAllCorrect() {
		
		$accessor = new BankAccessor();
		$expected = true;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');

		$this->assertEquals($expected, $accessor->deleteBudget($user->ID, $session->Token,1 )->didPass());
    }
	
	public function testDeleteBudgetWrongUserID() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$this->assertEquals($expected, $accessor->deleteBudget(9, $session->Token,1 )->didPass());
    }
	
	public function testDeleteBudgetWrongToken() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$this->assertEquals($expected, $accessor->deleteBudget($user->ID, "rubish",1 )->didPass());
    }
	
	public function testDeleteBudgetDoesntOwnGroup() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','allProductsPerson');
		$session =$this->objFromFixture('UserSession','allProductsPersonSession');
		$this->assertEquals($expected, $accessor->deleteBudget($user->ID, $session->Token,1 )->didPass());
    }
	
	public function testDeleteBudgetGroupDoesntExist() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$this->assertEquals($expected, $accessor->deleteBudget($user->ID, $session->Token,7 )->didPass());
    }
	
	public function testDeleteBudgetGroupGroupDeleted() {
		
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');

		$result = $accessor->deleteBudget($user->ID, $session->Token,1 );
		
		$group = BudgetGroup::get()->byID(1);

		
		$this->assertEquals($expected, $group );
	}
	
	public function testDeleteBudgetGroupCategoriesDeleted() {
		
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');

		$result = $accessor->deleteBudget($user->ID, $session->Token,1 );
		
		$category = Category::get()->byID(1);
		
		$this->assertEquals($expected, $category );
	}	
		
	
	
	//	##############################################
	//	#### Tests for DeleteBudget SQL Injection ####
	//	##############################################
	
	public function testSQLInjectionDeleteBudgetUserID() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');

		$this->assertEquals($expected, $accessor->deleteBudget($user->ID."; DROP TABLE User",$session->Token,1 )->didPass());
    }
	
	public function testSQLInjectionDeleteBudgetToken() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');

		$this->assertEquals($expected, $accessor->deleteBudget($user->ID,$session->Token."; DROP TABLE User",1 )->didPass());
    }
	
	public function testSQLInjectionDeleteBudgetGroupID() {
		
		$accessor = new BankAccessor();
		$expected = true;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');

		$this->assertEquals($expected, $accessor->deleteBudget($user->ID,$session->Token,"1; DROP TABLE User" )->didPass());
    }

	//	###############################
	//	#### Tests for CreateGroup ####
	//	###############################
	
	public function testCreateGroupAllCorrect() {
		
		$accessor = new BankAccessor();
		$expected = true;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$categories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		
		$this->assertEquals($expected, $accessor->createGroup($user->ID, $session->Token,"NewName",	$categories  )->didPass());
    }
	
	public function testCreategroupWrongUserID() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$categories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		
		$this->assertEquals($expected, $accessor->createGroup(99, $session->Token,"NewName",	$categories  )->didPass());
    }
	
	public function testCreateGroupWrongToken() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$categories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		
		$this->assertEquals($expected, $accessor->createGroup($user->ID, "Rubish","NewName",	$categories  )->didPass());
    }
	
	public function testCreateGroupNameNull() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','allProductsPerson');
		$session =$this->objFromFixture('UserSession','allProductsPersonSession');
		$categories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		
		$this->assertEquals($expected, $accessor->createGroup($user->ID, $session->Token,null,	$categories  )->didPass());
    }
	
	public function testCreateGroupNoCategories() {
		
		$accessor = new BankAccessor();
		$expected = true;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$categories = null;
		
		$this->assertEquals($expected, $accessor->createGroup($user->ID, $session->Token,"NewName",	$categories  )->didPass());
    }
	
	public function testCreateGroupCatsWrongFormat() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','allProductsPerson');
		$session =$this->objFromFixture('UserSession','allProductsPersonSession');
		$categories = array( array("Namess"=>"TestNameOne", "Budgety"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		
		$this->assertEquals($expected, $accessor->createGroup($user->ID, $session->Token,"NewName",	$categories  )->didPass());
    }

	public function testCreateGroupCategoriesAdded() {
		
		$accessor = new BankAccessor();
		$expected = 5;
		$user = $this->objFromFixture('User','allProductsPerson');
		$session =$this->objFromFixture('UserSession','allProductsPersonSession');
		$categories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50),array("Name"=>"TestNameTwo", "Budget"=>50),array("Name"=>"TestNameTwo", "Budget"=>50));
		
		$result = $accessor->createGroup($user->ID, $session->Token,"NewName",	$categories  );
		$groupID = $result->getCreatedGroup()->ID;
		
		$theCats = Category::get()->filter(array(
			"GroupID" =>$groupID
		));
		
		$this->assertEquals($expected,(int)sizeof($theCats));
		
    }
	
	//	#############################################
	//	#### Tests for CreateGroup SQL Injection ####
	//	#############################################
	
	public function testSQLInjectionCreateGroupUserID() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$categories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		
		$this->assertEquals($expected, $accessor->createGroup($user->ID."; DROP TABLE User", $session->Token,"NewName",	$categories  )->didPass());
    }
	
	public function testSQLInjectionCreateGroupToken() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$categories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		
		$this->assertEquals($expected, $accessor->createGroup($user->ID, $session->Token."; DROP TABLE User","NewName",	$categories  )->didPass());
    }
	
	public function testSQLInjectionCreateGroupGroupName() {
		
		$accessor = new BankAccessor();
		$expected = true;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$categories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		
		$this->assertEquals($expected, $accessor->createGroup($user->ID, $session->Token,"NewName; DROP TABLE User",	$categories  )->didPass());
    }
	
	public function testSQLInjectionCreateGroupCategories() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$categories = array( array("Name"=>"TestNameOne; DROP TABLE User", "Budget"=>"50; DROP TABLE User"), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		
		$this->assertEquals($expected, $accessor->createGroup($user->ID, $session->Token,"NewName",	$categories  )->didPass());
    }
	
	//	#############################
	//	#### Tests for EditGroup ####
	//	#############################
	
	public function testEditGroupAllCorrect() {
		
		$accessor = new BankAccessor();
		$expected = true;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$updatedCategories =  array( 3 => array("Name"=>"SomeStuff","Budget"=>10));
		$newCategories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		$deletedCats = array(1,2);
		
		$result = $accessor->editGroups($user->ID, $session->Token,1,"notNull",$updatedCategories,	$newCategories,$deletedCats  );
		$this->assertEquals($expected, $result->didPass());
    }
	
	public function testEditGroupWrongUserID() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$updatedCategories =  array( 3 => array("Name"=>"SomeStuff","Budget"=>10));
		$newCategories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		$deletedCats = array(1,2);
		
		$result = $accessor->editGroups(99, $session->Token,1,"notNull",$updatedCategories,	$newCategories,$deletedCats  );
		$this->assertEquals($expected, $result->didPass());
    }
	
	public function testEditGroupWrongToken() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$updatedCategories =  array( 3 => array("Name"=>"SomeStuff","Budget"=>10));
		$newCategories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		$deletedCats = array(1,2);
		
		$result = $accessor->editGroups($user->ID, "Rubbish",1,"notNull",$updatedCategories,	$newCategories,$deletedCats  );
		$this->assertEquals($expected, $result->didPass());
    }
	
	public function testEditGroupDontOwnGroup() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$updatedCategories =  array( 3 => array("Name"=>"SomeStuff","Budget"=>10));
		$newCategories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		$deletedCats = array(1,2);
		
		$result = $accessor->editGroups($user->ID, $session->Token,3,"notNull",$updatedCategories,	$newCategories,$deletedCats  );
		$this->assertEquals($expected, $result->didPass());
    }
	
	public function testEditGroupGroupDoesntExist() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$updatedCategories =  array( 3 => array("Name"=>"SomeStuff","Budget"=>10));
		$newCategories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		$deletedCats = array(1,2);
		
		$result = $accessor->editGroups($user->ID, $session->Token,99,"notNull",$updatedCategories,	$newCategories,$deletedCats  );
		$this->assertEquals($expected, $result->didPass());
    }
	
	public function testEditGroupGroupNameNull() {
		
		$accessor = new BankAccessor();
		$expected = true;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$updatedCategories =  array( 3 => array("Name"=>"SomeStuff","Budget"=>10));
		$newCategories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		$deletedCats = array(1,2);
		
		$result = $accessor->editGroups($user->ID, $session->Token,1,null,$updatedCategories,	$newCategories,$deletedCats  );
		$this->assertEquals($expected, $result->didPass());
    }
	
	public function testEditGroupGroupChangedName() {
		
		$accessor = new BankAccessor();
		$expected = 0;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$updatedCategories =  array( 3 => array("Name"=>"SomeStuff","Budget"=>10));
		$newCategories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		$deletedCats = array(1,2);
		
		$result = $accessor->editGroups($user->ID, $session->Token,1,"notNull",$updatedCategories,	$newCategories,$deletedCats  );
		$group = BudgetGroup::get()->byID(1);
		
		$this->assertEquals($expected, strcmp($group->Title,"notNull"));
    }
	
	public function testEditGroupEditCategoriesWrongFormat() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$updatedCategories =  array( 3 => array("Namef"=>"SomeStuff","Budgfet"=>10));
		$newCategories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		$deletedCats = array(1,2);
		
		$result = $accessor->editGroups($user->ID, $session->Token,1,"notNull",$updatedCategories,	$newCategories,$deletedCats  );
		$this->assertEquals($expected, $result->didPass());
    }
	
	public function testEditGroupEditCategoriesDoesntExist() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$updatedCategories =  array( 99 => array("Name"=>"SomeStuff","Budget"=>10));
		$newCategories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		$deletedCats = array(1,2);
		
		$result = $accessor->editGroups($user->ID, $session->Token,1,"notNull",$updatedCategories,	$newCategories,$deletedCats  );
		$this->assertEquals($expected, $result->didPass());
    }
	
	public function testEditGroupEditCategoriesDontOwn() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$updatedCategories =  array( 4 => array("Name"=>"SomeStuff","Budget"=>10));
		$newCategories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		$deletedCats = array(1,2);
		
		$result = $accessor->editGroups($user->ID, $session->Token,1,"notNull",$updatedCategories,	$newCategories,$deletedCats  );
		$this->assertEquals($expected, $result->didPass());
    }
	
	public function testEditGroupNewCategoriesWrongformat() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$updatedCategories =  array( 3 => array("Name"=>"SomeStuff","Budget"=>10));
		$newCategories = array( array("Namffe"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		$deletedCats = array(1,2);
		
		$result = $accessor->editGroups($user->ID, $session->Token,1,"notNull",$updatedCategories,	$newCategories,$deletedCats  );
		$this->assertEquals($expected, $result->didPass());
    }
	
	public function testEditGroupNewCategoriesCreated() {
		
		$accessor = new BankAccessor();
		$expected = 0;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$updatedCategories =  array( 3 => array("Name"=>"SomeStuff","Budget"=>10));
		$newCategories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		$deletedCats = array(1,2);
		
		$result = $accessor->editGroups($user->ID, $session->Token,1,"notNull",$updatedCategories,	$newCategories,$deletedCats  );
		$category = Category::get()->byID(5);
		
		$this->assertEquals($expected, strcmp($category->Title,"TestNameOne"));
    }
	
	public function testEditGroupDeletedCatsDontOwn() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$updatedCategories =  array( 3 => array("Name"=>"SomeStuff","Budget"=>10));
		$newCategories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		$deletedCats = array(4);
		
		$result = $accessor->editGroups($user->ID, $session->Token,1,"notNull",$updatedCategories,	$newCategories,$deletedCats  );
		
		$this->assertEquals($expected, $result->didPass());
    }
	
	public function testEditGroupDeletedCatsDoesntExist() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$updatedCategories =  array( 3 => array("Name"=>"SomeStuff","Budget"=>10));
		$newCategories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		$deletedCats = array(99);
		
		$result = $accessor->editGroups($user->ID, $session->Token,1,"notNull",$updatedCategories,	$newCategories,$deletedCats  );
		
		$this->assertEquals($expected, $result->didPass());
    }
	
	
	public function testEditGroupChangeCategoryName() {
		
		$accessor = new BankAccessor();
		$expected = 0;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$updatedCategories =  array( 1 => array( "Name" => "Martin" , "Budget" => 10 ), 3 => array("Name"=> "SomeStuff", "Budget"=> 10) );
		$newCategories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		$deletedCats = array();

		$result = $accessor->editGroups($user->ID, $session->Token,1,"notNull",$updatedCategories,	$newCategories, $deletedCats  );
		
		$theCats = Category::get()->byID(1);
		echo "|".$theCats->Title."|";
		
		$this->assertEquals($expected, strcmp($theCats->Title,"Martin") );
    }
	
	public function testEditGroupChangeCategoryBudget() {
		
		$accessor = new BankAccessor();
		$expected = 0;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$updatedCategories =  array( 1 => array( "Name" => "Martin" , "Budget" => 500 ) );
		$newCategories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		$deletedCats = array();

		$result = $accessor->editGroups($user->ID, $session->Token,1,"notNull",$updatedCategories,	$newCategories, $deletedCats  );
		
		$theCats = Category::get()->byID(1);
		echo "|".$theCats->Budgeted."|";
		
		$this->assertEquals($expected, ((int)$theCats->Budgeted - 500) );
    }
	
	public function testEditGroupCheckDeletedCats() {
		
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$updatedCategories =  array( 1 => array( "Name" => "Martin" , "Budget" => 500 ) );
		$newCategories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		$deletedCats = array(2,3);

		$result = $accessor->editGroups($user->ID, $session->Token,1,"notNull",$updatedCategories,	$newCategories, $deletedCats  );
		
		$theCats = Category::get()->byID(2);
		
		$this->assertEquals($expected, $theCats );
    }
	
	public function testEditGroupNoUpdates() {
		
		$accessor = new BankAccessor();
		$expected = true;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$updatedCategories =  array( 3 => array("Name"=>"SomeStuff","Budget"=>10));
		$newCategories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		$deletedCats = array(1,2);
		
		$result = $accessor->editGroups($user->ID, $session->Token,1,"notNull",null,	$newCategories,$deletedCats  );
		$this->assertEquals($expected, $result->didPass());
    }
	
	public function testEditGroupNoCreates() {
		
		$accessor = new BankAccessor();
		$expected = true;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$updatedCategories =  array( 3 => array("Name"=>"SomeStuff","Budget"=>10));
		$newCategories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		$deletedCats = array(1,2);
		
		$result = $accessor->editGroups($user->ID, $session->Token,1,"notNull",$updatedCategories,	null,$deletedCats  );
		$this->assertEquals($expected, $result->didPass());
    }
	
	public function testEditGroupNoDeletes() {
		
		$accessor = new BankAccessor();
		$expected = true;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$updatedCategories =  array( 3 => array("Name"=>"SomeStuff","Budget"=>10));
		$newCategories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		$deletedCats = array(1,2);
		
		$result = $accessor->editGroups($user->ID, $session->Token,1,"notNull",$updatedCategories,	$newCategories,null );
		$this->assertEquals($expected, $result->didPass());
    }
	
	//	############################################
	//	#### Tests for EditBudget SQL Injection ####
	//	############################################
	
	public function testSQLInjectionEditGroupUserID() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$updatedCategories =  array( 3 => array("Name"=>"SomeStuff","Budget"=>10));
		$newCategories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		$deletedCats = array(1,2);
		
		$result = $accessor->editGroups($user->ID."; DROP TABLE User", $session->Token,1,"notNull",$updatedCategories,	$newCategories, $deletedCats  );
		$this->assertEquals($expected, $result->didPass());
    }
	
	public function testSQLInjectionEditGroupToken() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$updatedCategories =  array( 3 => array("Name"=>"SomeStuff","Budget"=>10));
		$newCategories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		$deletedCats = array(1,2);
		
		$result = $accessor->editGroups($user->ID, $session->Token."; DROP TABLE User",1,"notNull",$updatedCategories,	$newCategories, $deletedCats  );
		$this->assertEquals($expected, $result->didPass());
    }
	
	public function testSQLInjectionEditGroupGroupID() {
		
		$accessor = new BankAccessor();
		$expected = true;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$updatedCategories =  array( 3 => array("Name"=>"SomeStuff","Budget"=>10));
		$newCategories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		$deletedCats = array(1,2);
		
		$result = $accessor->editGroups($user->ID, $session->Token,"1; DROP TABLE User","notNull",$updatedCategories,	$newCategories, $deletedCats  );
		$this->assertEquals($expected, $result->didPass());
    }
	
	public function testSQLInjectionEditGroupGroupName() {
		
		$accessor = new BankAccessor();
		$expected = true;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$updatedCategories =  array( 3 => array("Name"=>"SomeStuff","Budget"=>10));
		$newCategories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		$deletedCats = array(1,2);
		
		$result = $accessor->editGroups($user->ID, $session->Token,1,"notNull"."; DROP TABLE User",$updatedCategories,	$newCategories, $deletedCats  );
		$this->assertEquals($expected, $result->didPass());
    }
	
	public function testSQLInjectionEditGroupUpdateCats() {
		
		$accessor = new BankAccessor();
		$expected = true;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$updatedCategories =  array( 3 => array("Name"=>"SomeStuff; DROP TABLE User","Budget"=>10));
		$newCategories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		$deletedCats = array(1,2);
		
		$result = $accessor->editGroups($user->ID, $session->Token,1,"notNull",$updatedCategories,	$newCategories, $deletedCats  );
		$this->assertEquals($expected, $result->didPass());
    }
	
	public function testSQLInjectionEditGroupNewCats() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$updatedCategories =  array( 3 => array("Name"=>"SomeStuff","Budget"=>10));
		$newCategories = array( array("Name"=>"TestNameOne; DROP TABLE User", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		$deletedCats = array(1,2);
		
		$result = $accessor->editGroups($user->ID."; DROP TABLE User", $session->Token,1,"notNull",$updatedCategories,	$newCategories, $deletedCats  );
		$this->assertEquals($expected, $result->didPass());
    }
	
	public function testSQLInjectionEditGroupDeleteCats() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$updatedCategories =  array( 3 => array("Name"=>"SomeStuff","Budget"=>10));
		$newCategories = array( array("Name"=>"TestNameOne", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50), array("Name"=>"TestNameTwo", "Budget"=>50));
		$deletedCats = array(1,"2; DROP TABLE User");
		
		$result = $accessor->editGroups($user->ID."; DROP TABLE User", $session->Token,1,"notNull",$updatedCategories,	$newCategories, $deletedCats  );
		$this->assertEquals($expected, $result->didPass());
    }
	
	/*
	
		Advanced Tests
		
	*/
	
	//	###########################
	//	#### Tests for LoadATM ####
	//	###########################
	
	public function testLoadATMALLCorrect() {
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$this->assertEquals(3, sizeof($accessor->loadATMs($user->ID, $session->Token)));
    }
	
	public function testLoadATMWrongUserID() {
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$this->assertEquals(0, sizeof($accessor->loadATMs(99, $session->Token)));
    }
	
	public function testLoadATMWrongToken() {
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$this->assertEquals(0, sizeof($accessor->loadATMs($user->ID, "sgh")));
    }
	
	//	############################################
	//	#### Tests for LoadATM SQL Injection ####
	//	############################################
	
	public function testSQLInjectionLoadATMUserID() {
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$this->assertEquals(0, sizeof($accessor->loadATMs($user->ID."; DROP TABLE User", $session->Token)));
    }
	
	public function testSQLInjectionLoadATMToken() {
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		
		$this->assertEquals(0, sizeof($accessor->loadATMs($user->ID, $session->Token."; DROP TABLE User")));
    }
	
	//	###############################
	//	#### Tests for LoadHeatMap ####
	//	###############################
	
	public function testLoadHeatMapALLCorrect() {
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$result = $accessor->loadHeatMap($user->ID, $session->Token, array(1), null, null);

		$this->assertEquals(3, sizeof($result));
    }
	
	public function testLoadHeatMapWrongUserID() {
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$result = $accessor->loadHeatMap(99, $session->Token, array(1), null, null);

		$this->assertEquals(null, $result);
    }
	
	public function testLoadHeatMapWrongToken() {
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$result = $accessor->loadHeatMap($user->ID, " dfg", array(1), null, null);

		$this->assertEquals(null, $result);
    }
	
	public function testLoadHeatMapNoAccounts() {
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','heatMapPerson');
		$session =$this->objFromFixture('UserSession','heatMapPersonSession');
		$result = $accessor->loadHeatMap($user->ID, $session->Token, null, null, null);

		$this->assertEquals(3, sizeof($result));
    }
	
	public function testLoadHeatMapAccountNotOwned() {
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$result = $accessor->loadHeatMap($user->ID, $session->Token, array(9),null, null);

		$this->assertEquals(null, $result);
    }
	
	public function testLoadHeatMapAccountNotExist() {
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$result = $accessor->loadHeatMap($user->ID, $session->Token, array(99),null, null);

		$this->assertEquals(null, $result);
    }
	
	public function testLoadHeatMapAccountStartNull() {
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$result = $accessor->loadHeatMap($user->ID, $session->Token, array(1), null, null);

		$this->assertEquals(3, sizeof($result));
    }
	
	public function testLoadHeatMapAccountEndNull() {
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$result = $accessor->loadHeatMap($user->ID, $session->Token, array(1), null, null);

		$this->assertEquals(3, sizeof($result));
    }

	public function testLoadHeatMapAccountStartNotNull() {
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','heatMapPerson');
		$session =$this->objFromFixture('UserSession','heatMapPersonSession');
		$result = $accessor->loadHeatMap($user->ID, $session->Token, array(9), '2015-01-0 00:00:00', null);
		
		$this->assertEquals(2, sizeof($result));
    }
	
	public function testLoadHeatMapAccountEndNotNull() {
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','heatMapPerson');
		$session =$this->objFromFixture('UserSession','heatMapPersonSession');
		$result = $accessor->loadHeatMap($user->ID, $session->Token, array(9),  null, '2015-01-0 00:00:00');

		$this->assertEquals(1, sizeof($result));
    }
	
	public function testLoadHeatMapAccountMultipleAccountsStartEndNull() {
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','heatMapPerson');
		$session =$this->objFromFixture('UserSession','heatMapPersonSession');
		$result = $accessor->loadHeatMap($user->ID, $session->Token, array(9,10,11),  null, null);

		$this->assertEquals(1545, $result[0]->getAmount());
    }
	
	public function testLoadHeatMapAccountMultipleAccountsStartEndNotNull() {
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','heatMapPerson');
		$session =$this->objFromFixture('UserSession','heatMapPersonSession');
		$result = $accessor->loadHeatMap($user->ID, $session->Token, array(9,10,11),  '2015-01-0 00:00:00', '2015-03-0 00:00:00');
		
		$this->assertEquals(60, $result[0]->getAmount());
    }
	
	//	#############################################
	//	#### Tests for LoadHeatMap SQL Injection ####
	//	#############################################
	
	public function testSQLInjectionLoadHeatMapUserID() {

		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$result = $accessor->loadHeatMap($user->ID."; DROP TABLE User", $session->Token, array(1),null, null);

		$this->assertEquals(null, $result);
    }
	
	public function testSQLInjectionLoadHeatMapToken() {
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$result = $accessor->loadHeatMap($user->ID, $session->Token."; DROP TABLE User", array(1),null, null);

		$this->assertEquals(null, $result);
    }
	
	public function testSQLInjectionLoadHeatMapAccounts() {
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$result = $accessor->loadHeatMap($user->ID, $session->Token, array("1; DROP TABLE User"),null, null);

		$this->assertEquals(3, sizeof($result));
    }
	
	public function testSQLInjectionLoadHeatMapStartDate() {
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$result = $accessor->loadHeatMap($user->ID, $session->Token, array(1),"; DROP TABLE User", null);

		$this->assertEquals(3, sizeof($result));
    }
	
	public function testSQLInjectionLoadHeatMapEndDate() {
	
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$session =$this->objFromFixture('UserSession','myPersonSessionOne');
		$result = $accessor->loadHeatMap($user->ID, $session->Token, array(1),null, "; DROP TABLE User");

		$this->assertEquals(null, $result);
    }
}