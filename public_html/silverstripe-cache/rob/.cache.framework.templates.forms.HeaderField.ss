<?php
$val .= '<!-- template /Users/rob/Developer/Sites/thales-connected/public_html/framework/templates/forms/HeaderField.ss -->';
$val .= '<h';

$val .= $scope->locally()->XML_val('HeadingLevel', null, true);
$val .= ' ';

$val .= $scope->locally()->XML_val('AttributesHTML', null, true);
$val .= '>';

$val .= $scope->locally()->XML_val('Title', null, true);
$val .= '</h';

$val .= $scope->locally()->XML_val('HeadingLevel', null, true);
$val .= '>';


$val .= '<!-- end template /Users/rob/Developer/Sites/thales-connected/public_html/framework/templates/forms/HeaderField.ss -->';