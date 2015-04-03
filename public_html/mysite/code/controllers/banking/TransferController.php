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
		
		Requirements::css("mysite/css/banking/transfer.css");
	}
	
	public function Content() {
		
		$this->FromAccount = Account::get()->byId($this->request->param("ID"));
		
		if ($this->FromAccount === null) {
			
			return "Error: No Account from provided";
		}
		else {
		
			// Render the Account template
			return $this->renderWith("TransferContent");
		}
	}
	
	public function BankTransferForm() {
		
		
		if ($this->FromAccount !== null) {
			
			$possibleAccounts = $this->CurrentUser->Accounts()->where("ID <> " . $this->FromAccount->ID);
			
			$values = array();
			
			foreach($possibleAccounts as $row) {
				$values[$row->ID] = $row->AccountType;
			}
			
			
			
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
		
		$fromID = $data["AccountFrom"];
		$toID = $data["AccountTo"];
		$userID = $data["UserID"];
		$amount = $data["Amount"];
		
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