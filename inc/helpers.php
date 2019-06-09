<?php
/**
 * Class name: SYHelpers
 * Description: Functions hekpers
 * Version:     1.0.0
 * Author:      B.Clash
 * 
 * @since	1.0.0
 */
class SYHelpers
{
    function is_serialized( $input ) 
	{
		if ( ! is_string( $input ) )
			return FALSE;
		$input = trim( $input );
		if ( 'N;' == $input )
			return TRUE;
		if ( !preg_match( '/^([adObis]):/', $input, $badions ) )
			return FALSE;
		switch ( $badions[1] ) {
			case 'a' :
			case 'O' :
			case 's' :
				if ( preg_match( "/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $input ) )
					return TRUE;
				break;
			case 'b' :
			case 'i' :
			case 'd' :
				if ( preg_match( "/^{$badions[1]}:[0-9.E-]+;\$/", $input ) )
					return TRUE;
				break;
		}
		return FALSE;
    }
    
    function _serialize( $input )
	{
		return addslashes( serialize( $input ) );
    }
    
    function _unserialize( $input, $toObject = FALSE )
	{
		$input = unserialize( stripslashes( $input ) );
		if($toObject !== FALSE) $input = (object) $input;
		return $input;
    }
    
    function printr( $input ){
        echo '<pre>';
        print_r( $input );
        echo '</pre>';
        die();
    }
}

global $syhelpers;
$syhelpers = new SYHelpers();

if(!class_exists('SYApi')){
    require_once plugin_dir_path( __FILE__ ) . '../inc/api.php';
}

if(!class_exists('SYTemplates')){
    require_once plugin_dir_path( __FILE__ ) . '../inc/templates.php';
}

if(!function_exists('is_serialized')){
    function is_serialized( $input ){
        return $syhelpers->is_serialized( $input );
    }
}

if(!function_exists('_serialize')){
    function _serialize( $input ){
        return $syhelpers->_serialize( $input );
    }
}

if(!function_exists('_unserialize')){
    function _unserialize( $input ){
        return $syhelpers->_unserialize( $input );
    }
}

if(!function_exists('printr')){
    function printr( $input ){
        return $syhelpers->printr( $input );
    }
}

if(!function_exists('get_rates')){
    function get_rates(){
        $syapi = new SYApi();
        global $post;
        return $syapi->get_rates($post->ID);
    }
}

if(!function_exists('syga_rating_template')){
    function syga_rating_template( $attr_id = NULL, $attr_class = NULL ){
        $syapi = new SYApi();
        $rates = $syapi->get_rates($post->ID);
        $sytemplates = new SYTemplates();
        $data = array(
            'rates' => $rates,
            'id' => !is_null($attr_id) ? $attr_id : '',
            'class' => !is_null($attr_class) ? $attr_class : ''
        );
        echo $sytemplates->load(plugin_dir_path( __FILE__ ) . '../templates/rating-template.php', $data);
    }
}