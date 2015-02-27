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
	
	
	
	
	public function testLoginCorrectUsername() {
		
		$accessor = new BankAccessor();
		$expected = "Martin";
	   
		$this->assertEquals($expected, $accessor->login('Martin','password')->getUsername());
    }
}