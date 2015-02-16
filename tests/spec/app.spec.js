describe("Application Object", function() {
	"use strict";
	var that = this;
	
	beforeEach(function(done) {
		require([
			'backbone','marionette',
			'app'
			], function(Backbone, Marionette, App) {

			that.view = App;
			that.region = new Backbone.Marionette.Region({el: '#sandbox'});
			
			done();
		});
	});
	afterEach(function() {
		that.region.reset();
		$('#sandbox').html('');
	});
	
	
	/* Default Spec Code */
	it('Is Not Null', function(done){
		expect(that.view).not.toBeNull();
		done();
	});
});
