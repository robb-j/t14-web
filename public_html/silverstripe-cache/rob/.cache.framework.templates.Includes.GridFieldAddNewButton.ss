<?php
$val .= '<!-- template /Users/rob/Developer/Sites/thales-connected/public_html/framework/templates/Includes/GridFieldAddNewButton.ss -->';
$val .= '<a href="';

$val .= $scope->locally()->XML_val('NewLink', null, true);
$val .= '" class="action action-detail ss-ui-action-constructive ss-ui-button ui-button ui-widget ui-state-default ui-corner-all new new-link" data-icon="add">
';

$val .= $scope->locally()->XML_val('ButtonName', null, true);
$val .= '
</a>';


$val .= '<!-- end template /Users/rob/Developer/Sites/thales-connected/public_html/framework/templates/Includes/GridFieldAddNewButton.ss -->';