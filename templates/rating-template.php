<div id="<?php echo $id; ?>" class="<?php echo $class; ?>">
    <div class="syga-rating-list-title">
        <h3>Avis</h3>
    </div>
    <table>
        <thead>
            <tr>
                <th>Sujet</th>
                <th>Nombre d'avis</th>
                <th>Note moyenne</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($rates as $rate){ ?>
            <tr>
                <td><?php echo $rate->title; ?></td>
                <td><?php echo $rate->number; ?></td>
                <td><?php echo $rate->average; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>