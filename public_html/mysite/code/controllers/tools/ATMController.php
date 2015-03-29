<?php

/* A Tool Page that displays the ATM Finder
 * Created by Rob A - March 2015
 */
class ATMController extends ToolController {
	
	public $ToolName = "atm";
	
	public function ToolContent() {
		
		return $this->renderWith("ATMTool");
	}
}