<?php
/**
 * Plugin Name: Syga Rating
 * Plugin URI:  https://syga.mg/wordpress/plugins/syga-rating/
 * Description: Système de classement des articles ou autres
 * Version:     1.0.0
 * Author:      B.Clash
 * Author URI:  https://www.facebook.com/b.clashofficiel
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: syga-rating
 * Domain Path: /languages
*/

if ( !defined( 'ABSPATH' ) || !function_exists( 'add_filter' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if(!class_exists('SYTemplates')){
    // Call Templates class
    if(file_exists(plugin_dir_path( __FILE__ ) . 'inc/templates.php')){
        require_once plugin_dir_path( __FILE__ ) . 'inc/templates.php';
    } else {
        wp_die("Erreur du chargement du fichier inc/templates.php de l'extension Syga Rating.", "Syga Rating pluging Error");
    }
}

if(!class_exists('SYHelpers')){
    // Call Helpers class
    if(file_exists(plugin_dir_path( __FILE__ ) . 'inc/helpers.php')){
        require_once plugin_dir_path( __FILE__ ) . 'inc/helpers.php';
    } else {
        wp_die("Erreur du chargement du fichier inc/helpers.php de l'extension Syga Rating.", "Syga Rating pluging Error");
    }
}

if(!class_exists('SYApi')){
    // Call Api class
    if(file_exists(plugin_dir_path( __FILE__ ) . 'inc/api.php')){
        require_once plugin_dir_path( __FILE__ ) . 'inc/api.php';
    } else {
        wp_die("Erreur du chargement du fichier inc/api.php de l'extension Syga Rating.", "Syga Rating pluging Error");
    }
}


/**
 * Main class
 *
 * @since	1.0.0
 */
class SygaRating
{
	/** 
    * @var string $dir Plugin dir 
    */
	private $dir;
	/**
    * @var string $path Plugin path
    */
	private $path;
	/**
    * @var string $version Plugin version
    */
    private $version;
    
    /**
    * @var array $post_types
    */
    private $post_types;
    
    /**
    * @var object $sytemplates
    */
    private $sytemplates;
    
    /**
    * @var object $syapi
    */
	private $syapi;

    /**
    * @var object $syhelpers
    */
	private $syhelpers;

	function __construct()
	{
        global $sytemplates;
        if(isset($sytemplates)){
            $this->sytemplates = $sytemplates;
        } else {
            wp_die("L'objet class SYTemplates de l'extension Syga Rating n'existe pas.", "Syga Rating plugin Error");
        }

        global $syhelpers;
        if(isset($syhelpers)){
            $this->syhelpers = $syhelpers;
        } else {
            wp_die("L'objet class SYHelpers de l'extension Syga Rating n'existe pas.", "Syga Rating plugin Error");
        }

        global $syapi;
        if(isset($syapi)){
            $this->syapi = $syapi;
        } else {
            wp_die("L'objet class SYApi de l'extension Syga Rating n'existe pas dans le fichier syga-rating.php.", "Syga Rating plugin Error");
        }

		// vars
        $this->dir = plugins_url( '', __FILE__ );
        $this->url = plugin_dir_url( __FILE__ );
		$this->path = plugin_dir_path( __FILE__ );
        $this->version = '1.0.0';
        load_plugin_textdomain( 'syrating', false, basename( dirname(__FILE__) ).'/languages' );
        $this->init();
    }

    function init(){
        $this->register_hooks();
        $this->add_actions();
    }

    function register_hooks(){
        register_activation_hook( __FILE__, array($this, 'syga_rating_activate_flush_rewrite') );
        register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
    }

	function syga_rating_activate_flush_rewrite()
	{
		flush_rewrite_rules();
    }

    function add_actions(){
        add_action( 'init', array($this, 'syga_rating_register_post_types') );
        add_action( 'wp_enqueue_scripts', array($this, 'syga_rating_frontend_enqueue'));
        add_action( 'admin_init', array($this, 'syga_rating_backend_enqueue') );
        add_action( 'admin_init', array($this, 'syga_rating_add_post_meta_boxes') );
        add_action( 'save_post', array($this, 'save_syga_rating'), 10, 3 );
        add_action( 'after_delete_post', array($this, 'delete_syga_rating'), 10, 3 );
    }

    function syga_rating_register_post_types(){
        $labels = array(
            'name'                => _x( 'Syga Rating', 'Post Type General Name', 'sygarating' ),
            'singular_name'       => _x( 'Syga Rating', 'Post Type Singular Name', 'sygarating' ),
            'menu_name'           => __( 'Syga Rating', 'sygarating' ),
            'parent_item_colon'   => __( 'Parent Syga Rating', 'sygarating' ),
            'all_items'           => __( 'All Syga Rating', 'sygarating' ),
            'view_item'           => __( 'View Syga Rating', 'sygarating' ),
            'add_new_item'        => __( 'Add New Syga Rating', 'sygarating' ),
            'add_new'             => __( 'Add New', 'sygarating' ),
            'edit_item'           => __( 'Edit Syga Rating', 'sygarating' ),
            'update_item'         => __( 'Update Syga Rating', 'sygarating' ),
            'search_items'        => __( 'Search Syga Rating', 'sygarating' ),
            'not_found'           => __( 'Not Found', 'sygarating' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'sygarating' ),
        );
         
        $args = array(
            'label'               => __( 'syga_rating', 'sygarating' ),
            'description'         => __( 'Syga Rating news and reviews', 'sygarating' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions' ),
            'taxonomies'          => array( 'category', 'post_tag' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
            'menu_icon'           => 'dashicons-star-filled'
        );

        register_post_type( 'syga_rating', $args );
    }

    function syga_rating_frontend_enqueue(){
        wp_enqueue_style( 'syga-ionRangeSlider-frontend-styles', $this->dir . '/assets/css/plugins/ionRangeSlider/ion.rangeSlider.css', __FILE__ , '1.0.0' );
        wp_enqueue_style( 'syga-ionRangeSlider-skin-frontend-styles', $this->dir . '/assets/css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css', __FILE__ , '1.0.0' );
        wp_enqueue_style( 'syga-frontend-styles', $this->dir . '/assets/css/syga-frontend.css' , __FILE__ , '1.0.0' );

        wp_enqueue_script( 'syga-jquery-frontend-js', plugins_url( '/assets/js/plugins/jquery-2.1.1.js', __FILE__ ), '1.0.0' );
        wp_enqueue_script( 'syga-ionRangeSlider-frontend-js', plugins_url( '/assets/js/plugins/ionRangeSlider/ion.rangeSlider.min.js', __FILE__ ), '1.0.0' );
        wp_enqueue_script( 'syga-frontend-js', plugins_url( '/assets/js/syga-frontend.js', __FILE__ ), '1.0.0' );

        $params = array(
            'ajaxurl' => plugins_url( 'ajax-request.php', __FILE__ )
        );
        wp_localize_script( 'syga-frontend-js', 'syga_params', $params );
        
        wp_enqueue_script( 'syga-frontend-ajax-js', $this->url . 'assets/js/syga-ajax-frontend.js', array( 'jquery' ), '1.0.0', true );
        add_action( 'wp_ajax_syga_rating_load_comment_form', array($this, 'syga_rating_load_comment_form') );
    }

    function syga_rating_backend_enqueue(){
        wp_enqueue_style( 'syga-backend-styles', $this->dir . '/assets/css/syga-backend.css' );
        wp_enqueue_script('syga-backend-js',  $this->url . 'assets/js/syga-backend.js', __FILE__, '1.0.0' );

        wp_enqueue_script( 'syga-backend-ajax-js', $this->url . 'assets/js/syga-ajax-backend.js', array( 'jquery' ), '1.0.0', true );
        add_action( 'wp_ajax_syga_rating_load_fields_form', array($this, 'syga_rating_load_fields_form') );
    }

    function syga_rating_add_post_meta_boxes(){
        add_meta_box(
            "post_metadata_syga_rating",
            "Sujets de classement d'avis pour le poste",
            array($this, "post_meta_box_syga_rating"),
            'syga_rating',
            "advanced",
            "high"
        );
    }

    function post_meta_box_syga_rating(){
        $protocol = isset( $_SERVER['HTTPS'] ) ? 'https://' : 'http://';
        $params = array(
            'ajaxurl' => admin_url( 'admin-ajax.php', $protocol ),
            'formpage' => (isset($_GET['action']) && $_GET['action'] == 'edit') ? 'edit' : 'new'
        );
        global $post;
        $rates = $this->syapi->get_rates($post->ID);
        if(count($rates) == 0){
            $params['formpage'] = 'new';
        }
        wp_localize_script( 'syga-backend-ajax-js', 'syga_params', $params );
        $this->sytemplates->load_container_box($rates, $params['formpage']);
    }

    function save_syga_rating($post_id, $post){
        if(isset($_POST['syga_rating_input']) && isset($_POST['sygahiddenaction'])){
            $this->syapi->save_rates($post_id, $_POST['syga_rating_input'], $_POST['sygahiddenaction']);
        }
    }

    function delete_syga_rating($post_id){
        $this->syapi->delete_rates($post_id);
    }

    function syga_rating_load_comment_form(){
        $this->sytemplates->load_comment_form();
    }

    function syga_rating_load_fields_form(){
        $this->sytemplates->load_new_fields_form();
    }
}
new SygaRating();