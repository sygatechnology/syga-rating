<?php
/**
 * Class name: SYApi
 * Description: Functions api
 * Version:     1.0.0
 * Author:      B.Clash
 * 
 * @since	1.0.0
 */
class SYApi
{
    function __construct()
	{
        global $syhelpers;
        if(isset($syhelpers)){
            $this->syhelpers = $syhelpers;
        } else {
            wp_die("L'objet class SYHelpers de l'extension Syga Rating n'existe pas.", "Syga Rating plugin Error");
        }
    }

    public function save_rates($post_id, $rates, $action){
        $syga_rating_input_reindexed = [];
        foreach($rates as $input){
            if( $action == 'new' ){
                $input['values'] = [];
            } else if( $action == 'edit' ) {
                $input['values'] = ( $input['values'] == 'syinit' ) ? [] : $this->syhelpers->_unserialize($input['values']);
            }
            $syga_rating_input_reindexed[] = $input;
        }
        $syga_rating_input = $this->syhelpers->_serialize($syga_rating_input_reindexed);
        update_post_meta($post_id, "_rates", $syga_rating_input);
    }

    public function get_rates_list($post_id){
        $rates = get_post_custom($post_id);
        if(isset($rates['_rates'])){
            $rates_serialized = $this->syhelpers::_unserialize($rates['_rates'][0]);
            $rates = $this->syhelpers::_unserialize($rates_serialized);
        } else {
            $rates = [];
        }
        return $rates;
    }

    public function get_rates($post_id){
        $rates = [];
        $post_custom = get_post_custom($post_id);
        if(isset($post_custom['_rates'])){
            $post_custom_serialized = $this->syhelpers::_unserialize($post_custom['_rates'][0]);
            $rates_custom = $this->syhelpers::_unserialize($post_custom_serialized);
            foreach( $rates_custom as $rate ){
                $values = (array)$rate['values'];
                $rates[] = (object) array(
                    'title' => $rate['title'],
                    'number' => count($values),
                    'average' => $this->get_average($values),
                    'has_commented' => $this->is_user_has_commented(get_current_user_id(), $values)
                );
            }
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
}
