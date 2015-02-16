<?php
$val .= '<!-- template /Users/rob/Developer/Sites/thales-connected/public_html/framework/templates/forms/FormField_holder_small.ss -->';
$val .= '<div class="fieldholder-small">
	';

if ($scope->locally()->hasValue('Title', null, true)) { 
$val .= '<label class="fieldholder-small-label" ';

if ($scope->locally()->hasValue('ID', null, true)) { 
$val .= 'for="';

$val .= $scope->locally()->XML_val('ID', null, true);
$val .= '"';


}
$val .= '>';

$val .= $scope->locally()->XML_val('Title', null, true);
$val .= '</label>';


}
$val .= '
	';

$val .= $scope->locally()->XML_val('Field', null, true);
$val .= '
	';

if ($scope->locally()->hasValue('RightTitle', null, true)) { 
$val .= '<label class="right fieldholder-small-label" ';

if ($scope->locally()->hasValue('ID', null, true)) { 
$val .= 'for="';

$val .= $scope->locally()->XML_val('ID', null, true);
$val .= '"';


}
$val .= '>';

$val .= $scope->locally()->XML_val('RightTitle', null, true);
$val .= '</label>';


}
$val .= '
</div>';


$val .= '<!-- end template /Users/rob/Developer/Sites/thales-connected/public_html/framework/templates/forms/FormField_holder_small.ss -->';