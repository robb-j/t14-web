<?php

/* A Page that displays a Product
 * Created by Rob A - Mar 2015
 */
class ProductDetailController extends BankController {
	
	
	// Set the tab title
	public $TabTitle = "banking";
	
	
	public function init() {
		
		parent::init();
		
		
		// Add some custom CSS
		Requirements::css('mysite/css/banking/product.css');
	}
	
	public function Content() {
		
		// Get the ID of the product to display from the url params
		$id = $this->request->param('ID');
		$this->Product = Product::get()->byId($id);
		
		
		// Render the cotent with the template ProductContent.ss
		return $this->renderWith("ProductContent");
	}
}