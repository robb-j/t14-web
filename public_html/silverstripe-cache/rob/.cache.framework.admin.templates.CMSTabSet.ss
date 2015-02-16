<?php
$val .= '<!-- template /Users/rob/Developer/Sites/thales-connected/public_html/framework/admin/templates/CMSTabSet.ss -->';

$val .= '
';


$val .= '
';


$val .= '
';


$val .= '
';


$val .= '

<div ';

$val .= $scope->locally()->XML_val('AttributesHTML', null, true);
$val .= '>
	';

$scope->locally()->obj('Tabs', null, true); $scope->pushScope(); while (($key = $scope->next()) !== false) {
$val .= '
		';

if ($scope->locally()->hasValue('Tabs', null, true)) { 
$val .= '
			';

$val .= $scope->locally()->XML_val('FieldHolder', null, true);
$val .= '
		';


}else { 
$val .= '
			<div ';

$val .= $scope->locally()->XML_val('AttributesHTML', null, true);
$val .= '>
				';

$scope->locally()->obj('Fields', null, true); $scope->pushScope(); while (($key = $scope->next()) !== false) {
$val .= '
					';

$val .= $scope->locally()->XML_val('FieldHolder', null, true);
$val .= '
				';


}; $scope->popScope(); 
$val .= '
			</div>
		';


}
$val .= '
	';


}; $scope->popScope(); 
$val .= '
</div>
';


$val .= '<!-- end template /Users/rob/Developer/Sites/thales-connected/public_html/framework/admin/templates/CMSTabSet.ss -->';