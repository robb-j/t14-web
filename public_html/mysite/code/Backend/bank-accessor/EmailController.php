<?php

/* A Tool Page that displays the Heatmap
 * Created by Rob A - March 2015
 */
class EmailController {
	
	public $ToolName = "EmailController";

	
	public function ToolContent() {
	
		BankAccessor::create()->monthlyAccountUpdate();
	}
}
?>