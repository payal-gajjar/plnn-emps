jQuery(document).ready(function($) {
	$('.checkbox_confirm .wpcf7-list-item, .checkbox_privacy .wpcf7-list-item').append('<span class="check-box-style"></span>');
/* on category chane ajax call */
	$('.snoc-loadmore').hide();
	$("#news_category , #news_tags").change(function(){
        var selectedCategory = $("#news_category").children("option:selected").val();
        var selectedTag = $("#news_tags").children("option:selected").val();
		var offset = 0;
        jQuery.ajax({
			url: object.ajax_url,
			type: 'POST',			
			data: {'action':'get_newslist_data','CategoryID': selectedCategory,'TagID': selectedTag , 'offset' : offset},
			beforeSend: function() {
				jQuery('.before-load').show();
			},
			success: function(response) {
				var response = JSON.parse(response);
				if (response.count == 0) {
					$('.snoc-loadmore').hide();
					$('.news-list-block').html(response.html);					
				} else {
					$('.snoc-loadmore').show();
				}
				$('.snoc-loadmore').attr('data-offset', 4);
				$('.news-list-block').html(response.html);
				
		    },
			complete: function(){
				jQuery('.before-load').hide();
			},
		});
    }).change();

	$(".snoc-loadmore").click(function(){	
		var selectedCategory = $("#news_category").children("option:selected").val();
		var selectedTag = $("#news_tags").children("option:selected").val();
		var offset = $(this).attr('data-offset');
		var currClass = $(this).attr('class');				
		jQuery.ajax({
				url: object.ajax_url,
				type: 'POST',			
				data: {'action':'get_newslist_data','CategoryID': selectedCategory,'TagID': selectedTag , 'offset' : offset},
				beforeSend: function() {
					jQuery('.before-load').show();
				},
				success: function(response) {
					var response = JSON.parse(response);
					if (response.count == 0) {
						$('.snoc-loadmore').attr('data-offset', 4);
						$('.snoc-loadmore').hide();							
					} else {
						$('.snoc-loadmore').show();
					}
					if (currClass == 'snoc-loadmore') {
						$('.news-list-block').append(response.html);
						$('.snoc-loadmore').attr('data-offset', 4 + parseInt(offset));
					} else {
						$('.news-list-block').html(response.html);
						$('.snoc-loadmore').attr('data-offset', 4);
					}
				},
				complete: function(){
					jQuery('.before-load').hide();
				},
		});
	});
	
	var image_save_msg='';
	var no_menu_msg='';
	
	 function disableCTRL(e)
	{
		var allow_input_textarea = true;
		var key; isCtrl = false;
		if(window.event)
			{ key = window.event.keyCode;if(window.event.ctrlKey)isCtrl = true;  }
		else
			{ key = e.which; if(e.ctrlKey) isCtrl = true;  }
	        
	     if(isCtrl && ( key == 83 ))
	          return false;
	          else
	          return true;}  function disablecmenu(e)
	{		
	if (document.all){
		if(window.event.srcElement.nodeName=='IMG')
 		{ return false; }
 		else
 		{ return false;} // Blocks Context Menu

	 }else
	 {
		
	 	if(e.target.nodeName=='IMG')
	 		{ return false;}
	 	else
	 		{ return false;} // Blocks Context Menu
	 	
	 }
 
	} 
	document.onkeydown= disableCTRL; 
	document.oncontextmenu = disablecmenu;
	
	
	$("#info_circle_sec .snoc-circle-title").click(function() {
   	 window.location = "https://snoc.ae/about-us/";
		return false;
	});
	
	
	
	/* on social category chane ajax call */
	$('.snoc-loadmores').hide();
	$("#social_category , #social_tags").change(function(){
        var selectedCategory = $("#social_category").children("option:selected").val();
        var selectedTag = $("#social_tags").children("option:selected").val();
		var offset = 0;
        jQuery.ajax({
			url: object.ajax_url,
			type: 'POST',			
			data: {'action':'get_sociallist_data','CategoryID': selectedCategory,'TagID': selectedTag , 'offset' : offset},
			beforeSend: function() {
				jQuery('.before-loads').show();
			},
			success: function(response) {
				var response = JSON.parse(response);
				if (response.count == 0) {
					$('.snoc-loadmores').hide();
					$('.news-list-blocks').html(response.html);					
				} else {
					$('.snoc-loadmores').show();
				}
				$('.snoc-loadmores').attr('data-offset', 4);
				$('.news-list-blocks').html(response.html);
				
		    },
			complete: function(){
				jQuery('.before-loads').hide();
			},
		});
    }).change();

	$(".snoc-loadmores").click(function(){	
		var selectedCategory = $("#social_category").children("option:selected").val();
		var selectedTag = $("#social_tags").children("option:selected").val();
		var offset = $(this).attr('data-offset');
		var currClass = $(this).attr('class');				
		jQuery.ajax({
				url: object.ajax_url,
				type: 'POST',			
				data: {'action':'get_sociallist_data','CategoryID': selectedCategory,'TagID': selectedTag , 'offset' : offset},
				beforeSend: function() {
					jQuery('.before-loads').show();
				},
				success: function(response) {
					var response = JSON.parse(response);
					if (response.count == 0) {
						$('.snoc-loadmores').attr('data-offset', 4);
						$('.snoc-loadmores').hide();							
					} else {
						$('.snoc-loadmores').show();
					}
					if (currClass == 'snoc-loadmores') {
						$('.news-list-blocks').append(response.html);
						$('.snoc-loadmores').attr('data-offset', 4 + parseInt(offset));
					} else {
						$('.news-list-blocks').html(response.html);
						$('.snoc-loadmores').attr('data-offset', 4);
					}
				},
				complete: function(){
					jQuery('.before-loads').hide();
				},
		});
	});
	
	
	
	
});