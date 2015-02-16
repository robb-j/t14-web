<?php
$val .= '<!doctype html>
<!-- template /Users/rob/Developer/Sites/thales-connected/public_html/mysite/templates/Page.ss -->
<!--[if lt IE 9]>
<html class="no-js lt-ie9" lang="';

$val .= $scope->locally()->XML_val('ContentLocale', null, true);
$val .= '"> <![endif]-->
<!--[if gt IE 8]>
<html class="no-js ie9" lang="';

$val .= $scope->locally()->XML_val('ContentLocale', null, true);
$val .= '"> <![endif]-->
<!--[if !IE]><!-->
<html class="no-js no-ie" lang="';

$val .= $scope->locally()->XML_val('ContentLocale', null, true);
$val .= '"> <!--<![endif]-->
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>';

$val .= $scope->locally()->XML_val('Title', null, true);
$val .= ' &raquo; ';

$val .= $scope->locally()->obj('SiteConfig', null, true)->XML_val('Title', null, true);
$val .= ' ';

if ($scope->locally()->obj('SiteConfig', null, true)->hasValue('Tagline', null, true)) { 
$val .= ' | ';

$val .= $scope->locally()->obj('SiteConfig', null, true)->XML_val('Tagline', null, true);

}
$val .= '</title>
	';

$val .= SSViewer::get_base_tag($val);
$val .= '
	<meta name="viewport" content="width=device-width"/>
	';

$val .= $scope->locally()->XML_val('MetaTags', array('false'), true);
$val .= '
	
	
	';


$val .= '
	';


$val .= '
	<link rel="shortcut icon" href="';

$val .= $scope->locally()->XML_val('BaseURL', null, true);
$val .= 'favicon.ico"/>
	<link rel="apple-touch-icon-precomposed" href="';

$val .= $scope->locally()->XML_val('BaseURL', null, true);
$val .= 'favicon-152.png">
	<meta name="msapplication-TileImage" content="';

$val .= $scope->locally()->XML_val('BaseURL', null, true);
$val .= 'favicon-144.png">
	<meta name="msapplication-TileColor" content="#132136">
	
	<!-- CSS -->
	<link rel="stylesheet" href="';

$val .= $scope->locally()->XML_val('BaseURL', null, true);
$val .= $scope->locally()->XML_val('ThemeDir', null, true);
$val .= '/css/screen.css" media="screen, projection, print" type="text/css"/>
	<link rel="stylesheet" href="';

$val .= $scope->locally()->XML_val('BaseURL', null, true);
$val .= $scope->locally()->XML_val('ThemeDir', null, true);
$val .= '/css/print.css" media="print" type="text/css"/>
	
	<!-- JS -->
	<script data-main="';

$val .= $scope->locally()->XML_val('BaseURL', null, true);
$val .= $scope->locally()->XML_val('ThemeDir', null, true);
$val .= '/js/main.js" src="';

$val .= $scope->locally()->XML_val('BaseURL', null, true);
$val .= $scope->locally()->XML_val('ThemeDir', null, true);
$val .= '/js/libs/require.js"></script>
	
</head>
<body>
	<input id="production-mode" type="hidden" value="';

$val .= $scope->locally()->obj('SiteConfig', null, true)->XML_val('ProductionMode', null, true);
$val .= '"/>	
	<div class="page-container">
		
		';

if ($scope->locally()->hasValue('Form', null, true)) { 
$val .= '
			<div class="container">
				<div class=" offset-md-4 col-md-8">
				';

$val .= $scope->locally()->XML_val('Content', null, true);
$val .= '
				';

$val .= $scope->locally()->XML_val('Form', null, true);
$val .= '
				</div>
			</div>
		';


}else { 
$val .= '
			
			<div id="app-container"></div>
			
		';


}
$val .= '
		
	</div>
</body>
</html>
';


$val .= '<!-- end template /Users/rob/Developer/Sites/thales-connected/public_html/mysite/templates/Page.ss -->';