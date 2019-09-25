
<div class="wrapper-page" ng-app="loginPanle" ng-controller="UserLogin">
    <div class="panel panel-color panel-primary panel-pages">
        <div class="panel-heading bg-img"> 
            <div class="bg-overlay"></div>
            <h3 class="text-center m-t-10 text-white"> WELCOME  <strong></strong> </h3>
        </div> 


        <div class="panel-body">
            <form class="form-horizontal m-t-20" id="loginForm" ng-submit="login()">

                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control input-lg" type="text" name="username" ng-model="username" required="" placeholder="Username">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control input-lg" type="password" name="password" ng-model="password" required="" placeholder="Password">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="checkbox checkbox-primary">
                            <input id="checkbox-signup" type="checkbox">
                            <label for="checkbox-signup">
                                Remember me
                            </label>
                        </div>

                    </div>
                </div>

                <div class="form-group text-center m-t-40">
                    <div class="col-xs-12">
                        <button class="btn btn-purple btn-lg w-lg waves-effect waves-light" type="submit">{{LoginBtn}}</button>
                    </div>
                </div>

                <div class="form-group m-t-30">
                    <div class="col-sm-7">
                        <a href="<?php echo SITEURL . "account/account/forgotPasswordRequest"; ?>"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                    </div>
                    <div class="col-sm-5 text-right">
                        <a href="<?php echo SITEURL . "account/account/CreateAccountRequest"; ?>">Create an account</a>
                    </div>
                </div>
            </form> 
        </div>                                 

    </div>
</div>




<script>

    var login = angular.module("loginPanle", []);
    login.controller("UserLogin", function ($scope) {


        $scope.username = "";
        $scope.password = "";
        $scope.LoginBtn = "Log In";

        $scope.login = function () {
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
                                'botton right',
                                data['msg'],
                                '');
                        $.Notification.autoHideNotify('info',
                                'botton right',
                                "Redirecting....",
                                '');

                        window.location.href = data['redirectTo'];

                    }
                    else
                    {
                        $.Notification.autoHideNotify('error',
                                'botton right',
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