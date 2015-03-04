<?php

class MobileApiControllerTest extends FunctionalTest {

	public function testLoginCorrectUsernameCorrectPassword() {
		$username = "testUser";
		$password = "MPs";
		$indexes = array(0,2,5);
		$postArray = array(
			'username' => $username,
			'password' => $password,
			'indexes' => $indexes);
	
		$request = new SS_HTTPRequest("post",'/bankingapi/login', array(),$postArray,null);
	
		//$page = $this->post($request);
		$page = $this->post('bankapi/login',$postArray);
	
		echo "|".$page->getBody()."|";
		
	
			
		//$crawler =	$client->request('POST', '/bankingapi/login', $postArray);
        
		$expected = "testUser";
		$this->assertEquals($expected, $page->getBody()->getUser()->Username );
		
		
		
		
		
		
		
	}
}

?>