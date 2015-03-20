<?php

/**
 * This tests NAME_OF_THING
 * Martin S A - 27/02/2015
 */
class BankAccessorTest extends SapphireTest {
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
	
	/*public function testLoginCorrectUsernameCorrectPasswordCorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = "myPerson";
		$user = $this->objFromFixture('User','myPerson');
		
		$this->assertEquals($expected, $accessor->login($user->Username,"Password",null,false)->getUser()->Username);
    }
	
	public function testLoginIncorrectUsernameCorrectPasswordCorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myPerson');
		
		$this->assertEquals($expected, $accessor->login("WrongUser","Password",null,false)->getUser());
    }
	
	public function testLoginCorrectUsernameIncorrectPasswordCorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myPerson');
		
		$this->assertEquals($expected, $accessor->login($user->Username,"WrongPassword",null,false)->getUser());
    }
	
	public function testLoginCorrectUsernameCorrectPasswordIncorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myPerson');
		
		$this->assertEquals($expected, $accessor->login($user->Username,"Password",null,true)->getUser());
    }
	
	public function testLoginIncorrectUsernameIncorrectPasswordCorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myPerson');
		
		$this->assertEquals($expected, $accessor->login("WrongUser","WrongPassword",null,false)->getUser());
    }
	
	public function testLoginIncorrectUsernameCorrectPasswordIncorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myPerson');
		
		$this->assertEquals($expected, $accessor->login("wrongUser","Password",null,true)->getUser());
    }
	
	public function testLoginCorrectUsernameIncorrectPasswordIncorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myPerson');
		
		$this->assertEquals($expected, $accessor->login($user->Username,"WrongPassword",null,true)->getUser());
    }
	
	public function testLoginIncorrectUsernameIncorrectPasswordIncorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myPerson');
		
		$this->assertEquals($expected, $accessor->login("WrongUser","WrongPassword",null,true)->getUser());
    }*/

	//	##############################################
	//	#### Tests for Login using the mobile app ####
	//	##############################################
	
	/*public function testLoginCorrectUsernameCorrectPasswordCorrectIndexesCorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = "myPerson";
		$array = array(0,1,2);
		$user = $this->objFromFixture('User','myPerson');
		
		$this->assertEquals($expected, $accessor->login($user->Username,"Pas",$array,true)->getUser()->Username);
    }
	
	public function testLoginInCorrectUsernameCorrectPasswordCorrectIndexesCorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = null;
		$array = array(0,1,2);
		$user = $this->objFromFixture('User','myPerson');
		
		$this->assertEquals($expected, $accessor->login("WrongUser","Pas",$array,true)->getUser());
    }
	
	public function testLoginCorrectUsernameIncorrectPasswordCorrectIndexesCorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = null;
		$array = array(0,1,2);
		$user = $this->objFromFixture('User','myPerson');
		
		$this->assertEquals($expected, $accessor->login($user->Username,"Pat",$array,true)->getUser());
    }
	
	public function testLoginCorrectUsernameCorrectPasswordIncorrectIndexesCorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = null;
		$array = array(0,1,8);
		$user = $this->objFromFixture('User','myPerson');
		
		$this->assertEquals($expected, $accessor->login($user->Username,"Pas",$array,true)->getUser());
    }
	
	public function testLoginCorrectUsernameCorrectPasswordCorrectIndexesIncorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = null;
		$array = array(0,1,2);
		$user = $this->objFromFixture('User','myPerson');
		
		$this->assertEquals($expected, $accessor->login($user->Username,"Pas",$array,false)->getUser());
    }
	
	public function testLoginCorrectUsernameIncorrectPasswordSizeCorrectIndexesCorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = null;
		$array = array(0,1,2);
		$user = $this->objFromFixture('User','myPerson');
		
		$this->assertEquals($expected, $accessor->login($user->Username,"Pass",$array,true)->getUser());
    }
	
	public function testLoginCorrectUsernameCorrectPasswordIncorrectIndexesSizeCorrectMobileBool() {
	
		$accessor = new BankAccessor();
		$expected = null;
		$array = array(0,1,2,3);
		$user = $this->objFromFixture('User','myPerson');
		
		$this->assertEquals($expected, $accessor->login($user->Username,"Pas",$array,true)->getUser());
    }*/

	//	######################################
	//	#### Tests for LoginOutput object ####
	//	######################################
	
	/*public function testLoginOutputDidPassCorrectInformation() {
		
		$accessor = new BankAccessor();
		$expected = true;
		$user = $this->objFromFixture('User','myPerson');
	   
		$this->assertEquals($expected, $accessor->login($user->Username,"Password",null,false)->didPass());
    }
	
	public function testLoginOutputDidPassIncorrectInformation() {
		
		$accessor = new BankAccessor();
		$expected = false;
		$user = $this->objFromFixture('User','myPerson');
	   
		$this->assertEquals($expected, $accessor->login($user->Username,"NotPassword",null,false)->didPass());
    }
	
	public function testLoginOutputCorrectInformationGetCorrectUser() {
		
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$expected = $user;
		
		$this->assertEquals($expected, $accessor->login($user->Username,"Password",null,false)->getUser());
    }
	
	public function testLoginOutputInCorrectInformationGetCorrectUser() {
		
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$expected = null;
		
		$this->assertEquals($expected, $accessor->login($user->Username,"NotPassword",null,false)->getUser());
    }*/
	
	
	/* Requires tests for the accounts and the products*/
	
	
	
	
	/*public function testLoginOutputCorrectInformationGetAToken() {
		
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$expected = null;
		
		$this->assertNotEquals($expected, $accessor->login($user->Username,"Password",null,false)->getToken());
    }
	
	public function testLoginOutputInCorrectInformationGetNoToken() {
		
		$accessor = new BankAccessor();
		$user = $this->objFromFixture('User','myPerson');
		$expected = null;
		
		$this->assertEquals($expected, $accessor->login($user->Username,"NotPassword",null,false)->getToken());
    }*/
	
	//	#######################################
	//	#### Tests for Login SQL Injection ####
	//	#######################################
	
	/*public function testSQLInjectionLoginUsernameField() {
		
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myPerson');
	   
		$this->assertEquals($expected, $accessor->login("myPerson; DROP TABLE Users","Password",null,false)->getUser());
    }
	
	public function testSQLInjectionLoginPasswordField() {
		
		$accessor = new BankAccessor();
		$expected = null;
	    $user = $this->objFromFixture('User','myPerson');
	   
		$this->assertEquals($expected, $accessor->login($user->Username,"Password; DROP TABLE Users",null,false)->getUser());
    }
	
	public function testSQLInjectionLoginIndexesField() {
		
		$accessor = new BankAccessor();
		$expected = null;
		$user = $this->objFromFixture('User','myPerson');
	   
		$this->assertEquals($expected, $accessor->login($user->Username,"Password","DROP TABLE Users",false)->getUser());
    }*/
	
	
	public function testLoadTrans() {
		
		$accessor = new BankAccessor();
		$expected = 1;
		//$user = $this->objFromFixture('User','myPerson');
	   
		$this->assertEquals($expected, $accessor->loadTransactions(2,1,"Mar","2015","TickCjL40xBbSbgLq2fNblrZZ5uVT7EQ0bfb7dSlG6i8KRx2qXD3J8ln2vhj5OsE")->getAccount()->UserID);
    }
	
}