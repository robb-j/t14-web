<?php
$val .= '<!-- template /Users/rob/Developer/Sites/thales-connected/public_html/framework/admin/templates/Includes/BackLink_Button.ss -->';
if ($scope->locally()->hasValue('Backlink', null, true)) { 
$val .= '
	<div class="cms_backlink">
		<a class="backlink ss-ui-button cms-panel-link" data-icon="back" href="';

$val .= $scope->locally()->XML_val('Backlink', null, true);
$val .= '">
			';

$val .= _t('BackLink_Button_ss.Back','Back');
$val .= '
		</a>
	</div>
';


}
$val .= '	
';


$val .= '<!-- end template /Users/rob/Developer/Sites/thales-connected/public_html/framework/admin/templates/Includes/BackLink_Button.ss -->';