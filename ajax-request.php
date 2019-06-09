<?php
/**
 * Syga Rating Ajax Process Execution
 *
 * @package SygaRating
 *
 */

/**
 * Executing Ajax process.
 *
 * @since 1.0.0
 */

    /** Load WordPress Bootstrap */
    require_once( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/wp-load.php' );

    /** Allow for cross-domain requests (from the front end). */
    send_origin_headers();

    if( !isset($_GET['action']) && !isset($_POST['action']) ){
        wp_die("La variable action ne se trouve pas dans la requête ajax.", "Syga Rating Error");
    }

    global $sytemplates;
    if( !isset($sytemplates) ){
        require_once 'inc/templates.php';
    }

    global $syhelpers;
    if( !isset($syhelpers) ){
        require_once 'inc/helpers.php';
    }

    $action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];

    if( $action == 'comment-form' ){
        $vars = array(
            'post_id' => $_POST['post_id'],
            'index' => $_POST['index'],
            'min' => $_POST['min'],
            'max' => $_POST['max'],
            'title' => $_POST['title']
        );
        echo $sytemplates->load( 'templates/syga-rating-comment-form.php', $vars );
    }

    if( $action == 'add-comment' ){
        $vars = array(
            'post_id' => $_POST['post_id'],
            'index' => $_POST['index'],
            'note' => $_POST['note'],
            'comment' => $_POST['comment']
        );
        syga_rating_reload_template();
    }

?>