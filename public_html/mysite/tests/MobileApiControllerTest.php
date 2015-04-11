<?php

class MobileApiControllerTest extends FunctionalTest {
	
	
	static $fixture_file = 'mysite/tests/MobileUsers.yml';
	
	private $token;
	private $userID;
	
	
	/**
	 * @Before
	 */
	public function setup() {
		
		// Something that happens before EACH test
		parent::setup();
		
		
		$output = BankAccessor::create()->login("robster31", "password", null, false);
		
		$this->token = $output->getToken();
		$this->userID = $output->getUser()->ID;
		
	}
	
	/**
	 * @TearDown
	 */
	public function tearDown() {
		
		// Something that happens after EACH test
		parent::tearDown();
		
		
		BankAccessor::create()->logout($this->userID, $this->token);
	}
	
	

	public function testLoginCorrectUsernameCorrectPassword() {
		/*$username = "testUser";
		$password = "MPs";
		$indexes = array(0,2,5);
		$postArray = array(
			'username' => $username,
			'password' => $password,
			'indexes0' => $indexes[0],
			'indexes1' => $indexes[1],
			'indexes2' => $indexes[2]
		);
	
		$request = new SS_HTTPRequest("post",'bankingapi/login', array(),$postArray,null);
	
		//$page = $this->post($request);
		$page = $this->post('/bankapi/login',$postArray);
		*/
		/*$url = 'http://localhost/t14-web/public_html/bankingapi/login';
		
		$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($postArray),
    ),
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);*/
		
		
		/*
		echo "|".$page->getBody()."|";
		//echo "|".$result->getBody()."|";
	
			
		//$crawler =	$client->request('POST', '/bankingapi/login', $postArray);
        
		$expected = "testUser";
		$this->assertEquals($expected, $page->getBody()->getUser()->Username );
		*/
		
		
		
		
		
		// This works (v)?
		
		/*
		$url = "bankapi/login";
		$postData = array(
			"username" => "robster31",
			"password" => "pas",
			"index1" => "0",
			"index2" => "1",
			"index3" => "2"
		);
		
		$page = $this->post($url, $postData);
		
		echo $page->getBody();
		
		*/

		
		
	}
	
	
	
	public function testUpdateBudgetPassing() {
		
		$url = "bankapi/updateBudget";
		$postData = array(
			"token" => $this->token,
			"userId" => $this->userID,
		);
		
		$page = $this->post($url, $postData);
		
		$output = Convert::json2array($page->getBody());
		
		
		// Check we got an output
		$this->assertNotNull($output);
		
		
		// Check it has groups
		$this->assertTrue(array_key_exists("groups", $output));
		
		
		// Check it has categories
		$this->assertTrue(array_key_exists("categories", $output));
		
		
		
		
	}
	
}

?>