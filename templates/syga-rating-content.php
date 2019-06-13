<?php 
    /** Load WordPress Bootstrap */
    require_once( dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) . '/wp-load.php' );
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

        require_once 'header.php';

        if( isset($_GET['action']) && $_GET['action'] == 'list' ) {
            syga_rating_list( $_GET['post_id'] );
        } else {
            syga_rating_form( $_GET['post_id'], $_GET['index'], $_GET['min'], $_GET['max'], $_GET['title'] );
        }

        require_once 'footer.php';

    } else {

        wp_die("Action non permise.", "Syga Rating", "503");

    }

?>
