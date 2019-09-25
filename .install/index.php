<html>


    <title>Installer</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript --> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <link href="css/custom.css" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css"/>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>

    <script src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.12.1.min.js"></script>

    <?php
//    echo '<pre>';
//    print_r($_SERVER);
    $protocol = '';
    $app_url = "";
    if (isset($_SERVER['HTTPS'])) {
        $protocol = "https";
    } else {
        $protocol = "http";
    }
    $app_url = $protocol . "://" . $_SERVER['SERVER_NAME'];
    ?>
    <body ng-app="adinstaller" ng-controller="adinstall" style="background-image: url('./img/BG.png');
          background-size: 356px;
          " >

        <h3 class="top_header" style="background-image: url('./img/headerbg.jpg')">

            Adserver Installer</h3>
        <div class="container">
            <div class="row">
                <div class="col-md-12 " >
                    <form id="installerForm" method="post" class="form-horizontal" ng-submit="install_start()">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <span></span>
                            <div class="panel panel-primary row">
                                <div class="panel-heading">
                                    <h4 class="text-uppercase">1.Network Setting
                                    </h4>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="col-md-12" >

                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="custom_label"  >Network Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control input-sm" name="SITENAME" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="custom_label"  >Url/Domain/Subdomain <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control input-sm"  name="SITEURL" value="<?php echo $app_url ?>">
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="custom_label"  >Protocol (http/https) <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control input-sm"  name="PROTOCOL" value="<?php echo $protocol ?>" >
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="custom_label"  >Timezone Name (Asia/Kolkata) <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control input-sm"  name="TIMEZONE" value="<?php echo date_default_timezone_get() ?>">
                                                </div>

                                            </div>



                                        </div>


                                    </div>
                                </div>




                            </div>





                            <div class="panel panel-primary row">
                                <div class="panel-heading">
                                    <h4 class="text-uppercase">2.Database Setting
                                    </h4>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="col-md-12" >
                                            <div class="form-group">
                                                <h4>Master Mysql Server Setting</h4>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="custom_label"  >Host <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control input-sm"  name="master_host" value="localhost" >
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="custom_label"  >Database Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control input-sm"  name="master_db" value="moremint_ytzmedia" >
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="custom_label"  >User <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control input-sm"  name="master_user" value="moremint_manish">
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="custom_label"  >password <span class="text-danger">*</span></label>
                                                    <input type="password" class="form-control input-sm" name="master_password" value="admin@123" >
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="custom_label"  class="text-sm">
                                                        <input ng-model="replication" type="checkbox" /> Mysql Server Replication ON? </label>
                                                </div>

                                            </div>

                                            <div ng-if="replication">
                                                <div class="form-group">
                                                    <h4>Slave Mysql Server Setting
                                                    </h4>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">

                                                        <label class="custom_label"  >Host <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control input-sm"  name="slave_host">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="custom_label"  >Database Name <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control input-sm"  name="slave_db" >

                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">

                                                        <label class="custom_label"  >User <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control input-sm" name="slave_user" >
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label class="custom_label"  >password <span class="text-danger">*</span></label>
                                                        <input type="password" class="form-control input-sm"   name="slave_password" >
                                                    </div>

                                                </div>
                                            </div>





                                        </div>
                                    </div>
                                </div>




                            </div>

                            <div class="panel panel-primary row">
                                <div class="panel-heading">
                                    <h4 class="text-uppercase">3.Administrator Account Setting
                                    </h4>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="col-md-12" >



                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="custom_label"  >Name<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control input-sm"  name="name" >    
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="custom_label"  >User ID <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control input-sm"  name="username" >
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="custom_label"  >Email <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control input-sm"  name="email" >
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="custom_label">Password <span class="text-danger">*</span></label>
                                                    <input type="password" class="form-control input-sm"  name="password" >    
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label class="custom_label"  >Confirm Password <span class="text-danger">*</span></label>
                                                    <input type="password" class="form-control input-sm"  name="re_password" >
                                                </div>

                                            </div>

                                            <div class="form-group">    
                                                <div class="col-md-12">
                                                    <button class="btn btn-success btn-sm" type="submit" name="install" >Install</button>
                                                    <button class="btn btn-danger btn-sm" type="reset">Cancel</button>    
                                                </div>

                                            </div> 




                                        </div>
                                    </div>
                                </div>




                            </div>
                        </div>
                    </form>

                </div>

            </div>





        </div>
    </body>
</html>

<div id="processingModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Installing</h4>
            </div>
            <div class="modal-body row">

                <div class="col-md-12">
                    <div class="progress-bar-success text-center" style="height: 20px; color: white;
                         border-radius: 8px;    transition: 0.2s; width: {{progress}}%">
                        <span class="text-white">{{progress| number : 2}}%</span>
                    </div>
                </div>
                <div class="col-md-12">
                    <h5 class="bg-success custom_success " ng-repeat="complete in completed">
                        {{complete}} 
                    </h5>                
                </div>
                <div class="col-md-12">
                    <h5 class="bg-danger custom_error " ng-repeat="error in errors">
                        {{error}} 
                    </h5>                
                </div>



            </div> 
        </div>

    </div>
</div>


