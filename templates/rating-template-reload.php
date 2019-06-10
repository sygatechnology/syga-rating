<div class="syga-rating-list-title">
    <h3>Avis</h3>
</div>
<table>
    <thead>
        <tr>
            <th>Sujet</th>
            <th>Nombre d'avis</th>
            <th>Note moyenne</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($rates as $index => $rate){ ?>
        <tr id="syga-rating-tr-<?php echo $index; ?>">
            <td><?php echo $rate->title; ?></td>
            <td id="syga-number-<?php echo $index; ?>"><?php echo $rate->number; ?></td>
            <td id="syga-average-<?php echo $index; ?>"><?php echo $rate->average.'/'.$rate->max; ?></td>
            <td id="syga-has-commented-<?php echo $index; ?>">
                <?php echo ($rate->has_commented) ? 'OK' : '<a data-index="'.$index.'" data-min="'.$rate->min.'" data-max="'.$rate->max.'" data-title="'.$rate->title.'" href="javascript:void(0);" id="syga-rate-'.$index.'" onclick="syga_load_comment_form('.$post_id.', '.$index.');">Mon avis</a>'; ?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
