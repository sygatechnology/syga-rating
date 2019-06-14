<tr id="syga-rating-form-tr-<?php echo $index; ?>">
    <td colspan="4">
        <form class="syga-rating-form" method="post" action="<?php echo plugins_url('templates/syga-rating-content.php', dirname( __FILE__ ) ); ?>" id="syga-rating-form-<?php echo $index; ?>">
            <p class="syga-rate-title"><?php echo $title; ?></p>
            <input type="hidden" name="action" value="add-comment" />
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>" />
            <input type="hidden" name="index" value="<?php echo $index; ?>" />
            <label for="syra-ionrange-<?php echo $index; ?>">Min: <?php echo $min; ?> - Max: <?php echo $max; ?></label>
            <input type="number" class="form-control" min="<?php echo $min; ?>" max="<?php echo $max; ?>" id="syra-ionrange-<?php echo $index; ?>" name="note" value="<?php echo $min; ?>" />

            <div class="syga-textarea-container">
                <textarea name="comment" placeholder="Une remarque sur la note que vous donnez?" class="form-control" maxlength="65525"></textarea>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-w-m btn-info syga-rating-submit-button">Envoyer</button>
            </div>
        </form>
    </td>
</tr>