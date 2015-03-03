<?php

class MobileApiController extends Controller {

	public function login(SS_HTTPRequest $request){
	
		$username = $request->param('username');
		$password = $request->param('passwordBits');
		$indexs = $request->param('indexes');
	
		$accessor = new BankAccessor();
		$loginOutput = $accessor->login($username,$password,$indexs);
		
		$this->response->setBody(json_encode( $loginOutput));
		$this->response->addHeader("Content-type", "application/json");
		return $this->response.

		
	}


}
?>