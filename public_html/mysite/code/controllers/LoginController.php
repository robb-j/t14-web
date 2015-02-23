<?php
	
class LoginController extends Controller {
	
	private static $allowed_actions = array(
		"BankLoginForm"
	);
	
	public function index() {
		
		return $this->renderWith("Login");
	}
	
	public function BankLoginForm() {
		
		
		// Create the fields for the form
		$fields = new FieldList(
			TextField::create("Username", "Username"),
			PasswordField::create("Password", "Password")
		);
		
		
		// Create the Action for the submission
		$actions = new FieldList(
            FormAction::create("submitBankLoginForm")->setTitle("Login")
        );
		
		
		// Tell the form whats required
		$required = new RequiredFields("Username", "Password");
		
		
		// Return a new form
		$form = new Form($this, "BankLoginForm", $fields, $actions, $required);
		
		return $form;
	}
	
	
	
	public function submitBankLoginForm($data, Form $form) {
		
		
		$user = $data["Username"];
		$pass = $data["Password"];
		
		$bankAccessor = new DummyAccessor();
		
		$output = $bankAccessor->login($user, $pass);
		
		
		if ($output->didPass() == false) {
			
			$form->addErrorMessage('Failed', "Failed To Authenticate", 'Unlucky Pal');
			return $this->redirectBack();
		}
		else {
			
			Cookie::set("BankingSession", $output->getToken(), 0);
		
			return $this->redirect("banking/");
		}
	}
}