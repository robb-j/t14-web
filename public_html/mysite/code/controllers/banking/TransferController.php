<?php

/* A Page that displays allows a User to make a transfer
 * Created by Rob A - mar 2015
 */
class TransferController extends BankController {
	
	
	// Set the tab title
	public $TabTitle = "banking";
	
	private static $allowed_actions = array(
		"BankTransferForm"
	);
	
	private static $url_handlers = array(
		'$ID/$Action' => "BankTransferForm"
	);
	
	
	public function Content() {
		
		$this->FromAccount = Account::get()->byId($this->request->param("ID"));
		
		
		// Render the Account template
		return $this->renderWith("TransferContent");
	}
	
	public function BankTransferForm() {
		
		$fields = new FieldList(
			TextField::create("Test", "Test")
		);
		
		// Create the Action for the submission
		$actions = new FieldList(
            FormAction::create("submitTransferForm")->setTitle("Transfer")
        );
		
		
		// Tell the form whats required
		$required = new RequiredFields();
		
		
		// Create the form & set its template
		$form = new Form($this, "BankTransferForm", $fields, $actions, $required);
		$form->setTemplate("TransferForm");
		
		
		// Return a new form, SS renders it nicely
		return $form;
		
	}
	
	
	public function submitTransferForm($data, Form $form) {
		
		//return $this->redirect("banking/account/" + $this->FromAccount->ID);
		//return $this->redirect("banking/");
		
		$form->addErrorMessage('Transfer Failed', "Transfer Failed", "");
		return $this->redirectBack();
	}
	
	
}