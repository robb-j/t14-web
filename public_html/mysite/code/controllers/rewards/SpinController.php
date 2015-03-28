<?php

/* A Page that lets the user spin for points
 * Created by Rob A - March 2015
 */
class SpinController extends BankController {
	
	
	// Set the tab title
	public $TabTitle = "rewards";
	
	
	public function Content() {
		
		// Render with a template
		return $this->renderWith("SpinContent");
	}
}