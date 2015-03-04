<?php

class MobileApiController extends Controller {

	private static $allowed_actions = array(
        'login'
    );
    
    public function index(SS_HTTPRequest $request) {
	    
	    return "Bank Api Index";
    }

	public function login(SS_HTTPRequest $request){
	
	  /*$paramElement = $request->allParams();
	  echo"all= |".sizeof($paramElement)."|";*/
	  
		$indexes = new ArrayList();
		$username = $request->postVar('username');
		$password = $request->postVar('password');
		$indexes->push ( $request->postVar('indexes0'));
		$indexes->push ( $request->postVar('indexes1')); 
		$indexes->push ($request->postVar('indexes2')); 
		

		
			
			
		
		/*echo" user= |".$username."|";
		echo" pass= |".$password."|";
		echo" indexes= |".sizeof($indexes)."|";*/
		
		
		$loginOutput = BankAccessor::create()->loginFromMobile($username,$password,$indexes);
		
		//echo " username|".$loginOutput->getUser()->Username."|";
		//$response = new SS_HTTPResponse();
		//$this->response->setBody(json_encode( $loginOutput));
		//$this->response->addHeader("Content-type", "application/json");
		
		//return $loginOutput->getUser()->Username;
		
		 $response = $this->serializer->serialize( $loginOutput );          
         return $this->answer($response);
		
		
		
		//$this->response->setBody("Hello World");
		
		//return $this->response;
		
	}


}
?>