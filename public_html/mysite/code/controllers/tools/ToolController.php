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
		
		Requirements::css("mysite/css/tools/tools.css");
	}
	
	public function Content() {
		
		// Render with a template
		return $this->renderWith("ToolContent");
	}
}