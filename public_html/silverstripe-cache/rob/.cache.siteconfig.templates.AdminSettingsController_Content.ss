<?php
$val .= '<!-- template /Users/rob/Developer/Sites/thales-connected/public_html/siteconfig/templates/AdminSettingsController_Content.ss -->';
$val .= '<div id="settings-controller-cms-content" class="cms-content center cms-tabset ';

$val .= $scope->locally()->XML_val('BaseCSSClasses', null, true);
$val .= '" data-layout-type="border" data-pjax-fragment="Content CurrentForm" data-ignore-tab-state="true">

	<div class="cms-content-header north">
		';

$scope->locally()->obj('EditForm', null, true); $scope->pushScope();
$val .= '
			<div class="cms-content-header-info">
				';

$scope->locally()->obj('Controller', null, true); $scope->pushScope();
$val .= '
					';

$val .= '<!-- include \'CMSBreadcrumbs\' -->';
$val .= SSViewer::execute_template('CMSBreadcrumbs', $scope->getItem(), array(), $scope);
$val .= '<!-- end include \'CMSBreadcrumbs\' -->';

$val .= '
				';


; $scope->popScope(); 
$val .= '
			</div>

			';

if ($scope->locally()->obj('Fields', null, true)->hasValue('hasTabset', null, true)) { 
$val .= '
				';

$scope->locally()->obj('Fields', null, true)->obj('fieldByName', array('Root'), true); $scope->pushScope();
$val .= '
				<div class="cms-content-header-tabs cms-tabset-nav-primary ss-ui-tabs-nav">
					<ul class="cms-tabset-nav-primary">
					';

$scope->locally()->obj('Tabs', null, true); $scope->pushScope(); while (($key = $scope->next()) !== false) {
$val .= '
						<li';

if ($scope->locally()->hasValue('extraClass', null, true)) { 
$val .= ' class="';

$val .= $scope->locally()->XML_val('extraClass', null, true);
$val .= '"';


}
$val .= '><a href="' . (Config::inst()->get('SSViewer', 'rewrite_hash_links') ? strip_tags( $_SERVER['REQUEST_URI'] ) : "") . 
				'#';

$val .= $scope->locally()->XML_val('id', null, true);
$val .= '">';

$val .= $scope->locally()->XML_val('Title', null, true);
$val .= '</a></li>
					';


}; $scope->popScope(); 
$val .= '
					</ul>
				</div>
				';


; $scope->popScope(); 
$val .= '
			';


}
$val .= '
		';


; $scope->popScope(); 
$val .= '
	</div>

	';

$val .= $scope->locally()->XML_val('EditForm', null, true);
$val .= '

</div>
';


$val .= '<!-- end template /Users/rob/Developer/Sites/thales-connected/public_html/siteconfig/templates/AdminSettingsController_Content.ss -->';