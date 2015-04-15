<?php

/* 
 * A Tool Page that displays the ATM Finder
 * Created by Rob A - March 2015
 */
class ATMController extends ToolController {
	
	public $ToolName = "atm";
	
	public function init() {
		
		parent::init();
		
		// Add js to display the atms on the map
		Requirements::javascript("mysite/js/ATMFinder.js");
	}
	
	public function ToolContent() {
		
		// Pass the atms to the template
		$this->AllAtms = WebApi::create()->loadATMs($this->CurrentUser->ID);
		
		return $this->renderWith("ATMTool");
	}
}
?>