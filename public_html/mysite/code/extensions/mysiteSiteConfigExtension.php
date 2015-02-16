<?php

/**
 * Extension to modify SiteConfig
 * @property SiteConfig owner
 */
class mysiteSiteConfigExtension extends DataExtension {
	private static $db = array(
		"ProductionMode" => "Boolean",
	);

	public function updateCMSFields(FieldList $fields) {
		
		$fields->addFieldToTab("Root.Main", 
            new CheckboxField("ProductionMode", "Production Mode")
        );
		return $fields;
	}
}
