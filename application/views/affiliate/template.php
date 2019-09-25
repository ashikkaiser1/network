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
<!-- Bootstrap Core CSS -->
    <link href="<?php echo ASSETS; ?>new/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Morries chart CSS -->
    <link href="<?php echo ASSETS; ?>new/assets/plugins/morrisjs/morris.css" rel="stylesheet">
        <link href="<?php echo ASSETS; ?>new/assets/plugins/icheck/skins/all.css" rel="stylesheet">

    
    
    <!-- Custom CSS -->
    <link href="<?php echo ASSETS; ?>new/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="<?php echo ASSETS; ?>new/css/colors/blue.css" id="theme" rel="stylesheet">

        <!-- Custom Files -->

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
    </head>


    <script>
        var viral_pro = angular.module("viral_pro", ['ui.bootstrap']);
    </script>
    <body class="fix-header fix-sidebar card-no-border" ng-app="viral_pro" ng-cloak >
       
        <!-- Begin page -->
       <div id="main-wrapper">

            <!-- Top Bar Start -->
            <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- LOGO -->
             <div class="navbar-header">
              <a href="<?php echo SITEURL . "affiliate/dashboard" ?>" class="navbar-brand"><i class="md"></i> 
                            <span><?php echo SITENAME; ?> </span></a>
                </div>
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown" id="App2" ng-controller="noti_controller">
                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-message"></i>
                                <div class="notify"> <span class="heartbit">Notifications</span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu mailbox animated slideInUp">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                       
   
         
       <div class="alert alert-success" ng-repeat="noti in notification"> 
                          <div class="media-heading"><i class="fa fa-exclamation-circle"></i>{{noti.title}}</div>  
                           
                        </a>

<script>


    // var notification = angular.module("viral_pro",['ui.bootstrap']);
// var notification = angular.module("viral_pro",['ui.bootstrap']);
    viral_pro.filter("trustUrl", ['$sce', function ($sce) {
            return function (recordingUrl) {
                return $sce.trustAsResourceUrl(recordingUrl);
            };
        }]);
    viral_pro.controller("noti_controller", function ($scope, $sce, $interval) {

        //alert("hi");
        $scope.totla_new_noti = 0;
        $scope.notification = {};

        $scope.getNewNotification_count = function ()
        {
            $.ajax({
                url: "<?php echo SITEURL . "notif/notification/count_new_notification" ?>",
                type: 'POST',
                data: "getNot=1",
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
//                        $scope.notification = data['notification'];
                        if (data['new_notification'] !== "0")
                        {
                            $scope.totla_new_noti = data['new_notification'];
                            console.log("NOti");
                            $scope.$apply();
                        }

                    }
                }
            });
        };

        $scope.getNotification = function () {
            $.ajax({
                url: "<?php echo SITEURL . "notif/notification/getNotification" ?>",
                type: 'POST',
                data: "getNot=1",
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $scope.notification = data['notification'];
                        // $scope.totla_new_noti = data['new_notification'];
                        $scope.$apply();
                    }
                }
            });
        };
        $interval($scope.getNewNotification_count, 10000);


        $scope.sub_des = function (desc)
        {
            return desc.substring(0, 30);
        };

        $scope.readNotification = function ()
        {

            $.ajax({
                url: "<?php echo SITEURL . "notif/notification/i_read_notification" ?>",
                type: 'POST',
                data: "getNot=1",
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $scope.totla_new_noti = data['new_notification'];
                        $scope.$apply();
                        $scope.getNotification();
                    }
                }
            });


        };
        $scope.reder_html = function (html) {


            return $sce.trustAsHtml(html);

        };








        $scope.getNotification();
        $scope.getNewNotification_count();

    });
    // angular.bootstrap(document.getElementById("App2"), ['notification']);
    // angular.bootstrap(document.getElementById("App2"), ['notification']);
