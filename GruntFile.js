module.exports = function(grunt) {
	"use strict";
	
	/**
		
		gruntFile.js
		
		Grunt tasks to compile the requirejs modules into single minified file
		
	*/
	
	grunt.initConfig({
		requirejs: {
			compile: {
				options: {
				
					baseUrl: "./public_html/mysite/js/",   
				    name: "app",
				    out: "./public_html/mysite/app.min.js",
					mainConfigFile: 'public_html/mysite/js/global-config.js',
					findNestedDependencies: true,
					preserveLicenseComments: false,

				}
			}
		}
	});
	
	// Load plugins here
	grunt.loadNpmTasks('grunt-contrib');
	
	// Define your tasks here
	grunt.registerTask('default', ['requirejs']);
};