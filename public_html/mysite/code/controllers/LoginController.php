<?php


/*
 * A Page that logs the user in, currently uses DummyAccessor
 * Created by Rob A - feb 2015
 */
class LoginController extends Controller {
	
	
	// This actions is for when the form is submitted
	private static $allowed_actions = array(
		"BankLoginForm"
	);
	
	
	// Called when this pages is loaded
	public function index() {
		
		if (WebApi::create()->getCurrentUser() != null) {
			
			// Redirect back if already logged in
			return $this->redirect("banking/");
		}
		else {
		
			// Otherwise, render with the login template
			return $this->renderWith("Login");
		}
	}
	
	
	// Creates the login form, called from the template
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
		
		
		// Return a new form, SS renders it nicely
		return new Form($this, "BankLoginForm", $fields, $actions, $required);
	}
	
	
	// Called when the form submits
	public function submitBankLoginForm($data, Form $form) {
		
		// Get the values entered
		$user = $data["Username"];
		$pass = $data["Password"];
		
		
		// Attempt the login
		$output = WebApi::create()->login($user, $pass);
		
		if ($output->didPass() == false) {
			
			
			// If the login failed, inform the user
			$form->addErrorMessage('Failed', "Failed To Authenticate", 'Unlucky Pal');
			return $this->redirectBack();
		}
		else {
			// If the login failed, redirect back to /banking
			return $this->redirect("banking/");
		}
	}
}