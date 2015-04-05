(function($) {
    $(document).ready(function(){
        
        
        /* Listen for clicks on the category delete button */
        $(document).on('click', '.group-edit-page a.category-delete', function(e) {
	        
	        // Stop the actual link 
	        e.preventDefault();
	        
	        
	        // Get the id and type from the data elements
			var id = $(e.currentTarget).data("category");
			var type = $(e.currentTarget).data("type");
			
			
			// Remove the row from the html
			$(e.currentTarget).closest(".data-row").remove();
			
			
			// If its an existing category, add an input to tell the form to delete it
			if (type === 'existing') {
				
				$("form.group-edit-form .removed-categories").append("<input type='hidden' name='RemovedCategories[" + id + "]' value='true' />");
			}
			
        });
        
        
        /* Listen for clicks on the add category button */
		$(".group-edit-page a.add-category").click(function(e) {
	        
	        // Stop the actual link
			e.preventDefault();
			
			
			// Get the holder to put the new row in & the count of already insreted categories
			var holder = $(".group-edit-page .inserted-categories");
			var index = holder.children().length;
			
			
			// Create the fields
			var nameField = "<input class='form-control' name='NewNames[" + index + "]' placeholder='Title'/>";
			var amountField = "<input class='form-control' name='NewBudgets[" + index + "]' placeholder='Balance'/>";
			var deleteButton = '<a href="#" data-category="$ID" class="category-delete control-button cb-small cb-no-mar cb-red"> X </a>';
			
			
			// Create bootstrap columns for the fields
			var nameCol = '<div class="col-xs-7">' + nameField + '</div>';
			var amountCol = '<div class="col-xs-3"> <div class="input-group"><div class="input-group-addon">£</div>' + amountField + "</div> </div>";
			var deleteCol = '<div class="col-xs-2">' + deleteButton + '</div>';
			
			
			// Create the table row from the columns
			var newRow = "<div class='data-row'><div class='row'>" + nameCol + amountCol + deleteCol + "</div></div>";
	       	
	       	
	       	// Insert the row
			holder.append(newRow);
        });
        
    });
    
})(jQuery);

