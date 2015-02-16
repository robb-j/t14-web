<?php
	
class IndexController extends Controller {
	
	private static $allowed_actions = array('index');
	
	
	public function index() {
		
		return $this->renderWith(array('Page'));
	}
}