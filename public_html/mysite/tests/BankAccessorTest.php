<?php

/**
 * This tests NAME_OF_THING
 * Martin S A - 27/02/2015
 */
class BankAccessorTest extends SapphireTest {
	
	/**
	 * @Before
	 */
	public function setup() {
		
		// Something that happends before EACH test
	}
	
	/**
	 * @TearDown
	 */
	public function tearDown() {
		
		// Something that happens after EACH test
	}
	
	
	/*
	*
	* Tests for Login()
	*
	*/
	
	public function testLoginCorrectUsernameCorrectPassword() {
		
		$accessor = new BankAccessor();
		$expected = "Martin";
	   
		$this->assertEquals($expected, $accessor->login('Martin','password')->getUser()->Username);
    }
	
	public function testLoginIncorrectUsernameCorrectPassword() {
		
		$accessor = new BankAccessor();
		$expected = null;
	   
		$this->assertEquals($expected, $accessor->login('NotMartin','password')->getUser());
    }
	
	public function testLoginCorrectUsernameIncorrectPassword() {
		
		$accessor = new BankAccessor();
		$expected = null;
	   
		$this->assertEquals($expected, $accessor->login('Martin','Notpassword')->getUser());
    }
	
	public function testLoginIncorrectUsernameIncorrectPassword() {
		
		$accessor = new BankAccessor();
		$expected = null;
	   
		$this->assertEquals($expected, $accessor->login('NotMartin','Notpassword')->getUser());
    }
	
	//Need tests to check products and accounts and passed
	public function testLoginDidPassCorrectInformation() {
		
		$accessor = new BankAccessor();
		$expected = true;
	   
		$this->assertEquals($expected, $accessor->login('Martin','password')->didPass());
    }
	
	public function testLoginDidPassIncorrectInformation() {
		
		$accessor = new BankAccessor();
		$expected = false;
	   
		$this->assertEquals($expected, $accessor->login('NotMartin','password')->didPass());
    }
	
	/*
	*
	* Tests for LoginFromMobile()
	*
	*/
	
	public function testLoginFromMobileCorrectUsernameCorrectPassword() {
		
		$accessor = new BankAccessor();
		$expected = "Martin";
		$array = array(0,1,2);
	   
		$this->assertEquals($expected, $accessor->loginFromMobile('Martin','pas',$array)->getUser()->Username);
    }
	
	public function testLoginFromMobileIncorrectUsernameCorrectPassword() {
		
		$accessor = new BankAccessor();
		$expected = null;
	   
		$array = array(0,1,2);
	   
		$this->assertEquals($expected, $accessor->loginFromMobile('NotMartin','pas',$array)->getUser());
    }
	
	public function testLoginFromMobileCorrectUsernameIncorrectPassword() {
		
		$accessor = new BankAccessor();
		$expected = null;
	   
		$array = array(0,1,2);
	   
		$this->assertEquals($expected, $accessor->loginFromMobile('Martin','paw',$array)->getUser());
    }
	
	public function testLoginFromMobileIncorrectUsernameIncorrectPassword() {
		
		$accessor = new BankAccessor();
		$expected = null;
	   
		$array = array(0,1,2);
	   
		$this->assertEquals($expected, $accessor->loginFromMobile('NotMartin','paw',$array)->getUser());
    }
	
	public function testLoginFromMobileIncorrectPasswordLength() {
		
		$accessor = new BankAccessor();
		$expected = null;
	   
		$array = array(0,1,2);
	   
		$this->assertEquals($expected, $accessor->loginFromMobile('NotMartin','NotCorrectLength',$array)->getUser());
    }
	
	public function testLoginFromMobileIncorrectNumberOfPasswordDigits() {
		
		$accessor = new BankAccessor();
		$expected = null;
	   
		$array = array(0,1,2,3,4);
	   
		$this->assertEquals($expected, $accessor->loginFromMobile('NotMartin','paw',$array)->getUser());
    }
	
	//Need tests to check products and accounts and passed
	public function testLoginFromMobileDidPassCorrectInformation() {
		
		$accessor = new BankAccessor();
		$expected = true;
	   
		$array = array(0,1,2);
	   
		$this->assertEquals($expected, $accessor->loginFromMobile('Martin','pas',$array)->didPass());
    }
	
	public function testLoginFromMobileDidPassIncorrectInformation() {
		
		$accessor = new BankAccessor();
		$expected = false;
	   
	$array = array(0,1,2);
	   
		$this->assertEquals($expected, $accessor->loginFromMobile('NotMartin','paw',$array)->didPass());
    }
	
}