<script>
    $(function () {

        $('#installerForm').bootstrapValidator({
            message: false,
//            container: 'tooltip',
//            trigger: 'blur',
//            live: 'disable',


//            submitButtons: null,
            feedbackIcons: {
//                 valid: 'glyphicon glyphicon-ok',
//                 invalid: 'glyphicon glyphicon-remove',
//                 validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                SITENAME: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Network Name cannot be empty'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9\s]+$/,
                            message: 'Invalid Network Name'
                        },
                        stringLength: {
                            min: 3,
                            max: 25,
                            message: 'Network Name must be 3 to 25 characters long'
                        }
                    }
                },
                SITEURL: {
                    validators: {
                        notEmpty: {
                            message: 'Address must not be empty'
                        },
                        uri: {
                            message: 'The address is not valid'
                        }
                    }
                },
                PROTOCOL: {
                    validators: {
                        notEmpty: {
                            message: 'Protocol must not be empty'
                        },
                    }

                },
                TIMEZONE: {
                    validators: {
                        notEmpty: {
                            message: 'Timezone must not be empty'
                        },
                    }

                },
                master_host: {
                    validators: {
                        notEmpty: {
                            message: 'Host must not be empty'
                        },
                    }

                },
                master_db: {
                    validators: {
                        notEmpty: {
                            message: 'Database Name must not be empty'
                        },
                    }

                },
                master_user: {
                    validators: {
                        notEmpty: {
                            message: 'Database User must not be empty'
                        },
                    }

                },
                name: {
                    validators: {
                        notEmpty: {
                            message: 'Administrator Name must not be empty'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z\s]+$/,
                            message: 'Invalid Administrator Name'
                        },
                        stringLength: {
                            min: 3,
                            max: 25,
                            message: 'Administrator Name must be 3 to 25 characters long'
                        }
                    }

                },
                username: {
                    validators: {
                        notEmpty: {
                            message: 'User Name must not be empty'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9\s]+$/,
                            message: 'Invalid User Name'
                        },
                        stringLength: {
                            min: 3,
                            max: 25,
                            message: 'User Name must be 3 to 25 characters long'
                        }
                    }


                },
                email: {
                    validators: {
                        notEmpty: {
                            message: 'Email must not be empty'
                        },

                        emailAddress: {
                            message: 'The vlaue is not a valid email address'
                        }
                    }
                },
                password: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Password cannot be empty'
                        },
                        stringLength: {
                            min: 6,
                            max: 10,
                            message: 'Password must be 6 to 10 characters long'
                        },
                    }
                },
                re_password: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Password cannot be empty'
                        },
                        identical: {
                            field: 'password',
                            message: 'The password and its confirm are not the same'
                        }



                    }
                }
            }

        }).on('success.form.bv', function (e) {
            e.preventDefault();
        });
    });
</script>

<script>

    var adinstaller = angular.module("adinstaller", ['ui.bootstrap']);
    adinstaller.controller("adinstall", function ($scope) {
        $scope.FormData = {};
        $scope.errors = {};
        $scope.completed = [];

        //processbar vars
        $scope.progress = 0;
        $scope.totalstep = 4;
        //end of progressbar vars

        $scope.install_start = function () {

//            installerForm

//            console.log($("#installerForm"));
            if (!$("#installerForm").data('bootstrapValidator').validate().isValid())
            {

//                alert("Error");
                return  false;
            }

//            return  false;

            $scope.errors = {};
            $scope.completed = [];
            $("#processingModal").modal('show');

            $scope.FormData = $("#installerForm").serialize();

            //STEP 1 Checking MYsql Connection 
            $scope.check_mysql_connection();

        };
        $scope.change_progress = function (current_step) {
            var progress = (100 / $scope.totalstep) * current_step;
            $scope.progress = progress;
        };

        $scope.check_mysql_connection = function () {
            $("#processingModal").modal('show');
            //STEP 1 Checking MYsql Connection 
            $.ajax({
                url: "./installer.php?step=1",
                type: 'POST',
                data: $scope.FormData,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success']) {
                        $scope.change_progress(1);
                        $scope.completed.push(data['msg']);
                        //got to next step
                        //Start Step 2
                        $scope.create_tables();
                    } else
                    {
                        $scope.errors.push = data['msg'];
                    }
                    $scope.$apply();
                }
            });
        };

        $scope.create_tables = function () {
            $("#processingModal").modal('show');
            //STEP 2 Create the tables in database
            $.ajax({
                url: "./installer.php?step=2",
                type: 'POST',
                data: $scope.FormData,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success']) {
                        $scope.change_progress(2);
                        $scope.completed.push(data['msg']);
                        //got to next step
                        //Start Step 3
                        $scope.save_network_settings();
                    } else
                    {
                        $scope.errors.push = data['msg'];
                    }
                    $scope.$apply();
                }
            });
        };


        $scope.save_network_settings = function () {
            $("#processingModal").modal('show');
            //STEP 3 Save the internet setting.......
            $.ajax({
                url: "./installer.php?step=3",
                type: 'POST',
                data: $scope.FormData,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success']) {
                        $scope.change_progress(3);
                        $scope.completed.push(data['msg']);
                        //got to next step
                        //Start Step 4
                        $scope.save_user_account();
                    } else
                    {
                        $scope.errors.push = data['msg'];
                    }
                    $scope.$apply();
                }
            });
        };

        $scope.save_user_account = function () {
            $("#processingModal").modal('show');
            //STEP 4 Save the user account setting.......
            $.ajax({
                url: "./installer.php?step=4",
                type: 'POST',
                data: $scope.FormData,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success']) {
                        $scope.change_progress(4);
                        $scope.completed.push(data['msg']);
                        //got to next step
                        //Start Step 4
                    } else
                    {
                        $scope.errors.push = data['msg'];
                    }
                    $scope.$apply();
                }
            });
        };


//        $scope.FormErrors = [];
//        $scope.validateForm = function(){
//          
//          if($scope)
//          
//          
//          
//            
//        };

    });

</script>

