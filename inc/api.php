<?php
/**
 * Class name: SYApi
 * Description: Functions api
 * Version:     1.0.0
 * Author:      B.Clash
 * 
 * @since	1.0.0
 */

global $syhelpers;
if(!isset($syhelpers)){
    require_once plugin_dir_path( __FILE__ ) . '../inc/helpers.php';
}

class SYApi
{
    function __construct()
	{
        global $syhelpers;
        if(isset($syhelpers)){
            $this->syhelpers = $syhelpers;
        } else {
            wp_die("L'objet class SYHelpers de l'extension Syga Rating n'existe pas dans le fichier inc/api.php.", "Syga Rating plugin Error");
        }
    }

    public function register_core_options(){
        add_option( 'my_plugin_activated', time() );
    }

    public function save_rates($post_id, $rates, $action){
        $syga_rating_input_reindexed = [];
        foreach($rates as $index => $input){
            if( $action == 'new' ){
                $input['values'] = [];
            } else if( $action == 'edit' ) {
                $rate = $this->get_rate($post_id, $index);
                $input['values'] = !is_null( $rate ) ? $rate['values'] : array();
            }
            $syga_rating_input_reindexed[$index] = $input;
        }
        $syga_rating_input = $this->syhelpers->_serialize($syga_rating_input_reindexed);
        update_post_meta($post_id, "_rates", $syga_rating_input);
    }

    public function delete_rates($post_id){
        delete_post_meta($post_id, "_rates");
    }

    public function get_rates($post_id){
        $rates = get_post_custom($post_id);
        if(isset($rates['_rates'])){
            $rates_serialized = $this->syhelpers::_unserialize($rates['_rates'][0]);
            $rates = $this->syhelpers::_unserialize($rates_serialized);
        } else {
            $rates = [];
        }
        return $rates;
    }

    public function get_rate($post_id, $index){
        $rates = $this->get_rates($post_id);
        return isset( $rates[ $index ] ) ? $rates[ $index ] : NULL;
    }

    public function is_registered_post_type($post_type){
        $syga_rating_cpt = $this->syhelpers->_unserialize( get_option( "syga_rating_cpt" ) );
        return ( $post_type == $syga_rating_cpt['slug'] ) ? TRUE : FALSE;
    }

    public function get_post_rates($post_id){
        $registered_rates = $this->get_rates($post_id);
        $rates = [];
        foreach( $registered_rates as $rate ){
            $values = (array)$rate['values'];
            $rates[] = (object) array(
                'title' => $rate['title'],
                'number' => count($values),
                'average' => $this->get_average($values),
                'has_commented' => $this->is_user_has_commented(get_current_user_id(), $values),
                'min' => $rate['min'],
                'max' => $rate['max']
            );
        }
        return $rates;
    }

    protected function get_average( $values ){
        $new_values = [];
        foreach( $values as $value ){
            $new_values[] = $value['note'];
        }
        if( array_sum( $new_values ) == 0 || count( $new_values ) == 0 )
            return 0;
            
        return ceil( array_sum( $new_values ) / count( $new_values ) );
    }

    public function is_user_has_commented( $user_id, $values ){
        $users = [];
        foreach( $values as $value ){
            $users[] = $value['user'];
        }
        return (bool) in_array( $user_id, $users );
    }

    public function add_user_note( $post_id, $index, $note, $comment ){
        $registered_rates = $this->get_rates($post_id);
        $registered_rates[ $index ][ 'values' ][] = array(
            'user' => get_current_user_id(),
            'note' => $note,
            'comment' => $comment
        );
        return $this->update_rates( $post_id, $registered_rates);
    }

    protected function update_rates( $post_id, $rates ){
        $syga_rating_input = $this->syhelpers->_serialize($rates);
        update_post_meta($post_id, "_rates", $syga_rating_input);
        return get_post($post_id);
    }
}

global $syapi;
$syapi = new SYApi();