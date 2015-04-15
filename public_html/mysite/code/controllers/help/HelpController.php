<?php

/*
 * A Page that displays help which is eneted from the admin
 * Created by Rob A, April 2015
 */

class HelpController extends BankController {
	
	public $TabTitle = "help";
	
	
	public function Content() {
		
		return $this->renderWith("HelpContent");
	}
	
	public function HelpContent() {
		
		if (Help::get()->count() > 0) {
			
			return Help::get()->first()->Content;
		}
		return "Sorry no help is available";
	}
}