<?php

/* A Tool Page that displays the ATM Finder
 * Created by Rob A - March 2015
 */
class ATMController extends ToolController {
	
	public $ToolName = "atm";
	
	private static $allowed_actions = array(
		"loadATMs"
	);
	
	public function ToolContent() {
		$api = new WebApi();
	
		$this->atmList = $api->loadATMs($this->CurrentUser->ID);
		
		return $this->renderWith("ATMTool");
	}
	
	public function loadATMs(){
	
		// Create an API to access the database
		$api = new WebApi();
	
		$arrayOfATMObjects = $api->loadATMs($this->CurrentUser->ID);
		
		foreach ($arrayOfATMObjects as $ATM){
		
			echo " Title=".$ATM->Title." Cost=".$ATM->Cost." Lng=".$ATM->Longitude." Lat=".$ATM->Latitude;
		
		}
		return 0;
	}
}