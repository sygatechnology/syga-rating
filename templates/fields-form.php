<div class="syga-fields-form-container" id="syga-fields-form-<?php echo $position; ?>">
    <input type="hidden" class="syga-fields-position" value="<?php echo $position; ?>">
    <div class="syga-remove-fields-form-container align-right">
        <a href="javascript:void(0);" onclick="syga_remove_fields_form_<?php echo $position; ?>();" class="syga-remove-fields-form-button" data-position="'.$position.'">Supprimer</a>
    </div>
    <div class="syga-fields-form-group">
        <table>
            <tbody>
                <tr>
                    <td colspan="2" class="syga-field-title">
                        <label for="syga_rating_input[<?php echo $position; ?>][title]">
                            <?php echo $title; ?>
                        </label>
                        <input type="text" name="syga_rating_input[<?php echo $position; ?>][title]" id="syga_rating_input[<?php echo $position; ?>][title]" value="<?php echo $rate['title']; ?>">
                    </td>
                </tr>
                <tr>
                    <td class="syga-field-min">
                        <label for="syga_rating_input[<?php echo $position; ?>][min]">
                            Valeur minimale
                        </label>
                        <input type="text" name="syga_rating_input[<?php echo $position; ?>][min]" id="syga_rating_input[<?php echo $position; ?>][min]" min="1" value="<?php echo $rate['min']; ?>">
                    </td>
                    <td class="syga-field-max">
                        <label for="syga_rating_input[<?php echo $position; ?>][max]">
                            Valeur maximale
                        </label>
                        <input type="text" name="syga_rating_input[<?php echo $position; ?>][max]" id="syga_rating_input[<?php echo $position; ?>][max]" min="2" value="<?php echo $rate['max']; ?>">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <script type="text/javascript">
        function syga_remove_fields_form_<?php echo $position; ?>(){
            if(confirm("Êtes-vous sûr de supprimer ces éléménts?")){
                jQuery("#syga-fields-form-<?php echo $position; ?>").remove();
            } else {
                event.preventDefault();
                return false;
            }
        }
    </script>
</div>