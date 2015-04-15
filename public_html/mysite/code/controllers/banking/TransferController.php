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
	
	public function init() {
		
		parent::init();
		
		
		// Add some custom css
		Requirements::css("mysite/css/banking/transfer.css");
	}
	
	public function Content() {
		
		// Pass the account to the template
		$this->FromAccount = Account::get()->byId($this->request->param("ID"));
		
		
		// Make sure we have an account and it belongs to the signed in user
		if ($this->FromAccount === null || $this->FromAccount->UserID != $this->CurrentUser->ID) {
			
			return "<div class='main-section'> <h3> Cannot transfer from this account </h3> </div>";
		}
		else {
		
			// Render the Account template
			return $this->renderWith("TransferContent");
		}
	}
	
	
	/*
	 *	Creates a Form to perform the transfer
	*/
	public function BankTransferForm() {
		
		
		if ($this->FromAccount !== null) {
			
			// Add a select for each account thet can transfer to
			$possibleAccounts = $this->CurrentUser->Accounts()->where("ID <> " . $this->FromAccount->ID);
			
			$values = array();
			foreach($possibleAccounts as $row) {
				$values[$row->ID] = $row->AccountType;
			}
			
			
			// Create the fields
			$fields = new FieldList(
				HiddenField::create("AccountFrom", "The Sending Account", $this->FromAccount->ID),
				HiddenField::create("UserID", "The Sending Account", $this->CurrentUser->ID),
				TextField::create("Amount", "How much to send", 0.0),
				DropDownField::create("AccountTo", "The Destination Account", $values)
			);
		}
		
		else {
			
			$fields = new FieldList();
		}
		
		// Create the Action for the submission
		$actions = new FieldList(
			FormAction::create("cancelTransferForm")->setTitle("Cancel"),
            FormAction::create("submitTransferForm")->setTitle("Transfer")
        );
		
		
		// Tell the form whats required
		$required = new RequiredFields();
		
		
		// Create the form & set its template
		$form = new Form($this, "BankTransferForm", $fields, $actions, $required);
		$form->setTemplate("TransferForm");
		
		
		// Return a new form, SS renders it
		return $form;
	}
	
	
	public function NavigateBack() {
		
		return $this->redirect("banking/account/" . $FromAccount->ID);
	}
	
	
	public function submitTransferForm($data, Form $form) {
		
		// Get the data from the form
		$fromID = $data["AccountFrom"];
		$toID = $data["AccountTo"];
		$userID = $data["UserID"];
		$amount = $data["Amount"];
		
		
		// Perform the transfer through the WebApi
		$output = WebApi::create()->makeTransfer($userID, $fromID, $toID, $amount);
		
		
		if ($output->didPass()) {
			
			return $this->redirect("banking/account/" . $fromID);
		}
		else {
			
			$form->addErrorMessage('Transfer Failed', "Transfer Failed", "");
			return $this->redirectBack();
		}
	}
	
	public function cancelTransferForm($data, Form $form) {
		
		$fromID = $data["AccountFrom"];
		
		return $this->redirect("banking/account/" . $fromID);
	}
	
	
}