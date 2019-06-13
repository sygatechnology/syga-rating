<?php
/**
 * Plugin Name: Syga Rating
 * Plugin URI:  https://github.com/sygatechnology/syga-rating
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

    /**
    * @var array $syga_rating_cpt
    */
    private $syga_rating_cpt;

    /**
    * @var array $syga_rating_labels
    */
    private $syga_rating_labels;

    /**
    * @var string $action_hidden
    */
    private $syga_rating_enable_ajax;

    /**
    * @var string $action_hidden
    */
    private $action_hidden = "first";
    

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
        $this->load_core_options();
        $this->register_hooks();
        $this->add_actions();
        $this->add_filters();
    }

    protected function load_core_options(){
        $syga_rating_cpt = get_option( "syga_rating_cpt" );
        if( $syga_rating_cpt ){
            $this->syga_rating_cpt = $this->syhelpers->_unserialize( $syga_rating_cpt );
            $this->action_hidden = "update";
        }
        
        $syga_rating_labels = get_option( "syga_rating_labels" );
        if( $syga_rating_labels ){
            $this->syga_rating_labels = $this->syhelpers->_unserialize( $syga_rating_labels );
        }

        $this->syga_rating_enable_ajax = get_option( "syga_rating_enable_ajax" );
    }

    function register_hooks(){
        register_activation_hook( __FILE__, array($this, 'syga_rating_set_core_options') );
        register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
    }

	function syga_rating_set_core_options()
	{
        $cpt_options = array(
            "slug" => "",
            "name" => "",
            "singular_name" => "",
            "menu_name" => "",
            "menu_name" => "",
            "supports" => array(),
            "taxonomies" => array()
        );
        $labels_options = array(
            "title" => "",
            "feature" => "",
            "number" => "",
            "average" => ""
        );
        add_option( "syga_rating_cpt", $this->syhelpers->_serialize( $cpt_options ) );
        add_option( "syga_rating_labels", $this->syhelpers->_serialize( $labels_options ) );
        add_option( "syga_rating_enable_ajax", "true" );
        add_option( "syga_rating_version", $this->version );
        add_option( "_syga_rating_activation_redirect", TRUE );
        flush_rewrite_rules();
    }

    function syga_rating_activation_redirect() {
        if ( get_option( "_syga_rating_activation_redirect", FALSE ) ) {
           delete_option( "_syga_rating_activation_redirect" );
           wp_redirect( "options-general.php?page=syga-rating" );
           exit;
        }
     }

    function add_actions(){
        
        if( $this->syga_rating_cpt ) {
            add_action( 'init', array($this, "syga_rating_register_post_types") );
            add_action( 'wp_enqueue_scripts', array($this, 'syga_rating_iframe_frontend_enqueue'));
            add_action( 'admin_init', array($this, 'syga_rating_backend_enqueue') );
            add_action( 'admin_init', array($this, 'syga_rating_add_post_meta_boxes') );
            add_action( 'save_post', array($this, 'save_syga_rating'), 10, 2 );
            add_action( 'after_delete_post', array($this, 'delete_syga_rating'), 10, 1 );
        }
        add_action( 'admin_menu', array($this, 'syga_rating_register_options_page') );
        add_action( 'admin_init', array( $this, 'syga_rating_activation_redirect') );
    }

    function syga_rating_register_post_types(){
        $labels = array(
            'name'                => _x( $this->syga_rating_cpt['name'], 'Post Type General Name', 'sygarating' ),
            'singular_name'       => _x( $this->syga_rating_cpt['singular_name'], 'Post Type Singular Name', 'sygarating' ),
            'menu_name'           => __( $this->syga_rating_cpt['menu_name'], 'sygarating' ),
            'parent_item_colon'   => __( 'Parent '.$this->syga_rating_cpt['name'], 'sygarating' ),
            'all_items'           => __( 'All '.$this->syga_rating_cpt['name'], 'sygarating' ),
            'view_item'           => __( 'View '.$this->syga_rating_cpt['singular_name'], 'sygarating' ),
            'add_new_item'        => __( 'Add New '.$this->syga_rating_cpt['singular_name'], 'sygarating' ),
            'add_new'             => __( 'Add New', 'sygarating' ),
            'edit_item'           => __( 'Edit '.$this->syga_rating_cpt['singular_name'], 'sygarating' ),
            'update_item'         => __( 'Update '.$this->syga_rating_cpt['singular_name'], 'sygarating' ),
            'search_items'        => __( 'Search '.$this->syga_rating_cpt['singular_name'], 'sygarating' ),
            'not_found'           => __( 'Not Found', 'sygarating' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'sygarating' ),
        );
         
        $args = array(
            'label'               => __( $this->syga_rating_cpt['slug'], 'sygarating' ),
            'description'         => __( $this->syga_rating_cpt['name'].' news and reviews', 'sygarating' ),
            'labels'              => $labels,
            'supports'            => $this->syga_rating_cpt['supports'],
            'taxonomies'          => $this->syga_rating_cpt['taxonomies'],
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

        register_post_type( $this->syga_rating_cpt['slug'], $args );
    }

    function syga_rating_register_options_page(){
        add_options_page('Options Syga Rating', 'Syga Rating', 'manage_options', 'syga-rating', array($this, 'syga_rating_options_page') );
    }

    function syga_rating_options_page(){
        $vars = array(
            'syga_rating_cpt' => (array)$this->syga_rating_cpt,
            'syga_rating_labels' => (array)$this->syga_rating_labels,
            'syga_rating_enable_ajax' => $this->syga_rating_enable_ajax,
            'actionhidden' => $this->action_hidden
        );
        echo $this->sytemplates->load(
            plugin_dir_path( __FILE__ ) . 'templates/settings.php', $vars
        );
    }

    function add_filters(){
        add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array($this, 'syga_rating_action_links') );
    }

    function syga_rating_action_links( $links ){
        $links[] = '<a href="'. esc_url( get_admin_url(null, 'options-general.php?page=syga-rating') ) .'">Paramètres</a>';
        return $links;
    }

    function syga_rating_iframe_frontend_enqueue(){
        wp_enqueue_style( 'syga-ionRangeSlider-iframe-frontend-styles', $this->dir . '/assets/css/iframe-frontend.css', __FILE__ , '1.0.0' );
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
            $this->syga_rating_labels['title'],
            array($this, "post_meta_box_syga_rating"),
            $this->syga_rating_cpt['slug'],
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

    function syga_rating_load_fields_form(){
        $this->sytemplates->load_new_fields_form( $this->syga_rating_labels['feature'] );
    }
}
new SygaRating();