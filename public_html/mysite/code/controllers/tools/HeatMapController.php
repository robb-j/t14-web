<?php

/* A Tool Page that displays the Heatmap
 * Created by Rob A - March 2015
 */
class HeatMapController extends ToolController {
	
	public $ToolName = "heatmap";
	
	private static $allowed_actions = array(
		"FilterForm"
	);
	
	public function init() {
		
		parent::init();
		
		// Add js to display the atms on the map
		Requirements::javascript("mysite/js/HeatMap.js");
	}
	
	public function ToolContent() {
		
		
		// Attempt to get filter information
		$accounts = Session::get("HeatmapFilterAccounts");
		$fromDate = Session::get("HeatmapFilterFrom");
		$toDate = Session::get("HeatmapFilterTo");
		$error = Session::get("HeatmapFilterError");
		
		
		$this->ErrorMessage = $error;
		$this->FromDate = $fromDate;
		$this->ToDate = $toDate;
		
		print_r($accounts);
		
		
		// Pass the heat points to the template
		$this->AllHeatPoints = WebApi::create()->loadHeatMap($this->CurrentUser->ID, $accounts, $fromDate, $toDate);		
		
		
		return $this->renderWith("HeatMapTool");
	}
	
	public function CurrentDate() {
		
		return date("d M y");
	}
	
	public function FilterForm($request) {
		
		// Defer the method to the parent
		return parent::HandleForm($request);
	}
	
	public function IsChecked($checkID) {
		
		$accounts = Session::get("HeatmapFilterAccounts");
		
		if ($accounts != null) {
			
			foreach ($accounts as $id) {
				
				if ($id == $checkID) {
					return "checked='checked'";
				}
			}
		}
		return "";
	}
	
	
	private function isValidDate($date) {
		
		$format = "d M Y";
		$d = DateTime::createFromFormat($format, $date);
	    return $d && $d->format($format) == $date;
	}
	
	
	
	public function filterHeatmap($data) {
		
		$accounts = null;
		$fromDate = "";
		$toDate = "";
		$error = "";
		$didError = false;
		
		// Check if any accouns were selected
		if (array_key_exists("Accounts", $data)) {
			$accounts = $data["Accounts"];
		}
		
		
		// Check if they entered a from date
		if (array_key_exists("FromDate", $data)  && $data["FromDate"] != null ) {
			
			
			if ($this->isValidDate($data["FromDate"])) {
				
				$fromDate = $data["FromDate"];
			}
			else {
				
				$didError = true;
				$error = '"' . $data["FromDate"] . '" is not a valid date';
			}
		}
		
		// Check if they entered a to date
		if (array_key_exists("ToDate", $data) && $data["ToDate"] != null ) {
			
			if ($this->isValidDate($data["ToDate"])) {
				
				$toDate = $data["ToDate"];
			}
			else {
				
				$didError = true;
				$error = '"' . $data["ToDate"] . '" is not a valid date';
			}
		}
		
		if ($didError == true) {
			
			Session::set("HeatmapFilterError", $error);
		}
		else {
			
			Session::clear("HeatmapFilterError");
			Session::clear("HeatmapFilterAccounts");
			Session::clear("HeatmapFilterFrom");
			Session::clear("HeatmapFilterTo");
			
			Session::save();
			
			Session::set("HeatmapFilterAccounts", $accounts);
			Session::set("HeatmapFilterFrom", $fromDate);
			Session::set("HeatmapFilterTo", $toDate);
		}
		
		return $this->redirect("tools/heatmap/");
	}
	
	public function clearFilter($data) {
		
		Session::clear("HeatmapFilterAccounts");
		Session::clear("HeatmapFilterFrom");
		Session::clear("HeatmapFilterTo");
		Session::clear("HeatmapFilterError");
		
		return $this->redirect("tools/heatmap/");
	}
}
?>