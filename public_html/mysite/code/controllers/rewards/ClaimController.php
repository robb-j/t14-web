<?php

/* A Page that lets the user claim a reward
 * Created by Rob A - March 2015
 */
class ClaimController extends BankController {
	
	
	// Set the tab title
	public $TabTitle = "rewards";
	
	
	public function Content() {
		
		// Render with a template
		return $this->renderWith("ClaimContent");
	}
}