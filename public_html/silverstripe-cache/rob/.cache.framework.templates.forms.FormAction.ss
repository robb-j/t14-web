<?php
$val .= '<!-- template /Users/rob/Developer/Sites/thales-connected/public_html/framework/templates/forms/FormAction.ss -->';
if ($scope->locally()->hasValue('UseButtonTag', null, true)) { 
$val .= '
	<button ';

$val .= $scope->locally()->XML_val('AttributesHTML', null, true);
$val .= '>
		';

if ($scope->locally()->hasValue('ButtonContent', null, true)) { 
$val .= $scope->locally()->XML_val('ButtonContent', null, true);

}else { 
$val .= $scope->locally()->XML_val('Title', null, true);

}
$val .= '
	</button>
';


}else { 
$val .= '
	<input ';

$val .= $scope->locally()->XML_val('AttributesHTML', null, true);
$val .= ' />
';


}
$val .= '
';


$val .= '<!-- end template /Users/rob/Developer/Sites/thales-connected/public_html/framework/templates/forms/FormAction.ss -->';