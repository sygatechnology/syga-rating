<div class="row">
    <div class="col-sm-12">
        <div id="syga-rating-list-container" class="syga-rating-list-container">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo $labels['title']; ?></h5>
                </div>
                <div class="ibox-content">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><?php echo $labels['feature']; ?></th>
                                <th><?php echo $labels['number']; ?></th>
                                <th><?php echo $labels['average']; ?></th>
                                <?php if(is_user_logged_in()) { ?>
                                    <th></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($rates as $index => $rate){ ?>
                            <tr id="syga-rating-tr-<?php echo $index; ?>">
                                <td><?php echo $rate->title; ?></td>
                                <td id="syga-number-<?php echo $index; ?>"><?php echo $rate->number; ?></td>
                                <td id="syga-average-<?php echo $index; ?>"><?php echo $rate->average.'/'.$rate->max; ?></td>
                                <?php if(is_user_logged_in()) { ?>
                                    <td id="syga-has-commented-<?php echo $index; ?>">
                                        <?php 
                                            if($syga_rating_enable_ajax == 'true'){
                                                echo ($rate->has_commented) ? '<i class="fa fa-check-square-o"></i>' : '<a data-index="'.$index.'" data-min="'.$rate->min.'" data-max="'.$rate->max.'" data-title="'.$rate->title.'" href="javascript:void(0);" id="syga-rate-'.$index.'" onclick="syga_load_comment_form('.$post_id.', '.$index.');"><i class="fa fa-pencil-square-o"></i></a>'; 
                                            } else {
                                                echo ($rate->has_commented) ? '<i class="fa fa-check-square-o"></i>' : '<a data-index="'.$index.'" data-min="'.$rate->min.'" data-max="'.$rate->max.'" data-title="'.$rate->title.'" href="'.plugins_url( 'syga-rating-content.php', __FILE__).'?post_id='.$post_id.'&index='.$index.'&min='.$rate->min.'&max='.$rate->max.'&title='.$rate->title.'" id="syga-rate-'.$index.'" onclick="syga_load_comment_form('.$post_id.', '.$index.');"><i class="fa fa-pencil-square-o"></i></a>'; 
                                            }
                                        ?>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>