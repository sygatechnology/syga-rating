<?php 
    /** Load WordPress Bootstrap */
    require_once( dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) . '/wp-load.php' );
    
    require_once 'header.php';

    if( isset($_GET['action']) && $_GET['action'] == 'list' ) {
        syga_rating_list( $_GET['post_id'] );
    } else {
        if( isset($_POST['action']) && $_POST['action'] == 'add-comment' ){
            global $syapi;
            $syapi->add_user_note( $_POST['post_id'], $_POST['index'], $_POST['note'], $_POST['comment'] );
            $url = plugins_url( 'syga-rating-content.php?action=list&post_id='.$_POST['post_id'], __FILE__ );
            header("Location: ".$url);
        }
        syga_rating_form( $_GET['post_id'], $_GET['index'], $_GET['min'], $_GET['max'], $_GET['title'] );
    }

    require_once 'footer.php';

?>
