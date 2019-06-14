<div class="welcome-panel">
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="syga_rating_tax_slug">Slug de la taxonomie personnalisée</label>
                </th>
                <td>
                    <input name="syga_rating_tax_slug" type="text" required id="syga_rating_tax_slug" value="<?php if (isset($syga_rating_tax['slug'])) echo $syga_rating_tax['slug']; ?>" class="regular-text ltr">
                    <br>
                    <i>Sans caractères spéciaux ni espace</i>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="syga_rating_tax_name">Nom de la taxonomie personnalisée (en pluriel)</label>
                </th>
                <td>
                    <input name="syga_rating_tax_name" type="text" required id="syga_rating_tax_name" value="<?php if (isset($syga_rating_tax['name'])) echo $syga_rating_tax['name']; ?>" class="regular-text ltr">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="syga_rating_tax_singular_name">Nom de la taxonomie personnalisée (en singulier)</label>
                </th>
                <td>
                    <input name="syga_rating_tax_singular_name" type="text" required id="syga_rating_tax_singular_name" value="<?php if (isset($syga_rating_tax['singular_name'])) echo $syga_rating_tax['singular_name']; ?>" class="regular-text ltr">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="syga_rating_tax_menu_name">Nom pour le menu</label>
                </th>
                <td>
                    <input name="syga_rating_tax_menu_name" type="text" required id="syga_rating_tax_menu_name" value="<?php if (isset($syga_rating_tax['menu_name'])) echo $syga_rating_tax['menu_name']; ?>" class="regular-text ltr">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="syga_rating_tax_post_types">Types de poste à lier</label>
                </th>
                <td>

                    <fieldset class="metabox-prefs" id="syga_rating_tax_post_types">
                        <?php foreach (get_post_types('', 'objects') as $post_type) {
                                $checked = '';
                                if (isset($syga_rating_cpt['post_types']) && in_array($post_type->name, $syga_rating_cpt['post_types'])) {
                                    $checked = 'checked="checked"';
                                }
                        ?>
                                <label for="post_types-<?php echo $post_type->name; ?>">
                                    <input class="hide-postbox-tog" name="syga_rating_tax_post_types[]" type="checkbox" id="post_types-<?php echo $post_type->name; ?>" value="<?php echo $post_type->name; ?>" <?php echo $checked; ?>><?php echo $post_type->label; ?>
                                </label>
                        <?php  } ?>
                    </fieldset>

                </td>
            </tr>
        </tbody>
    </table>
</div>