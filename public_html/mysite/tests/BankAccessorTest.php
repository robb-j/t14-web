<?php

/**
 * This tests NAME_OF_THING
 * Martin S A - 27/02/2015
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
		if(sizeof($accounts)===2 && $accounts[0]->UserID = 4 && $accounts[1]->UserID = 4){
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

		if(sizeof($products)===1 && $products[0]->ID = 3 ){
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
		
		$this->assertEquals(2,sizeof($transactions->getTransactions()));

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
		$expected = 0;
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
}