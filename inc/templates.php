<?php
/**
 * Class name: SYTemplates
 * Description: Templates functions
 * Version:     1.0.0
 * Author:      B.Clash
 * 
 * @since	1.0.0
 */
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
        if(class_exists('SYApi')){
            $this->syapi = new SYApi();
        } else {
            wp_die("L'objet class SYApi de l'extension Syga Rating n'existe pas.", "Syga Rating plugin Error");
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
                echo $this->load( plugin_dir_path( __FILE__ ) . '../templates/edit-fields-form.php', array(
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
        include( plugin_dir_path( __FILE__ ) . '../templates/edit-fields-form.php' );
        $buffer = ob_get_contents();
        @ob_end_clean();
        return $buffer;
    }

    public function load_new_fields_form(){
        if(!is_admin()){
            return;
        }
        $position = $_REQUEST['pos'];
        $response = new WP_Ajax_Response;

        $response->add( array(
            'data'	=> $this->load(plugin_dir_path( __FILE__ ) . '../templates/new-fields-form.php', array(
                'position' => $position
            ))
        ));

        $response->send();
        exit();
    }

    protected function _new_fields_form($position){
        ob_start();
        include( plugin_dir_path( __FILE__ ) . '../templates/new-fields-form.php' );
        $buffer = ob_get_contents();
        @ob_end_clean();
        return $buffer;
    }

}