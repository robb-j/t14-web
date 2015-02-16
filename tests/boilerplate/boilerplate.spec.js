describe("SPEC DESCRIPTIONS", function() {
	"use strict";
	var that = this;
	
	beforeEach(function(done) {
		require([
			'backbone','marionette',
			'FILE TO INCLUDE'
			], function(Backbone, Marionette, OBJECT) {

			that.object = OBJECT;
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
		expect(that.object).not.toBeNull();
		done();
	});
});
