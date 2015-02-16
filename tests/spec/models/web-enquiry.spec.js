describe("Web Enquiry Spec", function() {
	"use strict";
	var that = this;
	
	beforeEach(function(done) {
		require([
			'backbone','marionette',
			'models/web-enquiry'
			], function(Backbone, Marionette, WebEnquiry) {

			that.Backbone = Backbone;

			that.WebEnquiry = WebEnquiry.extend({
				urlRoot: "../public_html/api/WebEnquiry"
			});
			
			
			//that.WebEnquiry.urlRoot = "../public_html/"+that.WebEnquiry.urlRoot;
			
			done();
		});
	});
	afterEach(function() {});
	
	
	/* Default Spec Code */
	it('Is Not Null', function(done){
		expect(that.WebEnquiry).not.toBeNull();
		done();
	});
	
	/*
		Get a test model from the server.

		Requires that an model with name = 'test' and ID=1 exists in the api
		
		DISABLED AS API ACCESS not allowed
		
	*/
	xit('Can retrieve an ID from the server',function(done){
		
		var model = new that.WebEnquiry({ID: 1});
		
		model.fetch().done(function(){
			expect(model.get('Name')).toEqual('Test');
			done();
		});
	});
	
	it('Can save data to the server',function(done){
		
		var model = new that.WebEnquiry();
		
		model.set({
			Name: 'test',
			Email: 'test@test.com'
		});
		
		that.Backbone.listenToOnce(model,'sync',function(){
			expect(1).toEqual(1);
			done();
		});
		that.Backbone.listenToOnce(model,'error',function(){
			expect(0).toEqual(1);
		});
		
		model.save();
		
	});
	
	
	
	/*
		Save a model to the server
	*/
});
