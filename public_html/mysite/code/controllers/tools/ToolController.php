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
		Requirements::javascript("https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=visualization");
	}
	
	public function Content() {
		
		// Render with a template
		return $this->renderWith("ToolContent");
	}
}