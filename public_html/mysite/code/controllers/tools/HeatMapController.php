<?php

/* A Tool Page that displays the Heatmap
 * Created by Rob A - March 2015
 */
class HeatMapController extends ToolController {
	
	public $ToolName = "heatmap";
	
	public function ToolContent() {
		
		return $this->renderWith("HeatMapTool");
	}
}