<?php

/* A Page that displays a tool page within it
 * Created by Rob A - March 2015
 */
class ToolController extends BankController {
	
	public $ToolName = "";
	
	// Set the tab title
	public $TabTitle = "tools";
	
	public function init() {
		
		parent::init();
		
		// Add custom css & the google maps js
		Requirements::css("mysite/css/tools/tools.css");
		Requirements::javascript("http://maps.googleapis.com/maps/api/js");
	}
	
	public function Content() {
		
		// Render with a template
		return $this->renderWith("ToolContent");
	}
}