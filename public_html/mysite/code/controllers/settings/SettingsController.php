<?php

/*
 *	A Page that alloweds the user to edit properties of their account
 *	Created by Rob A, April 2015
 */

class SettingsController extends BankController {
	
	
	public $TabTitle = "settings";
	
	
	private static $allowed_actions = array(
		"NotificationForm"
	);
	
	
	public function Content() {
		
		// Get the success message from previous form submissions
		$success = Session::get("NotificationFormMessage");
		
		if ($success) {
			
			// If there is a mesasge pass to the template and remove it
			$this->SuccessMessage = $success;
			Session::clear("NotificationFormMessage");
		}
		
		return $this->renderWith("SettingsContent");
	}
	
	public function NotificationForm($request) {
		
		// Defer the call to out parent
		return parent::HandleForm($request);
	}
	
	
	
	public function cancelForm($data) {
		
		// Just reload the page
		return $this->redirect("settings/");
	}
	
	public function submitForm($data) {
		
		$newProdsUpdate = false;
		$monthlyUpdate = false;
		
		
		// Get the current user
		$user = BankAccessor::create()->getCurrentUser();
		
		
		// See which boxes they checked
		if (array_key_exists("NewProductUpdate", $data)) {
			$newProdsUpdate = true;
		}
		
		if (array_key_exists("MonthlyDigest", $data)) {
			$monthlyUpdate = true;
		}
		
		
		// Set the notification preferences
		$user->NewProductUpdate = $newProdsUpdate;
		$user->MonthlyEmail = $monthlyUpdate;
		
		
		// Set the email if it was entered
		if (array_key_exists("Email", $data)) {
			$user->Email = Convert::raw2sql( $data["Email"] );
		}
		
		
		// Save the user
		$user->write();
		
		
		// Add a success message to the session, to be displayed when reloaded
		Session::set("NotificationFormMessage", "Notification Preferences Updated");
		
		
		// Reload the page
		return $this->redirect("settings/");
	}
}