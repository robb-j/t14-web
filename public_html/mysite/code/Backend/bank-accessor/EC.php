<?php

/* A Tool Page that displays the Heatmap
 * Created by Martin S - April 2015
 */
class EC extends Controller {

	private static $allowed_actions = array(
		"MDTest"
	);
   
	public function MDTest() {
		
		$this->user = User::get()->byID(1);
		$this->accounts = Account::get()->filter(array("UserID" => 1));
		return $this->renderWith("MonthlyUpdate");
	}
}
?>