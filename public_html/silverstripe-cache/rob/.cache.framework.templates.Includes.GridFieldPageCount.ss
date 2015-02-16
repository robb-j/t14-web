<?php
$val .= '<!-- template /Users/rob/Developer/Sites/thales-connected/public_html/framework/templates/Includes/GridFieldPageCount.ss -->';
$val .= '<span class="pagination-records-number">
	';

$val .= _t('Pagination.View','View', 'Verb. Example: View 1 of 2');
$val .= '
	';

$val .= $scope->locally()->XML_val('FirstShownRecord', null, true);
$val .= '&ndash;';

$val .= $scope->locally()->XML_val('LastShownRecord', null, true);
$val .= '
	';

$val .= _t('TableListField_PageControls_ss.OF','of', 'Example: View 1 of 2');
$val .= ' 
	';

$val .= $scope->locally()->XML_val('NumRecords', null, true);
$val .= '
</span>';


$val .= '<!-- end template /Users/rob/Developer/Sites/thales-connected/public_html/framework/templates/Includes/GridFieldPageCount.ss -->';