</script>
                                            
                                     </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="<?php echo SITEURL."affiliate/dashboard/updates" ?>"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->
                       
                       
                       
                       
                        
                    </ul>
                    <ul class="navbar-nav my-lg-0">
                      <style>
 .account-manager {
    font-size: 11.5px;
    margin-right: 14px;
    color: hsla(0,0%,100%,.93);
    text-align: right;
    letter-spacing: .5px;
}
.layout-column {
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -webkit-flex-direction: column;
    flex-direction: column;
}
.layout, .layout-column, .layout-row {
    box-sizing: border-box;
    display: -webkit-box;
    display: -webkit-flex;
    display: flex;
}
.layout-align-start-center > *, .layout-align-center-center > *, .layout-align-end-center > *, .layout-align-space-between-center > *, .layout-align-space-around-center > * {
    max-width: 100%;
    box-sizing: border-box;
}
user agent stylesheet
div {
    display: block;
}
.layout-row {
    -webkit-box-orient: horizontal;
    -webkit-box-direction: normal;
    -webkit-flex-direction: row;
    flex-direction: row;
}
.layout-row {
    -webkit-box-orient: horizontal;
    -webkit-box-direction: normal;
    -webkit-flex-direction: row;
    flex-direction: row;
}
 
                      </style>
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        
    <div layout="column" ng-controller="aff_manager" style ="font-size: 11.5px;
    margin-right: 14px;
    color: hsla(0,0%,100%,.93);
    text-align: right;
    letter-spacing: .5px;" class="account-manager layout-column thin"  >
      
      <span style="font-size: 11.5px;font-variant: small-caps;
    letter-spacing: .75px;
     letter-spacing: .5px;
     border-bottom: 1px solid hsla(0,0%,100%,.45);
    font-weight: 500;">Account Manager</span>
      <span ng-if="aff_info == ''">............</span>
      <span ng-if="aff_info.name != ''">{{aff_info.name}}</span>
      <span ng-if="aff_info.email != ''"><a href="mailto:{{aff_info.email}}">{{aff_info.email}}</a></span>
      <span ng-if="aff_info.skype_id != ''">Skype : {{aff_info.skype_id}}</span>
    </div>
     
     
    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo ASSETS; ?>images/users/avatar-1.jpg" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="<?php echo ASSETS; ?>images/users/avatar-1.jpg" alt="user"></div>
                                            <div class="u-text">
                                                <h4><?php echo UserTitle ?></h4><br>
                                                <a href="javascript:void(0);" class="btn btn-rounded btn-danger btn-sm"><?php echo USERTYPE; ?></a></div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?php echo SITEURL . "affiliate/setting" ?>"><i class="ti-user"></i> My Profile</a></li>
                                    <li role="separator" class="divider"></li>
                                    
                                    <li><a href="<?php echo SITEURL . "account/account/logout" ?>"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
  </div>
                    </ul>
                </div>
            </nav>
        </header>
          


            <!-- ========== Left Sidebar Start ========== -->

            <?php $this->load->view("affiliate/common/nav"); ?>
            <!-- Left Sidebar End --> 



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


           

        </div>
        <!-- END wrapper -->

        <script>
            var resizefunc = [];
            // $('.datepicker').datepicker();
        </script>

        <!-- CUSTOM JS -->
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
            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
            });

            // Select2
            $(".select2").select2({
                width: '100%'
            });
</script>

    <!-- Bootstrap tether Core JavaScript -->
        <script src="<?php echo ASSETS; ?>new/assets/plugins/jquery/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="<?php echo ASSETS; ?>new/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?php echo ASSETS; ?>new/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="<?php echo ASSETS; ?>new/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?php echo ASSETS; ?>new/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="<?php echo ASSETS; ?>new/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="<?php echo ASSETS; ?>new/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="<?php echo ASSETS; ?>new/js/custom.min.js"></script>
    <script src="<?php echo ASSETS; ?>new/assets/plugins/icheck/icheck.min.js"></script>
    <script src="<?php echo ASSETS; ?>new/assets/plugins/icheck/icheck.init.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!--morris JavaScript -->
    <script src="<?php echo ASSETS; ?>new/assets/plugins/raphael/raphael-min.js"></script>
    <!-- sparkline chart -->
    <script src="<?php echo ASSETS; ?>new/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <script src="<?php echo ASSETS; ?>new/js/dashboard4.js"></script>
        <script src="<?php echo ASSETS; ?>new/assets/plugins/datatables/jquery.dataTables.min.js"></script>

    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->

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