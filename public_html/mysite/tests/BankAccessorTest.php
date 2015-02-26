<?php

class BankAccessorTest extends SapphireTest {

    public function testLoginCorrectUsername() {
      //  $this->assertEquals('Martin', BankAccessor::Login('Martin','password')->Username());
	   $accessor = new \code\backend\bank-accessor\BankAccessor();
	   $expected = "Martin";
	   
	    $this->assertEquals($expected, $accessor->Login('Martin','password')->Username());
    }
}
?>