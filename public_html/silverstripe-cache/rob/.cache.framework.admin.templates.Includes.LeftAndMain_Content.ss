<?php
$val .= '<!-- template /Users/rob/Developer/Sites/thales-connected/public_html/framework/admin/templates/Includes/LeftAndMain_Content.ss -->';
$val .= '<div class="cms-content center ';

$val .= $scope->locally()->XML_val('BaseCSSClasses', null, true);
$val .= '" data-layout-type="border" data-pjax-fragment="Content">

	';

$val .= $scope->locally()->XML_val('Tools', null, true);
$val .= '

	';

$val .= $scope->locally()->XML_val('EditForm', null, true);
$val .= '
	
</div>';


$val .= '<!-- end template /Users/rob/Developer/Sites/thales-connected/public_html/framework/admin/templates/Includes/LeftAndMain_Content.ss -->';