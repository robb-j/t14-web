// Filename: specRunner.js

/*
	Info on setup here:
	http://stackoverflow.com/questions/19240302/does-jasmine-2-0-really-not-work-with-require-js
*/

require(['../public_html/mysite/js/global-config'], function(){
	
	"use strict";
	
	require.config({
		baseUrl: "../public_html/mysite/js/",
		
		paths: {
			'jasmine-core': '../../../tests/lib/jasmine-2.1.3/jasmine',
			'jasmine-html': '../../../tests/lib/jasmine-2.1.3/jasmine-html',
			'jasmine-boot': '../../../tests/lib/jasmine-2.1.3/boot',
			spec: '../../../tests/spec'
		},
		shim: {
			'jasmine-core': {
				exports: 'window.jasmineRequire'
			},
			'jasmine-html': {
				deps: ['jasmine-core', 'backbone', 'jquery'],
				exports: 'window.jasmineRequire'
			},
			'jasmine-boot': {
				deps: ['jasmine-core','jasmine-html'],
				exports: 'window.jasmineRequire'
			}
		}
	});
	
	
	// Load Jasmine - This will still create all of the normal Jasmine browser globals unless `boot.js` is re-written to use the
	// AMD or UMD specs. `boot.js` will do a bunch of configuration and attach it's initializers to `window.onload()`. Because
	// we are using RequireJS `window.onload()` has already been triggered so we have to manually call it again. This will
	// initialize the HTML Reporter and execute the environment.
	require([
		'jquery',
		'jasmine-boot',
		], function($){
		
		
		var specs = [
			'spec/app.spec',
			'spec/models/web-enquiry.spec'
		];
		
		$(function(){
			require(specs, function(){
				window.onload();
			});
		});
	
	});

});