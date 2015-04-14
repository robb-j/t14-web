<?php

/*
 *	Created by Rob A, April 2015
 */

class SettingsController extends BankController {
	
	public $TabTitle = "settings";
	
	private static $allowed_actions = array(
		"SaveForm"
	);
	
	
	public function init() {
		
		parent::init();
	}
	
	public function Content() {
		
		return $this->renderWith("SettingsContent");
	}
}