<?php
	
class IndexController extends Controller {
	
	private static $allowed_actions = array(
		"login"
	);
	
	public function index() {
		
		$session = $this->GetSessionToken();
		
		if ($session == null || strlen($session) == 0) {
			
			return $this->redirect("login");
		}
		else {
			
			return $this->renderWith("Page");
		}
	}
	
	public function login() {
		
		return $this->index();
	}
	
	public function GetSessionToken() {
		
		return Cookie::get("BankingSession");
	}
	
	public function Content() {
		
		return "<p> Hello World </p>";
	}
}