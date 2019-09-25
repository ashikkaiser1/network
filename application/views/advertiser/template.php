<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="shortcut icon" href="<?php echo @FAVICON; ?>">

        <title> <?php echo @SITENAME ?></title>
        <!--        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">-->

        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <script   src="https://code.jquery.com/jquery-3.1.0.js"   integrity="sha256-slogkvB1K3VOkzAI8QITxV3VzpOnkeNVsKvtkYLMjfk="   crossorigin="anonymous"></script>
        <!--http://www.highcharts.com/lib/jquery-1.7.2.js-->
        <link href="<?php echo ASSETS; ?>plugins/notifications/notification.css" rel="stylesheet">
        <link href="<?php echo ASSETS; ?>css/custom.css" rel="stylesheet" type="text/css"/>


        <!-- Custom Files -->
        <link href="<?php echo ASSETS; ?>affiliate/moltran.min.css" rel="stylesheet" type="text/css">

        <link href="<?php echo ASSETS; ?>plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
        <link href="<?php echo ASSETS; ?>vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
        <link href="<?php echo ASSETS; ?>vendor/bootstrapvalidator/dist/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo ASSETS; ?>vendor/sweetalert/dist/sweetalert.css" rel="stylesheet" type="text/css"/>

        <link href="<?php echo ASSETS; ?>vendor/select2/dist/css/select2.css" rel="stylesheet" type="text/css">


        <script src="<?php echo ASSETS; ?>js/moment.min.js"></script>
        <link href="<?php echo ASSETS; ?>affiliate/custom.css" rel="stylesheet" type="text/css"/>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <link href="<?php echo ASSETS; ?>vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo ASSETS; ?>js/angular.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
        <script src="<?php echo @PROTOCOL ?>://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.12.1.min.js"></script>
        <script src="<?php echo ASSETS; ?>vendor/dropzone/new-js/dropzone.js" type="text/javascript"></script>
        <link href="<?php echo ASSETS ?>plugins/toggles/toggles.css" rel="stylesheet">
          <link href="<?php echo ASSETS; ?>affiliate/responsive.css" rel="stylesheet" type="text/css"/>
    </head>


    <script>
        var viral_pro = angular.module("viral_pro", ['ui.bootstrap']);
    </script>
    <body class="fixed-left" ng-app="viral_pro" ng-cloak >
        <div class="loader">Loading.....</div>
        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
               <div class="topbar hidden-lg">
                <!-- LOGO -->
                <div class="topbar-left hidden-xs">
                    <div class="text-center">
                        <a href="<?php echo SITEURL . "advertiser/dashboard/dashboard" ?>" class="logo"><i class="md"></i> 
                            <span><?php echo SITENAME; ?> </span></a>
                    </div>
                </div>
                <!-- Button mobile view to collapse sidebar menu -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <div class="">
                            <div class="pull-left">
                                <button class="button-menu-mobile open-left">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <span class="clearfix"></span>
                            </div>
                            <div class="pull-left hidden-lg">
                                <span class="MobileSiteTitle"><?php echo SITENAME; ?> </span>
                            </div>
                            
                            <!--                            <form class="navbar-form pull-left" role="search">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control search-bar" placeholder="Type here for search...">
                                                            </div>
                                                            <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
                                                        </form>-->

                            <ul class="nav navbar-nav navbar-right pull-right"  >

                                <?php //$this->load->view("affiliate/common/notification") ?>
                                <li class="hidden-xs">
                                    <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i class="md md-crop-free"></i></a>
                                </li>

                                <li class="dropdown">
                                    <a href="" class="dropdown-toggle profile" data-toggle="dropdown" aria-expanded="true"><img src="<?php echo ASSETS; ?>images/users/avatar-1.jpg" alt="user-img" class="img-circle"> </a>
                                    <ul class="dropdown-menu">
