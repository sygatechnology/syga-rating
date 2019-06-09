function syga_load_comment_form(post_id, index){
	var element = $( '#syga-rate-'+index );
	var index = $(element).data('index');
	var min = $(element).data('min');
	var max = $(element).data('max');
	var title = $(element).data('title');
	syga_show_ion_range_slider(post_id, index, min, max, title);
}

function syga_show_ion_range_slider(post_id, index, min, max, title){
	$.ajax({
		"url": syga_params.ajaxurl,
		"type": "POST",
		"data": {
			"action": "comment-form",
			"post_id" : post_id,
			"index" : index,
			"min" : min,
			"max" : max,
			"title" : title
		},
		success: function( data ){
			$( '#syga-rating-tr-'+index ).hide().after( data );
			$("#syra-ionrange-"+index).ionRangeSlider({
				step: min,
				min: min,
				max: max,
				type: 'single',
				postfix: " point(s)",
				prettify: true,
				hasGrid: true
			});
			syga_before_save_rate();
		}
	});
}

function syga_before_save_rate(){
	$( 'button.syga-rating-submit-button' ).click(function(){
		var form = $( this ).parents( 'form.syga-rating-form' );
		var action = $( form ).find( 'input[name="action"]').val();
		var post_id = $( form ).find( 'input[name="post_id"]').val();
		var index = $( form ).find( 'input[name="index"]').val();
		var note = $( form ).find( 'input[name="note"]').val();
		var comment = $( form ).find( 'input[name="comment"]').val();
		syga_save_rate(action, post_id, index, note, comment)
	});
}

function syga_save_rate(action, post_id, index, note, comment){
	$.ajax({
		"url": syga_params.ajaxurl,
		"type": "POST",
		"data": {
			"action": action,
			"post_id" : post_id,
			"index" : index,
			"note" : note,
			"comment" : comment
		},
		success: function( data ){
			$( '#syga-rating-container' ).html( data );
		}
	});
}

function syga_after_save_rate(){
	$( '#syga-rating-form-tr-'+index ).remove();
	$( '#syga-rating-tr-'+index ).show();
}