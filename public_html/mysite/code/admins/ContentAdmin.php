<?php

/* A ModelAdmin that adds Users & Products to the admin backend
 * Created by Rob A - jan 2015
 */
class ContentAdmin extends ModelAdmin {

	private static $managed_models = array(
		"User", "Product", "Reward", "ATM", "UserSession"
	);
	
	private static $url_segment = "edit";

	private static $menu_title = "Content";
}

?>
