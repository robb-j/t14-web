(function($) {
	$(window).unload(function(){
		
		console.log("hello");
		
		$.ajax({
			type: 'POST',
			url: 'AccountController/Logout',
			async:false,
			data: {key_leave:"289583002"}
		});
	});
})(jQuery);