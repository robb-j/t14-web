<?php

global $project;
$project = 'mysite';

// use the _ss_environment.php file for configuration
require_once ('conf/ConfigureFromEnv.php');

// remove the auto generated SS_ prefix that gets added if database is auto detected
global $databaseConfig;
$databaseConfig['database'] = str_replace('SS_', '', $databaseConfig['database']);

// set default language
i18n::set_locale('en_GB');

// Force redirect to www
//Director::forceWWW();

// it is suggested to set SS_ERROR_LOG in _ss_environment.php to enable logging,
// alternatively you can use the line below for your custom logging settings
// SS_Log::add_writer(new SS_LogFileWriter('../silverstripe-errors.log'), SS_Log::ERR);
if (!Director::isLive()) {
	// set settings that should only be in dev and test
	// IMPORTANT: as of 3.1 you can *NOT* set display_errors inside _config.php
	// use the php ini, htaccess or _ss_environment.php to set display_errors
} else {
	// we are in live mode, send errors per email
	SS_Log::add_writer(new SS_LogEmailWriter('rob@veodesign.co.uk'), SS_Log::ERR);
}



// Remove HTML Editor Buttons
HtmlEditorConfig::get('cms')->setOptions(
	array(
		'theme' =>'advanced',
		'skin' => 'default',
        'theme_advanced_statusbar_location' => "bottom",
        'theme_advanced_toolbar_location' => "top",
        'theme_advanced_toolbar_align' => "left",
        'height' => '400',
        'apply_source_formatting' => false,
		)
);