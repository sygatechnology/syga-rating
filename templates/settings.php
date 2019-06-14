<?php 

    $updated = FALSE;
    if( isset($_POST['actionhidden']) && isset($_POST['tab']) ) {
        $syga_rating_tax = array();
        $syga_rating_cpt = array();
        $syga_rating_labels = array();
        foreach($_POST as $key => $value){
            $tax_segment = explode("syga_rating_tax_", $key);
            if( count( $tax_segment ) === 2 ){
                $syga_rating_tax[$tax_segment[1]] = $value;
            }
            $cpt_segment = explode("syga_rating_cpt_", $key);
            if( count( $cpt_segment ) === 2 ){
                $syga_rating_cpt[$cpt_segment[1]] = $value;
            }
            $label_segment = explode("syga_rating_labels_", $key);
            if( count( $label_segment ) === 2 ){
                $syga_rating_labels[$label_segment[1]] = $value;
            }
        }
        global $syhelpers;

        if( $_POST['tab'] == 'tax-cfg' ) {
            $syra_tax = $syhelpers->_serialize( $syga_rating_tax );
            update_option( "syga_rating_tax", $syra_tax );
        }

        if( $_POST['tab'] == 'labels' ) {
            $syra_cpt = $syhelpers->_serialize( $syga_rating_cpt );
            update_option( "syga_rating_cpt", $syra_cpt );
        }

        if( $_POST['tab'] == 'cpt-cfg' ) {
            update_option( "syga_rating_labels", $syra_labels );
            $syra_labels = $syhelpers->_serialize( $syga_rating_labels );
            if( !isset($_POST['syga_rating_enable_ajax']) ) {
                $_POST['syga_rating_enable_ajax'] = "false";
            }
            update_option( "syga_rating_enable_ajax", $_POST['syga_rating_enable_ajax'] );
        }

        $updated = TRUE;
        unset($_POST);
    }

    screen_icon();

    $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'tax-cfg';

?>
<div class="wrap">

    <div id="icon-themes" class="icon32"></div>

    <h1>Configuration de Syga Rating</h1>

        <h2 class="nav-tab-wrapper">
            <a href="?page=syga-rating&tab=tax-cfg" class="nav-tab <?php echo $active_tab == 'tax-cfg' ? 'nav-tab-active' : ''; ?>">Options de taxonomie personnalisée</a>
            <a href="<?php echo ( isset($syga_rating_tax['slug']) && $syga_rating_tax['slug'] !== '' ) ? '?page=syga-rating&tab=labels' : 'javascript:void(0)';  ?>" class="nav-tab <?php echo $active_tab == 'labels' ? 'nav-tab-active' : ''; ?>">Libellés</a>
            <a href="<?php echo ( isset($syga_rating_tax['slug']) && $syga_rating_tax['slug'] !== '' ) ? '?page=syga-rating&tab=cpt-cfg' : 'javascript:void(0)';  ?>" class="nav-tab <?php echo $active_tab == 'cpt-cfg' ? 'nav-tab-active' : ''; ?>">Options de type de post personnalisé</a>
        </h2>

    <form action="<?php echo plugins_url( 'inc/request.php', dirname( __FILE__ ) ); ?>" method="post">
        <input type="hidden" name="actionhidden" value="<?php echo $actionhidden; ?>">
        <input type="hidden" name="tab" value="<?php echo $active_tab; ?>">
        
        <?php if( $updated ){ ?>
            <div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"> 
                <p>
                    <strong>Réglages enregistrés.</strong>
                </p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text">Ne pas tenir compte de ce message.</span>
                </button>
            </div>
        <?php } ?>

        <?php 
            syga_rating_display_options( $active_tab, array(
                "syga_rating_tax" => $syga_rating_tax,
                "syga_rating_cpt" => $syga_rating_cpt,
                "syga_rating_labels" => $syga_rating_labels
            ));
        ?>

        <p class="submit">
            <button type="submit" class="button-primary">Mettre à jour</button>
        </p>
    </form>
</div>