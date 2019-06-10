<?php 
    /** Load WordPress Bootstrap */
    require_once( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/wp-load.php' );
    if(!function_exists('is_plugin_active')){
        function is_plugin_active( $plugin ) {
            return in_array( $plugin, (array) get_option( 'active_plugins', array() ) ) || is_plugin_active_for_network( $plugin );
        }
    }
    
    if(!function_exists('is_plugin_active_for_network')){
        function is_plugin_active_for_network( $plugin ) {
            if ( !is_multisite() )
                return false;
        
            $plugins = get_site_option( 'active_sitewide_plugins');
            if ( isset($plugins[$plugin]) )
                return true;
        
            return false;
        }
    }
    if( is_plugin_active('syga-rating/syga-rating.php') ) {
        global $sytemplates;
?>
        <!DOCTYPE html>
        <html lang="fr-FR">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Syga Rating</title>
            <?php 
                sy_style( 'syga-ionRangeSlider-bootstrap-styles', plugins_url( '/assets/css/plugins/bootstrap.min.css', __FILE__ ) );
                sy_style( 'syga-ionRangeSlider-bootstrap-styles', plugins_url( '/assets/fonts/font-awesome/css/font-awesome.min.css', __FILE__ ) );
                sy_style( 'syga-ionRangeSlider-frontend-styles', plugins_url( '/assets/css/plugins/ionRangeSlider/ion.rangeSlider.css', __FILE__ ), '1.0.0' );
                sy_style( 'syga-ionRangeSlider-skin-frontend-styles', plugins_url( '/assets/css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css', __FILE__ ), '1.0.0' );
                sy_style( 'syga-frontend-styles', plugins_url( '/assets/css/syga-frontend.css' , __FILE__ ), '1.0.0' );

                sy_script( 'syga-jquery-frontend-js', plugins_url( '/assets/js/plugins/jquery-2.1.1.js', __FILE__ ), '1.0.0' );
                sy_script( 'syga-ionRangeSlider-frontend-js', plugins_url( '/assets/js/plugins/ionRangeSlider/ion.rangeSlider.min.js', __FILE__ ), '1.0.0' );
                sy_script( 'syga-frontend-js', plugins_url( '/assets/js/syga-frontend.js', __FILE__ ), '1.0.0' );

            ?>
            <script type="text/javascript">
                var syga_params = {
                    "ajaxurl" : "<?php echo plugins_url( 'ajax-request.php', __FILE__ ); ?>"
                };
            </script>
            
            <?php
                sy_script( 'syga-frontend-ajax-js', plugins_url( 'assets/js/syga-ajax-frontend.js', __FILE__), '1.0.0' );
            ?>
        </head>
        <body>
            <?php
                syga_rating_template( $_GET['post_id'] );
            ?>
        </body>
        </html>
<?php } else {
    wp_die("Action non permise.", "Syga Rating", "503");
} ?>
