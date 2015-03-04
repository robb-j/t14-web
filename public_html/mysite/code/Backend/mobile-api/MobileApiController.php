<?php

class MobileApiController extends Controller {

	private static $allowed_actions = array(
        'login'
    );
    
    public function index(SS_HTTPRequest $request) {
	    
	    return "Bank Api Index";
    }

	public function login(SS_HTTPRequest $request){
	
		$username = $request->param('username');
		$password = $request->param('password');
		$indexs = $request->param('indexes');
	
		$accessor = new BankAccessor();
		$loginOutput = $accessor->loginFromMobile($username,$password,$indexs);
		
		//$response = new SS_HTTPResponse();
		$this->response->setBody(json_encode( $loginOutput));
		$this->response->addHeader("Content-type", "application/json");
		return $this->response;
		
		
		//$this->response->setBody("Hello World");
		
		//return $this->response;
		
	}


}
?>