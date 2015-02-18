<?php

class ContentAdmin extends ModelAdmin {

	private static $managed_models = array(
		"User", "Product"
	);
	
	private static $url_segment = "edit";

	private static $menu_title = "Content";
}

?>
