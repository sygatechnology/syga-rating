<?php
/**
 * Class name: SYTemplates
 * Description: Templates functions
 * Version:     1.0.0
 * Author:      B.Clash
 * 
 * @since	1.0.0
 */

global $syapi;
if(!isset($syapi)){
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'inc/api.php';
}

global $syhelpers;
if(!isset($syhelpers)){
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'inc/helpers.php';
}

class SYTemplates
{
    /**
    * @var object $syhelpers
    */
    private $syhelpers;

    /**
	 * Nesting level of the output buffering mechanism
	 *
	 * @var	int
	 */
	protected $_sy_ob_level;
    
    function __construct()
	{
        global $syapi;
        if(isset($syapi)){
            $this->syapi = $syapi;
        } else {
            wp_die("L'objet class SYApi de l'extension Syga Rating n'existe pas dans le fichier inc/templates.php.", "Syga Rating plugin Error");
        }

        global $syhelpers;
        if(isset($syhelpers)){
            $this->syhelpers = $syhelpers;
        } else {
            wp_die("L'objet class SYHelpers de l'extension Syga Rating n'existe pas.", "Syga Rating plugin Error");
        }
        $this->_sy_ob_level = ob_get_level();
    }

    public function load($template, $vars = array()){
        return $this->_load($template, $this->_sy_prepare_template_vars($vars));
    }

    private function _load($_sy_template_path, $_sy_vars){
        $_sy_ext = pathinfo($_sy_template_path, PATHINFO_EXTENSION);
        $_sy_template_path = ($_sy_ext === '') ? $_sy_template_path.'.php' : $_sy_template_path;

        if (!file_exists($_sy_template_path)){
            wp_die("Le fichier " . $_sy_template_path . " n'existe pas.", "Syga Rating Error");
        }

        foreach($_sy_vars as $key => $value){
            ${$key} = $value;
        }

        ob_start();

		if ( ! ini_get('short_open_tag') && phpversion() < '5.4' )
		{
			echo eval('?>'.preg_replace('/;*\s*\?>/', '; ?>', str_replace('<?=', '<?php echo ', file_get_contents($_ci_path))));
		}
		else
		{
			include($_sy_template_path);
        }
        
        $buffer = ob_get_contents();
        @ob_end_clean();
        return $buffer;
    }

    protected function _sy_prepare_template_vars($vars)
	{
		if ( ! is_array($vars))
		{
			$vars = is_object($vars)
				? get_object_vars($vars)
				: array();
		}
		return $vars;
	}

    public function load_container_box($rates, $action){
        if(!is_admin()){
            return;
        }
 ?>
        <div id="syga-fields-content">
        <input type="hidden" name="sygahiddenaction" value="<?php echo $action; ?>">
<?php
            foreach($rates as $position => $rate){
                echo $this->load( plugin_dir_path( dirname( __FILE__ ) ) . 'templates/fields-form.php', array(
                    'position' => $position,
                    'rate' => $rate
                ));
            }
?>
        </div>
        <div class="syga-button-add-fields-content align-right">
            <button id="syga-rating-load-fields-form" type="button" class="button">Ajouter un nouveau formulaire</button>
        </div>
<?php
    }

    private function load_edit_fields_form($position, $rate){
        if(!is_admin()){
            return;
        }
        ob_start();
        include( plugin_dir_path( dirname( __FILE__ ) ) . 'templates/fields-form.php' );
        $buffer = ob_get_contents();
        @ob_end_clean();
        return $buffer;
    }

    public function load_new_fields_form( $feature_label ){
        if(!is_admin()){
            return;
        }
        $position = $_REQUEST['pos'];
        $response = new WP_Ajax_Response;

        $response->add( array(
            'data'	=> $this->load(plugin_dir_path( dirname( __FILE__ ) ) . 'templates/fields-form.php', array(
                'position' => $_REQUEST['pos'],
                'rate' => array(
                    'title' => '',
                    'min' => 1,
                    'max' => 10,
                    'values' => []
                ),
                'title' => $feature_label
            ))
        ));

        $response->send();
        exit();
    }

    protected function _new_fields_form($position){
        ob_start();
        include( plugin_dir_path( dirname( __FILE__ ) ) . 'templates/new-fields-form.php' );
        $buffer = ob_get_contents();
        @ob_end_clean();
        return $buffer;
    }

    public function syga_rating_frame( $attr_class = '' ){
        global $post, $syapi;
        if( $syapi->is_registered_post_type($post->post_type) ){
            return '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" id="syga-rating-frame" class="'.$attr_class.'" src="' . plugin_dir_url( dirname( __FILE__ ) ) . 'templates/syga-rating-content.php?post_id='.$post->ID.'&action=list" allowfullscreen></iframe></div>';
        }
    }

    public function syga_rating_list( $post_id ){
        global $post, $syapi, $syhelpers;
        $post = !isset( $post ) ? get_post( $post_id ) : $post;

        if ( empty($post) )
            return;
            
        $rates = $syapi->get_post_rates($post->ID);
        $vars = array(
            'post_id' => $post->ID,
            'rates' => $rates,
            'labels' => $syhelpers->_unserialize( get_option( "syga_rating_labels" ) ),
            'syga_rating_enable_ajax' => get_option( 'syga_rating_enable_ajax' )
        );
        return $this->load(plugin_dir_path( dirname( __FILE__ ) ) . 'templates/rating-list.php', $vars);
    }

    public function syga_rating_form( $post_id, $index, $min, $max, $title ){
            
        $vars = array(
            'post_id' => $post_id,
            'index' => $index,
            'min' => $min,
            'max' => $max,
            'title' => $title
        );
        return $this->load(plugin_dir_path( dirname( __FILE__ ) ) . 'templates/rating-form.php', $vars);

    }

    //Deprecated
    public function syga_rating_reload_template($post){
        global $syapi, $syhelpers;
        $rates = $syapi->get_post_rates($post->ID);
        $vars = array(
            'post_id' => $post->ID,
            'rates' => $rates,
            'labels' => $syhelpers->_unserialize( get_option( "syga_rating_labels" ) )
        );
        return $this->load(plugin_dir_path( dirname( __FILE__ ) ) . 'templates/rating-template-reload.php', $vars);
    }

    public function syga_rating_display_options_template( $template, $vars ){
        return $this->load(plugin_dir_path( dirname( __FILE__ ) ) . 'templates/'.$template, $vars);
    }

}

global $sytemplates;
$sytemplates = new SYTemplates();