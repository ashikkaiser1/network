
<div class="wrapper-page" style="margin: 3% auto" ng-app="loginPanle" ng-controller="UserLogin">
    <div class="panel panel-color 
    <?php
    $logo = '';
         if (defined("LOGO") && LOGO != '') {
             $logo = "padding-bottom: 0;";
         } else {
             echo ' panel-pink ';
         }
    ?>
         panel-pages">
        <div class="panel-heading" style="   <?php echo $logo ?>"> 
            <!--            <div class="bg-overlay"></div>-->
            <h3 class="text-center text-white text-uppercase">
                <?php if (defined("LOGO") && LOGO != '') {
                    ?>
                <img class="" width="300px" style="width: 90%" src="<?php echo @LOGO ?>">
                    <?php
                } else {
                    ?>
                    <strong><?php echo @SITENAME ?> </strong>
                <?php }
                ?>


            </h3>
        </div> 
        <div class="panel-body" style=" <?php echo $logo ?>">
            <form class="form-horizontal m-t-20" id="loginForm" method="post" ng-submit="login()">

                <div class="form-group">
                    <div class="col-xs-12">
                        <label>User ID/Email</label>

                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input class="form-control input-mini" type="text" name="username" ng-model="username" required="" placeholder="Username/Email ID" >
                        </div>





                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <label>Password</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                            <input class="form-control input-mini" type="password" name="password" ng-model="password" required="" placeholder="Password">
                        </div>

                    </div>
                </div>

                <div class="form-group m-t-20">
                    <div class="col-xs-5">
                        <div class="checkbox checkbox-primary">
                            <input id="checkbox-signup" type="checkbox">
                            <label for="checkbox-signup">
                                Remember me
                            </label>
                        </div>

                    </div>
                    <div class="col-xs-7">
                        <button class="btn pull-right btn-success btn-md w-md waves-effect waves-light" type="submit">
                            <span class="fa fa-unlock"></span>
                            {{LoginBtn}}</button>
                    </div>
                </div>

                <!--                <div class="form-group text-center ">
                                   
                                </div>-->

                <div class="form-group m-t-30"> 
                    <div class="col-sm-7">
                        <a href="<?php echo SITEURL . "account/account/forgotPasswordRequest"; ?>"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                    </div>
                    <!--                    <div class="col-sm-5 text-right">
                                            <a href="<?php echo SITEURL . "account/account/CreateAccountRequest"; ?>">Create an account</a>
                                        </div>-->
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="text-center">Create an Account</h4>
                            <div class="row">
                                <div class="col-md-2">

                                </div>
                                <div class="col-md-4">
                                    <a href="<?php echo SITEURL . "account/account/signup?in_for=2" ?>" class="col-md-12 text-center">I am Publisher</a>
                                </div>
                                <div class="col-md-4">
                                    <a href="<?php echo SITEURL . "account/account/signup?in_for=3" ?>" class="col-md-12 text-center">I am Advertiser</a>
                                </div>
                                <div class="col-md-2">

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form> 
        </div>                                 

    </div>


</div>


<script>
    $(function () {

        $('#loginForm').bootstrapValidator({
            message: false,
//            container: 'tooltip',
            trigger: 'blur',
            live: 'disable',
//            submitButtons: null,
            feedbackIcons: {
                // valid: 'glyphicon glyphicon-ok',
                // invalid: 'glyphicon glyphicon-remove',
                // validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                username: {// field name
                    validators: {
                        notEmpty: {
                            message: 'User Name/Email cannot be empty'
                        },
//                        regexp: {
//                            regexp: /^[a-zA-Z0-9\s]+$/,
//                            message: 'Invalid User Name'
//                        },
                        stringLength: {
                            min: 3,
                            max: 25,
                            message: 'User/Email name must be 3 to 25 characters long'
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
                            max: 20,
                            message: 'Password must be 6 to 20 characters long'
                        },
                    }
                }

            }

        }).on('success.form.bv', function (e) {
            e.preventDefault();
        });
    });</script>

<script>

    var login = angular.module("loginPanle", ['ui.bootstrap']);
    login.controller("UserLogin", function ($scope) {


        $scope.username = "";
        $scope.password = "";
        $scope.LoginBtn = "Log In";

        $scope.login = function () {

            if (!$("#loginForm").data('bootstrapValidator').validate().isValid())
            {

                return  false;
            }

            $scope.LoginBtn = "Processing";
            var form = $("#loginForm");
            var url = "<?php echo SITEURL . "account/account/oAuth" ?>";
            $.ajax({
                url: url,
                type: 'POST',
                data: form.serialize(),
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton center',
                                data['msg'],
                                '');
                        $.Notification.autoHideNotify('info',
                                'botton center',
                                "Redirecting....",
                                '');

                        window.location.href = data['redirectTo'];

                    } else
                    {
                        $.Notification.autoHideNotify('error',
                                'botton center',
                                data['msg'],
                                '');
                    }
                    $scope.LoginBtn = "Log In";
                    $scope.$apply();
                }
            });



        };



    });

</script>