<!--                                        <li><a href="javascript:void(0)"><i class="md md-face-unlock"></i> Profile</a></li>-->
                                        <li><a href="<?php echo SITEURL . "advertiser/setting" ?>"><i class="md md-settings"></i> Settings</a></li>
                                        <li><a href="javascript:void(0)"><i class="md md-lock"></i> Lock screen</a></li>
                                        <li><a href="<?php echo SITEURL . "account/account/logout" ?>"><i class="md md-settings-power"></i> Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!--/.nav-collapse -->
                    </div>
                </div>
            </div>
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->

            <?php $this->load->view("advertiser/common/nav"); ?>
            <!-- Left Sidebar End --> 



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->                      
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">
                         <div class="m-t-40 hidden-lg col-md-12 col-sm-12 col-xs-12"></div>
                        <div class="m-t-40 hidden-lg col-md-12 col-sm-12 col-xs-12"></div>
                        <?php
                        //show the resultant page content
                        if (isset($PageContent))
                            echo $PageContent;
                        ?>
                    </div>
                </div>

                <!-- content -->

                <footer class="footer text-right">
                    2015 © <?php echo SITENAME ?>.
                </footer>

            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


            <!-- Right Sidebar -->
            <div class="side-bar right-bar nicescroll">
                <h4 class="text-center">Chat</h4>
                <div class="contact-list nicescroll">
                    <ul class="list-group contacts-list">
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="<?php echo ASSETS; ?>images/users/avatar-1.jpg" alt="">
                                </div>
                                <span class="name">Chadengle</span>
                                <i class="fa fa-circle online"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="<?php echo ASSETS; ?>images/users/avatar-2.jpg" alt="">
                                </div>
                                <span class="name">Tomaslau</span>
                                <i class="fa fa-circle online"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="<?php echo ASSETS; ?>images/users/avatar-3.jpg" alt="">
                                </div>
                                <span class="name">Stillnotdavid</span>
                                <i class="fa fa-circle online"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="<?php echo ASSETS; ?>images/users/avatar-4.jpg" alt="">
                                </div>
                                <span class="name">Kurafire</span>
                                <i class="fa fa-circle online"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="<?php echo ASSETS; ?>images/users/avatar-5.jpg" alt="">
                                </div>
                                <span class="name">Shahedk</span>
                                <i class="fa fa-circle away"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="<?php echo ASSETS; ?>images/users/avatar-6.jpg" alt="">
                                </div>
                                <span class="name">Adhamdannaway</span>
                                <i class="fa fa-circle away"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="<?php echo ASSETS; ?>images/users/avatar-7.jpg" alt="">
                                </div>
                                <span class="name">Ok</span>
                                <i class="fa fa-circle away"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="<?php echo ASSETS; ?>images/users/avatar-8.jpg" alt="">
                                </div>
                                <span class="name">Arashasghari</span>
                                <i class="fa fa-circle offline"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="<?php echo ASSETS; ?>images/users/avatar-9.jpg" alt="">
                                </div>
                                <span class="name">Joshaustin</span>
                                <i class="fa fa-circle offline"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                        <li class="list-group-item">
                            <a href="#">
                                <div class="avatar">
                                    <img src="<?php echo ASSETS; ?>images/users/avatar-10.jpg" alt="">
                                </div>
                                <span class="name">Sortino</span>
                                <i class="fa fa-circle offline"></i>
                            </a>
                            <span class="clearfix"></span>
                        </li>
                    </ul>  
                </div>
            </div>
            <!-- /Right-bar -->


        </div>
        <!-- END wrapper -->

        <script>
            var resizefunc = [];
            // $('.datepicker').datepicker();
        </script>

        <!-- CUSTOM JS -->
        <script src="<?php echo ASSETS; ?>js/moltran.min.js"></script>
        <script src="<?php echo ASSETS; ?>vendor/notifyjs/dist/notify.min.js"></script>
        <script src="<?php echo ASSETS; ?>plugins/notifications/notify-metro.js"></script>
        <script src="<?php echo ASSETS; ?>plugins/notifications/notifications.js"></script>
        <script src="<?php echo ASSETS; ?>plugins/timepicker/bootstrap-timepicker.min.js"></script>
        <script src="<?php echo ASSETS; ?>vendor/bootstrapvalidator/dist/js/bootstrapValidator.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo ASSETS; ?>vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script src="<?php echo ASSETS; ?>plugins/nestable/jquery.nestable.js"></script>
        <script src="<?php echo ASSETS; ?>pages/nestable.js"></script>
        <script src="<?php echo ASSETS; ?>vendor/sweetalert/dist/sweetalert.min.js" type="text/javascript"></script>
        <script src="<?php echo ASSETS; ?>vendor/select2/dist/js/select2.min.js" type="text/javascript"></script>

    </body>
