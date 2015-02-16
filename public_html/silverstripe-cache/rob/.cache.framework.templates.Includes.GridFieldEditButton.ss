<?php
$val .= '<!-- template /Users/rob/Developer/Sites/thales-connected/public_html/framework/templates/Includes/GridFieldEditButton.ss -->';
$val .= '<a class="action action-detail edit-link" href="';

$val .= $scope->locally()->XML_val('Link', null, true);
$val .= '" title="';

$val .= _t('GridFieldEditButton_ss.EDIT','Edit');
$val .= '">';

$val .= _t('GridFieldEditButton_ss.EDIT','Edit');
$val .= '</a>
';


$val .= '<!-- end template /Users/rob/Developer/Sites/thales-connected/public_html/framework/templates/Includes/GridFieldEditButton.ss -->';