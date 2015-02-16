<?php
$val .= '<!-- template /Users/rob/Developer/Sites/thales-connected/public_html/framework/templates/Includes/GridFieldFilterHeader_Row.ss -->';
$val .= '<tr class="filter-header" style="display:none;">
	';

$scope->locally()->obj('Fields', null, true); $scope->pushScope(); while (($key = $scope->next()) !== false) {
$val .= '
	<th class="extra">';

$val .= $scope->locally()->XML_val('Field', null, true);
$val .= '</th>
	';


}; $scope->popScope(); 
$val .= '
</tr>
';


$val .= '<!-- end template /Users/rob/Developer/Sites/thales-connected/public_html/framework/templates/Includes/GridFieldFilterHeader_Row.ss -->';