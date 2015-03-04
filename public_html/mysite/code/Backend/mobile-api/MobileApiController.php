<?php

class MobileApiController extends Controller {

	private static $allowed_actions = array(
        'login'
    );
    
    public function index(SS_HTTPRequest $request) {
	    
	    return "Bank Api Index";
    }

	public function login(){
	
		/*$username = $request->param('username');
		$password = $request->param('passwordBits');
		$indexs = $request->param('indexes');
	
		$accessor = new BankAccessor();
		$loginOutput = $accessor->login($username,$password,$indexs);
		
		$this->response->setBody(json_encode( $loginOutput));
		$this->response->addHeader("Content-type", "application/json");
		return $this->response.*/
		
		
		$this->response->setBody("Hello World");
		
		return $this->response;
		
	}


}
?>