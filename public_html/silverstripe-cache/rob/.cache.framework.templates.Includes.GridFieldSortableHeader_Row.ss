<?php
$val .= '<!-- template /Users/rob/Developer/Sites/thales-connected/public_html/framework/templates/Includes/GridFieldSortableHeader_Row.ss -->';
$val .= '<tr class="sortable-header">
	';

$scope->locally()->obj('Fields', null, true); $scope->pushScope(); while (($key = $scope->next()) !== false) {
$val .= '
		<th class="main col-';

$val .= $scope->locally()->XML_val('getName', null, true);
$val .= '">';

$val .= $scope->locally()->XML_val('Field', null, true);
$val .= '</th>
	';


}; $scope->popScope(); 
$val .= '
</tr>
';


$val .= '<!-- end template /Users/rob/Developer/Sites/thales-connected/public_html/framework/templates/Includes/GridFieldSortableHeader_Row.ss -->';