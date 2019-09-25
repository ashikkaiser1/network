<!DOCTYPE html>
<html>
    <head>
        <title> <?php echo @SITENAME ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="<?php echo @FAVICON; ?>">
         <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <link href="<?php echo ASSETS; ?>plugins/notifications/notification.css" rel="stylesheet">
        <script   src="https://code.jquery.com/jquery-3.1.0.js"   integrity="sha256-slogkvB1K3VOkzAI8QITxV3VzpOnkeNVsKvtkYLMjfk="   crossorigin="anonymous"></script>
        <!-- Custom Files -->
        <link href="<?php echo ASSETS; ?>css/moltran.min.css" rel="stylesheet" type="text/css">

        <link href="<?php echo ASSETS; ?>plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
        <link href="<?php echo ASSETS; ?>vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
        <link href="<?php echo ASSETS; ?>vendor/bootstrapvalidator/dist/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <script src="<?php echo ASSETS; ?>js/angular.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
        <link href="<?php echo ASSETS; ?>vendor/select2/dist/css/select2.css" rel="stylesheet" type="text/css">
        <script src="<?php echo @PROTOCOL ?>://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.12.1.min.js"></script>

    </head>
    <body > 

        <?php 
        
        if(isset($PageContent))
            echo $PageContent;
        ?>
        

        <script>
            var resizefunc = [];
            // $('.datepicker').datepicker();
        </script>



        <!-- CUSTOM JS -->z
        <script src="<?php echo ASSETS; ?>js/moltran.min.js"></script>
        <script src="<?php echo ASSETS; ?>vendor/notifyjs/dist/notify.min.js"></script>
        <script src="<?php echo ASSETS; ?>plugins/notifications/notify-metro.js"></script>
        <script src="<?php echo ASSETS; ?>plugins/notifications/notifications.js"></script>
        <script src="<?php echo ASSETS; ?>plugins/timepicker/bootstrap-timepicker.min.js"></script>
        <script src="<?php echo ASSETS; ?>vendor/bootstrapvalidator/dist/js/bootstrapValidator.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo ASSETS; ?>vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
          <script src="<?php echo ASSETS; ?>vendor/select2/dist/js/select2.min.js" type="text/javascript"></script>
          
          
          
        <script>
            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
            });

            // Select2
            $(".select2").select2({
                width: '100%'
            });





</script>
    </body>
</html>