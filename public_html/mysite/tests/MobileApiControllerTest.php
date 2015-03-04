<?php

class MobileApiControllerTest extends FunctionalTest {

	public function testLoginCorrectUsernameCorrectPassword() {
		$username = "testUser";
		$password = "MPs";
		$indexes = array(0,2,5);
		$postArray = array(
			'username' => $username,
			'password' => $password,
			'indexes0' => $indexes[0],
			'indexes1' => $indexes[1],
			'indexes2' => $indexes[2]);
	
		$request = new SS_HTTPRequest("post",'http://localhost/t14-web/public_html/bankingapi/login', array(),$postArray,null);
	
		//$page = $this->post($request);
		$page = $this->post('/bankapi/login',$postArray);
		
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
		
		
	
		echo "|".$page->getBody()."|";
		//echo "|".$result->getBody()."|";
	
			
		//$crawler =	$client->request('POST', '/bankingapi/login', $postArray);
        
		$expected = "testUser";
		$this->assertEquals($expected, $page->getBody()->getUser()->Username );
		
		
		
		
		
		
		
	}
}

?>