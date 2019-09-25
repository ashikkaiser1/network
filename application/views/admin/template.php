<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="shortcut icon" href="<?php echo @FAVICON; ?>">

        <title> <?php echo @SITENAME ?></title>
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <script   src="https://code.jquery.com/jquery-3.1.0.js"   integrity="sha256-slogkvB1K3VOkzAI8QITxV3VzpOnkeNVsKvtkYLMjfk="   crossorigin="anonymous"></script>

        <link href="<?php echo ASSETS; ?>plugins/notifications/notification.css" rel="stylesheet">
        <link href="<?php echo ASSETS; ?>css/custom.css" rel="stylesheet" type="text/css"/>
        <!-- Custom Files -->
        <link href="<?php echo ASSETS; ?>css/moltran.min.css" rel="stylesheet" type="text/css">

        <link href="<?php echo ASSETS; ?>plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
        <link href="<?php echo ASSETS; ?>vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
        <link href="<?php echo ASSETS; ?>vendor/bootstrapvalidator/dist/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo ASSETS; ?>vendor/sweetalert/dist/sweetalert.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo ASSETS; ?>vendor/bootstrap-daterangepicker/moment.js" type="text/javascript"></script>
        <link href="<?php echo ASSETS; ?>vendor/select2/dist/css/select2.css" rel="stylesheet" type="text/css">
        <link href="<?php echo ASSETS; ?>vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css"/>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <script src="<?php echo ASSETS; ?>js/angular.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
        <script src="<?php echo @PROTOCOL ?>://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.12.1.min.js"></script>
        <script src="<?php echo ASSETS; ?>vendor/dropzone/new-js/dropzone.js" type="text/javascript"></script>



        <link href="<?php echo ASSETS ?>css/jquery-ui.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo ASSETS ?>autocomplete/jquery.easy-autocomplete.js" type="text/javascript"></script>
        <link href="<?php echo ASSETS ?>autocomplete/easy-autocomplete.min.css" rel="stylesheet" type="text/css"/>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

        <link href="<?php echo ASSETS ?>plugins/toggles/toggles.css" rel="stylesheet">




    </head>


    <script>

        var viral_pro = angular.module("viral_pro", ['ui.bootstrap']);

//        viral_pro.directive('ngLoading', function (Session, $compile) {
//
//            var loadingSpinner = "<i class='fa fa-spinner fa-pulse fa-3x fa-fw'></i>";
//
//            return {
//                restrict: 'A',
//                link: function (scope, element, attrs) {
//                    var originalContent = element.html();
//                    element.html(loadingSpinner);
//                    scope.$watch(attrs.ngLoading, function (val) {
//                        if (val) {
//                            element.html(originalContent);
//                            $compile(element.contents())(scope);
//                        } else {
//                            element.html(loadingSpinner);
//                        }
//                    });
//                }
//            };
//        });
    </script>
    <body class="fixed-left" ng-app="viral_pro" ng-cloak>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <div class="topbar">
                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
                        <a href="<?php echo SITEURL . "admin/dashboard/dashboard" ?>" class="logo"><i class="md"></i> 
                                 <span><?php echo SITENAME; ?> </span>
                        </a>
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
                            <!--                            <form class="navbar-form pull-left" role="search">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control search-bar" placeholder="Type here for search...">
                                                            </div>
                                                            <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
                                                        </form>-->

                            <ul class="nav navbar-nav navbar-right pull-right">
                                <!--                                <li class="dropdown hidden-xs">
                                                                    <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                                                                        <i class="md md-notifications"></i> <span class="badge badge-xs badge-danger">3</span>
                                                                    </a>
                                                                    <ul class="dropdown-menu dropdown-menu-lg">
                                                                        <li class="text-center notifi-title">Notification</li>
                                                                        <li class="list-group">
                                                                             list item
                                                                            <a href="javascript:void(0);" class="list-group-item">
                                                                                <div class="media">
                                                                                    <div class="pull-left">
                                                                                        <em class="fa fa-user-plus fa-2x text-info"></em>
                                                                                    </div>
                                                                                    <div class="media-body clearfix">
                                                                                        <div class="media-heading">New user registered</div>
                                                                                        <p class="m-0">
                                                                                            <small>You have 10 unread messages</small>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                             list item
                                                                            <a href="javascript:void(0);" class="list-group-item">
                                                                                <div class="media">
                                                                                    <div class="pull-left">
                                                                                        <em class="fa fa-diamond fa-2x text-primary"></em>
                                                                                    </div>
                                                                                    <div class="media-body clearfix">
                                                                                        <div class="media-heading">New settings</div>
                                                                                        <p class="m-0">
                                                                                            <small>There are new settings available</small>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                             list item
                                                                            <a href="javascript:void(0);" class="list-group-item">
                                                                                <div class="media">
                                                                                    <div class="pull-left">
                                                                                        <em class="fa fa-bell-o fa-2x text-danger"></em>
                                                                                    </div>
                                                                                    <div class="media-body clearfix">
                                                                                        <div class="media-heading">Updates</div>
                                                                                        <p class="m-0">
                                                                                            <small>There are
                                                                                                <span class="text-primary">2</span> new updates available</small>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                             last list item 
                                                                            <a href="javascript:void(0);" class="list-group-item">
                                                                                <small>See all notifications</small>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </li>-->
                                <li class="hidden-xs">
                                    <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i class="md md-crop-free"></i></a>
                                </li>
                                <!--                                <li class="hidden-xs">
                                                                    <a href="#" class="right-bar-toggle waves-effect waves-light"><i class="md md-chat"></i></a>
                                                                </li>-->
                                <?php $this->load->view("admin/common/notification") ?>
                                <li class="dropdown">
                                    <a href="" class="dropdown-toggle profile" data-toggle="dropdown" aria-expanded="true"><img src="<?php echo ASSETS; ?>images/users/avatar-1.jpg" alt="user-img" class="img-circle"> </a>
                                    <ul class="dropdown-menu">
<!--                                        <li><a href="javascript:void(0)"><i class="md md-face-unlock"></i> Profile</a></li>-->
                                        <li><a href="<?php echo SITEURL . "admin/setting/index" ?>"><i class="md md-settings"></i> Settings</a></li>
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

            <?php 
            if(UTID == ADMIN){
            $this->load->view("admin/common/nav");     
            }else
            {
                $this->load->view("admin/common/new_nav");     
            }
            ?>
            <!-- Left Sidebar End --> 



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->                      
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">
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

<script type="text/javascript" src="<?php echo ASSETS ?>plugins/jquery-multi-select/jquery.multi-select.js"></script>
<script type="text/javascript" src="<?php echo ASSETS ?>plugins/jquery-multi-select/jquery.quicksearch.js"></script>

<script src="<?php echo ASSETS ?>plugins/toggles/toggles.min.js"></script>