</html>

<script>
           
            
             $(function () {
                $('.datepicker').datepicker({
                    format: 'dd-mm-yyyy',
                });

                // Select2
                $(".select2").select2({
                    width: '100%'
                });


                console.log("ready!");


                $('.campaign_id_select2').select2({
                    ajax: {
                        url: '<?php echo SITEURL . "admin/offer_utility/getOffersSearch" ?>',
                        dataType: 'json',
                        type: 'post',
                        processResults: function (data) {
                            // Tranforms the top-level key of the response object from 'items' to 'results'
                            return {
                                results: data.items
                            };
                        }
                        // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                    },
                    width: '100%'
                });
                
                
                //post vs campaign_ame
                
                 $('.post_id_select2').select2({
                    ajax: {
                        url: '<?php echo SITEURL . "admin/offer_utility/getPostOffersSearch" ?>',
                        dataType: 'json',
                        type: 'post',
                        processResults: function (data) {
                            // Tranforms the top-level key of the response object from 'items' to 'results'
                            return {
                                results: data.items
                            };
                        }
                        // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                    },
                    width: '100%'
                });
            });
            
</script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="<?php echo ASSETS; ?>vendor/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="<?php echo ASSETS ?>affiliate/bxslider/jquery.bxslider.js" type="text/javascript"></script>
<script>
            /**
             * (c) 2010-2017 Torstein Honsi
             *
             * License: www.highcharts.com/license
             * 
             * Grid-light theme for Highcharts JS
             * @author Torstein Honsi
             */

            'use strict';
            import Highcharts from '../parts/Globals.js';
                    /* global document */
// Load the fonts
                    Highcharts.createElement('link', {
                        href: 'https://fonts.googleapis.com/css?family=Dosis:400,600',
                        rel: 'stylesheet',
                        type: 'text/css'
                    }, null, document.getElementsByTagName('head')[0]);

            Highcharts.theme = {
                colors: ['#7cb5ec', '#f7a35c', '#90ee7e', '#7798BF', '#aaeeee', '#ff0066', '#eeaaee',
                    '#55BF3B', '#DF5353', '#7798BF', '#aaeeee'],
                chart: {
                    backgroundColor: null,
                    style: {
                        fontFamily: 'Dosis, sans-serif'
                    }
                },
                title: {
                    style: {
                        fontSize: '16px',
                        fontWeight: 'bold',
                        textTransform: 'uppercase'
                    }
                },
                tooltip: {
                    borderWidth: 0,
                    backgroundColor: 'rgba(219,219,216,0.8)',
                    shadow: false
                },
                legend: {
                    itemStyle: {
                        fontWeight: 'bold',
                        fontSize: '13px'
                    }
                },
                xAxis: {
                    gridLineWidth: 1,
                    labels: {
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                yAxis: {
                    minorTickInterval: 'auto',
                    title: {
                        style: {
                            textTransform: 'uppercase'
                        }
                    },
                    labels: {
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                plotOptions: {
                    candlestick: {
                        lineColor: '#404048'
                    }
                },
                // General
                background2: '#F0F0EA'

            };

// Apply the theme
            Highcharts.setOptions(Highcharts.theme);
</script>
<script src="<?php echo ASSETS ?>plugins/toggles/toggles.min.js"></script>