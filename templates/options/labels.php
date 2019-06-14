<div class="welcome-panel">
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
                    <label for="syga_rating_labels_feature">Caracteristiques du classement</label>
                </th>
                <td>
                    <input name="syga_rating_labels_feature" type="text" required id="syga_rating_labels_feature" value="<?php echo $syga_rating_labels['feature']; ?>" class="regular-text ltr">
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
<div class="welcome-panel">
    <h2>Affichage public</h2>
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="syga_rating_labels_title">Ajax formulaire</label>
                </th>
                <td>
                    <fieldset class="metabox-prefs" id="syga_rating_enable_ajax">
                        <label for="syga_rating_enable_ajax_input">
                            <input class="hide-postbox-tog" name="syga_rating_enable_ajax" type="checkbox" id="syga_rating_enable_ajax_input" value="true" <?php if ($syga_rating_enable_ajax === "true") echo ' checked="checked"'; ?>>Activé
                        </label>
                    </fieldset>
                </td>
            </tr>

        </tbody>
    </table>
</div>