<?php
$val .= '<!-- template /Users/rob/Developer/Sites/thales-connected/public_html/framework/templates/Includes/GridFieldToolbarHeader.ss -->';
$val .= '<tr class="title">
	<th colspan="';

$val .= $scope->locally()->XML_val('ColumnCount', null, true);
$val .= '">
		';

if ($scope->locally()->hasValue('Title', null, true)) { 
$val .= '<h2>';

$val .= $scope->locally()->XML_val('Title', null, true);
$val .= '</h2>';


}
$val .= '
		<div class="right">$DefineFragment(toolbar-header-right)</div>
		<div class="left">$DefineFragment(toolbar-header-left)</div>
	</th>
</tr>
';


$val .= '<!-- end template /Users/rob/Developer/Sites/thales-connected/public_html/framework/templates/Includes/GridFieldToolbarHeader.ss -->';