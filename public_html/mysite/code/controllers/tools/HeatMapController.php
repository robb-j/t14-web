<?php

/* A Tool Page that displays the Heatmap
 * Created by Rob A - March 2015
 */
class HeatMapController extends ToolController {
	
	public $ToolName = "heatmap";
	
	public function init() {
		
		parent::init();
		
		// Add js to display the atms on the map
		Requirements::javascript("mysite/js/HeatMap.js");
	}
	
	public function ToolContent() {
	
		$this->AllHeatPoints = WebApi::create()->loadHeatMap($this->CurrentUser->ID, null, null, null);
		return $this->renderWith("HeatMapTool");
	}
}