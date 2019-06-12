<?php 
<<<<<<< HEAD
    
    $updated = FALSE;
    if( isset($_POST['actionhidden']) ) {
        $syga_rating_cpt = array();
        $syga_rating_labels = array();
        foreach($_POST as $key => $value){
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
        $syra_cpt = $syhelpers->_serialize( $syga_rating_cpt );
        $syra_labels = $syhelpers->_serialize( $syga_rating_labels );
        update_option( "syga_rating_cpt", $syra_cpt );
        update_option( "syga_rating_labels", $syra_labels );
        $updated = TRUE;
    }

=======
>>>>>>> ba9dc10c2cee0f45fe1708a6ab543da56c30d863
    screen_icon();
    
?>
<div class="wrap">
<<<<<<< HEAD
    <form action="<?php echo admin_url( 'options-general.php?page=syga-rating' ); ?>" method="post">
        <input type="hidden" name="actionhidden" value="<?php echo $actionhidden; ?>">
        <h1>Configuration de Syga Rating</h1>
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

        <div class="welcome-panel">
            <h2>Options du type de poste personnalisé</h2>
=======

    <h1>Configuration de Syga Rating</h1>
    <div class="welcome-panel">
        <h2>Options du type de poste personnalisé</h2>
        <form action="some-page.php" method="post">
>>>>>>> ba9dc10c2cee0f45fe1708a6ab543da56c30d863
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label for="syga_rating_cpt_slug">Slug du type de poste personnalisé</label>
                        </th>
                        <td>
<<<<<<< HEAD
                            <input name="syga_rating_cpt_slug" type="text" required id="syga_rating_cpt_slug" value="<?php if(isset($syga_rating_cpt['slug'])) echo $syga_rating_cpt['slug']; ?>" class="regular-text ltr">
=======
                            <input name="syga_rating_cpt_slug" type="text" require id="syga_rating_cpt_slug" value="<?php if(isset($syga_rating_cpt['slug'])) echo $syga_rating_cpt['slug']; ?>" class="regular-text ltr">
>>>>>>> ba9dc10c2cee0f45fe1708a6ab543da56c30d863
                            <br>
                            <i>Sans caractères spéciaux ni espace</i>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="syga_rating_cpt_name">Nom du type de poste personnalisé (en pluriel)</label>
                        </th>
                        <td>
<<<<<<< HEAD
                            <input name="syga_rating_cpt_name" type="text" required id="syga_rating_cpt_name" value="<?php if(isset($syga_rating_cpt['name'])) echo $syga_rating_cpt['name']; ?>" class="regular-text ltr">
=======
                            <input name="syga_rating_cpt_name" type="text" require id="syga_rating_cpt_name" value="<?php if(isset($syga_rating_cpt['name'])) echo $syga_rating_cpt['name']; ?>" class="regular-text ltr">
>>>>>>> ba9dc10c2cee0f45fe1708a6ab543da56c30d863
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="syga_rating_cpt_singular_name">Nom du type de poste personnalisé (en singulier)</label>
                        </th>
                        <td>
<<<<<<< HEAD
                            <input name="syga_rating_cpt_singular_name" type="text" required id="syga_rating_cpt_singular_name" value="<?php if(isset($syga_rating_cpt['singular_name'])) echo $syga_rating_cpt['singular_name']; ?>" class="regular-text ltr">
=======
                            <input name="syga_rating_cpt_singular_name" type="text" require id="syga_rating_cpt_singular_name" value="<?php if(isset($syga_rating_cpt['singular_name'])) echo $syga_rating_cpt['singular_name']; ?>" class="regular-text ltr">
>>>>>>> ba9dc10c2cee0f45fe1708a6ab543da56c30d863
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="syga_rating_cpt_menu_name">Nom pour le menu</label>
                        </th>
                        <td>
<<<<<<< HEAD
                            <input name="syga_rating_cpt_menu_name" type="text" required id="syga_rating_cpt_menu_name" value="<?php if(isset($syga_rating_cpt['menu_name'])) echo $syga_rating_cpt['menu_name']; ?>" class="regular-text ltr">
=======
                            <input name="syga_rating_cpt_menu_name" type="text" require id="syga_rating_cpt_menu_name" value="<?php if(isset($syga_rating_cpt['menu_name'])) echo $syga_rating_cpt['menu_name']; ?>" class="regular-text ltr">
>>>>>>> ba9dc10c2cee0f45fe1708a6ab543da56c30d863
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="syga_rating_cpt_supports">Supports</label>
                        </th>
                        <td>

                            <fieldset class="metabox-prefs" id="syga_rating_cpt_supports">

                                <label for="supports-title">
<<<<<<< HEAD
                                    <input class="hide-postbox-tog" name="syga_rating_cpt_supports[]" type="checkbox" id="supports-title" value="title" <?php if(in_array('title', $syga_rating_cpt['supports'])) echo ' checked="checked"'; ?>>Titre
                                </label>
                                <label for="supports-editor">
                                    <input class="hide-postbox-tog" name="syga_rating_cpt_supports[]" type="checkbox" id="supports-editor" value="editor" <?php if(in_array('editor', $syga_rating_cpt['supports'])) echo ' checked="checked"'; ?>>Editeur
                                </label>
                                <label for="supports-excerpt">
                                    <input class="hide-postbox-tog" name="syga_rating_cpt_supports[]" type="checkbox" id="supports-excerpt" value="excerpt" <?php if(in_array('excerpt', $syga_rating_cpt['supports'])) echo ' checked="checked"'; ?>>Extrait
                                </label>
                                <label for="supports-thumbnail">
                                    <input class="hide-postbox-tog" name="syga_rating_cpt_supports[]" type="checkbox" id="supports-thumbnail" value="thumbnail" <?php if(in_array('thumbnail', $syga_rating_cpt['supports'])) echo ' checked="checked"'; ?>>Image mise en avant
                                </label>
                                <label for="supports-comments">
                                    <input class="hide-postbox-tog" name="syga_rating_cpt_supports[]" type="checkbox" id="supports-comments" value="comments" <?php if(in_array('comments', $syga_rating_cpt['supports'])) echo ' checked="checked"'; ?>>Commentaires
                                </label>
                                <label for="supports-revisions">
                                    <input class="hide-postbox-tog" name="syga_rating_cpt_supports[]" type="checkbox" id="supports-revisions" value="revisions" <?php if(in_array('revisions', $syga_rating_cpt['supports'])) echo ' checked="checked"'; ?>>Revisions
                                </label>
                                <label for="supports-author">
                                    <input class="hide-postbox-tog" name="syga_rating_cpt_supports[]" type="checkbox" id="supports-author" value="author" <?php if(in_array('author', $syga_rating_cpt['supports'])) echo ' checked="checked"'; ?>>Auteur
=======
                                    <input class="hide-postbox-tog" name="syga_rating_cpt_supports[]" type="checkbox" id="supports-title" value="title" <?php if(isset($syga_rating_cpt['supports']['title'])) echo ' checked="checked"'; ?>>Titre
                                </label>
                                <label for="supports-editor">
                                    <input class="hide-postbox-tog" name="syga_rating_cpt_supports[]" type="checkbox" id="supports-editor" value="editor" <?php if(isset($syga_rating_cpt['supports']['editor'])) echo ' checked="checked"'; ?>>Editeur
                                </label>
                                <label for="supports-excerpt">
                                    <input class="hide-postbox-tog" name="syga_rating_cpt_supports[]" type="checkbox" id="supports-excerpt" value="excerpt" <?php if(isset($syga_rating_cpt['supports']['excerpt'])) echo ' checked="checked"'; ?>>Extrait
                                </label>
                                <label for="supports-thumbnail">
                                    <input class="hide-postbox-tog" name="syga_rating_cpt_supports[]" type="checkbox" id="supports-thumbnail" value="thumbnail" <?php if(isset($syga_rating_cpt['supports']['thumbnail'])) echo ' checked="checked"'; ?>>Image mise en avant
                                </label>
                                <label for="supports-comments">
                                    <input class="hide-postbox-tog" name="syga_rating_cpt_supports[]" type="checkbox" id="supports-comments" value="comments" <?php if(isset($syga_rating_cpt['supports']['comments'])) echo ' checked="checked"'; ?>>Commentaires
                                </label>
                                <label for="supports-revisions">
                                    <input class="hide-postbox-tog" name="syga_rating_cpt_supports[]" type="checkbox" id="supports-revisions" value="revisions" <?php if(isset($syga_rating_cpt['supports']['revisions'])) echo ' checked="checked"'; ?>>Revisions
                                </label>
                                <label for="supports-author">
                                    <input class="hide-postbox-tog" name="syga_rating_cpt_supports[]" type="checkbox" id="supports-author" value="author" <?php if(isset($syga_rating_cpt['supports']['author'])) echo ' checked="checked"'; ?>>Auteur
>>>>>>> ba9dc10c2cee0f45fe1708a6ab543da56c30d863
                                </label>
                                
                            </fieldset>

                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="syga_rating_cpt_taxonomies">Taxonomies liées</label>
                        </th>
                        <td>

                            <fieldset class="metabox-prefs" id="syga_rating_cpt_taxonomies">
                                <?php foreach( get_taxonomies('', 'objects') as $taxonomy ){
                                    if( $taxonomy->name != 'nav_menu' && $taxonomy->name != 'link_category' && $taxonomy->name != 'post_format' ){
                                        $checked = '';
                                        if( isset($syga_rating_cpt['taxonomies']) && in_array($taxonomy->name, $syga_rating_cpt['taxonomies']) ) {
                                                $checked = 'checked="checked"';
                                        }
                                ?>
                                        <label for="taxonomies-<?php echo $taxonomy->name; ?>">
<<<<<<< HEAD
                                            <input class="hide-postbox-tog" name="syga_rating_cpt_taxonomies[]" type="checkbox" id="taxonomies-<?php echo $taxonomy->name; ?>" value="<?php echo $taxonomy->name; ?>" <?php echo $checked; ?>><?php echo $taxonomy->label; ?>
=======
                                            <input class="hide-postbox-tog" name="syga_rating_cpt_taxonomies[]" type="checkbox" id="taxonomies-<?php echo $taxonomy->name; ?>" value="title" <?php echo $checked; ?>><?php echo $taxonomy->label; ?>
>>>>>>> ba9dc10c2cee0f45fe1708a6ab543da56c30d863
                                        </label>
                                <?php } } ?>
                            </fieldset>

                        </td>
                    </tr>
                </tbody>
            </table>
<<<<<<< HEAD
        </div>

        <div class="welcome-panel">
            <h2>Libellés</h2>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label for="syga_rating_labels_title">Titre du classement</label>
                        </th>
                        <td>
                            <input name="syga_rating_labels_title" type="text" required id="syga_rating_labels_title" value="<?php echo $syga_rating_labels['title']; ?>" class="regular-text ltr">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="syga_rating_labels_caracteristic">Caracteristiques du classement</label>
                        </th>
                        <td>
                            <input name="syga_rating_labels_caracteristic" type="text" required id="syga_rating_labels_caracteristic" value="<?php echo $syga_rating_labels['caracteristic']; ?>" class="regular-text ltr">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="syga_rating_labels_number">Nombre de votes</label>
                        </th>
                        <td>
                            <input name="syga_rating_labels_number" type="text" required id="syga_rating_labels_number" value="<?php echo $syga_rating_labels['number']; ?>" class="regular-text ltr">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="syga_rating_labels_average">Moyenne des votes</label>
                        </th>
                        <td>
                            <input name="syga_rating_labels_average" type="text" required id="syga_rating_labels_average" value="<?php echo $syga_rating_labels['average']; ?>" class="regular-text ltr">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <p class="submit">
            <button type="submit" class="button-primary">Mettre à jour</button>
        </p>
    </form>
=======

            <p class="submit">
                <input type="submit" value="Mettre à jour" class="button-primary" name="update">
            </p>
        </form>
    </div>

>>>>>>> ba9dc10c2cee0f45fe1708a6ab543da56c30d863
</div>