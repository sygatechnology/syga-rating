<?php 
    screen_icon();
    
?>
<div class="wrap">

    <h1>Configuration de Syga Rating</h1>
    <div class="welcome-panel">
        <h2>Options du type de poste personnalisé</h2>
        <form action="some-page.php" method="post">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label for="syga_rating_cpt_slug">Slug du type de poste personnalisé</label>
                        </th>
                        <td>
                            <input name="syga_rating_cpt_slug" type="text" require id="syga_rating_cpt_slug" value="<?php if(isset($syga_rating_cpt['slug'])) echo $syga_rating_cpt['slug']; ?>" class="regular-text ltr">
                            <br>
                            <i>Sans caractères spéciaux ni espace</i>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="syga_rating_cpt_name">Nom du type de poste personnalisé (en pluriel)</label>
                        </th>
                        <td>
                            <input name="syga_rating_cpt_name" type="text" require id="syga_rating_cpt_name" value="<?php if(isset($syga_rating_cpt['name'])) echo $syga_rating_cpt['name']; ?>" class="regular-text ltr">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="syga_rating_cpt_singular_name">Nom du type de poste personnalisé (en singulier)</label>
                        </th>
                        <td>
                            <input name="syga_rating_cpt_singular_name" type="text" require id="syga_rating_cpt_singular_name" value="<?php if(isset($syga_rating_cpt['singular_name'])) echo $syga_rating_cpt['singular_name']; ?>" class="regular-text ltr">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="syga_rating_cpt_menu_name">Nom pour le menu</label>
                        </th>
                        <td>
                            <input name="syga_rating_cpt_menu_name" type="text" require id="syga_rating_cpt_menu_name" value="<?php if(isset($syga_rating_cpt['menu_name'])) echo $syga_rating_cpt['menu_name']; ?>" class="regular-text ltr">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="syga_rating_cpt_supports">Supports</label>
                        </th>
                        <td>

                            <fieldset class="metabox-prefs" id="syga_rating_cpt_supports">

                                <label for="supports-title">
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
                                            <input class="hide-postbox-tog" name="syga_rating_cpt_taxonomies[]" type="checkbox" id="taxonomies-<?php echo $taxonomy->name; ?>" value="title" <?php echo $checked; ?>><?php echo $taxonomy->label; ?>
                                        </label>
                                <?php } } ?>
                            </fieldset>

                        </td>
                    </tr>
                </tbody>
            </table>

            <p class="submit">
                <input type="submit" value="Mettre à jour" class="button-primary" name="update">
            </p>
        </form>
    </div>

</div>