(function($){

    $( document ).ready( function() {

        if(typeof syga_params !== typeof undefined){

            if(syga_params.formpage == 'new'){
                syga_rating_load_fields_form(event, 0);
            }

            $( '#syga-rating-load-fields-form' ).click( function( e ) {
                var pos = $( "input.syga-fields-position" ).length > 0 ? Number($( "input.syga-fields-position" ).last().val())+1 : 1;
                syga_rating_load_fields_form(e, pos);
            });
            
        }

    });

    function syga_rating_load_fields_form(e, position){
        var data = {
            action: 'syga_rating_load_fields_form',
            pos: position
        };
        $.get(syga_params.ajaxurl, data, function( response ) {
            var fields_form = $( response ).find( 'response_data' ).text();
            $( '#syga-fields-content' ).append( fields_form );
        });
        e.preventDefault();
    }
    
})(jQuery);