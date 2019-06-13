<?php global $sytemplates; ?>
<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Syga Rating</title>
    <?php 
        sy_style( 'syga-ionRangeSlider-bootstrap-styles', plugins_url( '/assets/css/plugins/bootstrap.min.css', dirname( __FILE__ ) ) );
        sy_style( 'syga-ionRangeSlider-bootstrap-styles', plugins_url( '/assets/fonts/font-awesome/css/font-awesome.min.css', dirname( __FILE__ ) ) );
        sy_style( 'syga-ionRangeSlider-frontend-styles', plugins_url( '/assets/css/plugins/ionRangeSlider/ion.rangeSlider.css', dirname( __FILE__ ) ), '1.0.0' );
        sy_style( 'syga-ionRangeSlider-skin-frontend-styles', plugins_url( '/assets/css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css', dirname( __FILE__ ) ), '1.0.0' );
        sy_style( 'syga-frontend-styles', plugins_url( '/assets/css/syga-frontend.css' , dirname( __FILE__ ) ), '1.0.0' );
    ?>
</head>
<body>
    <script type="text/javascript">
        var syga_params = {
            "ajaxurl" : "<?php echo plugins_url( 'inc/ajax-request.php', dirname( __FILE__ ) ); ?>"
        };
    </script>