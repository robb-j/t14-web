<?php
$val .= '<!-- template /Users/rob/Developer/Sites/thales-connected/public_html/framework/templates/forms/FileField.ss -->';
$val .= '<input type="hidden" name="MAX_FILE_SIZE" value="';

$val .= $scope->locally()->XML_val('MaxFileSize', null, true);
$val .= '" />
<input ';

$val .= $scope->locally()->XML_val('AttributesHTML', null, true);
$val .= ' />
';


$val .= '<!-- end template /Users/rob/Developer/Sites/thales-connected/public_html/framework/templates/forms/FileField.ss -->';