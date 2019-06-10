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

if(!function_exists('sy_style')){
    function sy_style( $handle, $src, $ver = false, $media = 'all' ) {
        $href = $ver ? $src.'?ver='.$ver : $src;
        echo "<link rel='stylesheet' id='".$handle."-css'  href='".$href."' type='text/css' media='".$media."' />";
    }
}

if(!function_exists('sy_script')){
    function sy_script( $handle, $src, $ver = false ) {
        $href = $ver ? $src.'?ver='.$ver : $src;
        echo "<script id='".$handle."' type='text/javascript' src='".$href."'></script>";
    }
}

if(!class_exists('SYApi')){
    require_once plugin_dir_path( __FILE__ ) . '../inc/api.php';
}

if(!class_exists('SYTemplates')){
    require_once plugin_dir_path( __FILE__ ) . '../inc/templates.php';
}

if(!function_exists('is_serialized')){
    function is_serialized( $input ){
        global $syhelpers;
        return $syhelpers->is_serialized( $input );
    }
}

if(!function_exists('_serialize')){
    function _serialize( $input ){
        global $syhelpers;
        return $syhelpers->_serialize( $input );
    }
}

if(!function_exists('_unserialize')){
    function _unserialize( $input ){
        global $syhelpers;
        return $syhelpers->_unserialize( $input );
    }
}

if(!function_exists('printr')){
    function printr( $input ){
        global $syhelpers;
        return $syhelpers->printr( $input );
    }
}

if(!function_exists('get_rates')){
    function get_rates(){
        global $post, $syapi;
        return $syapi->get_rates($post->ID);
    }
}

if(!function_exists('syga_rating_frame')){
    function syga_rating_frame( $attr_class = NULL ){
        global $sytemplates;
        echo $sytemplates->syga_rating_frame( $attr_class );
    }
}

if(!function_exists('syga_rating_template')){
    function syga_rating_template( $post_id ){
        global $sytemplates;
        echo $sytemplates->syga_rating_template( $post_id );
    }
}

if(!function_exists('syga_rating_reload_template')){
    function syga_rating_reload_template( $post ){
        global $sytemplates;
        echo $sytemplates->syga_rating_reload_template( $post );
    }
}