
<div class="wrapper-page" ng-app="ForgetPasword" ng-controller="FogotPaaswordReq">
    <div class="panel panel-color panel-primary panel-pages">
        <div class="panel-heading"> 
            <div class=""></div>
            <h3 class="text-center m-t-10 text-white" style="font-size: 17px"> Please Type Email Associated With Account  <strong></strong> </h3>
        </div> 


        <div class="panel-body">
            <form class="form-horizontal m-t-20" id="ForgotPasswordRequestForm" ng-submit="forgotpassword()">

                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="input-group m-t-10">
                            <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                            <input class="form-control input-mini" type="text" name="in_email" ng-model="email" required="" placeholder="email@xyz.com">
                            
                        </div>

                        
                    </div>
                </div>
                <div class="form-group text-center m-t-40">
                    <div class="col-xs-12">


                        <button class="btn col-md-12 btn-purple btn-lg w-lg waves-effect waves-light" type="submit">{{LoginBtn}}</button>

                    </div>
                    <div class="col-md-12  m-t-40">
                        <a style="    margin: 0 0 0 7px;" href="<?php echo SITEURL ?>" class="btn btn-pink m-l-2 waves-effect waves-light pull-left">Login</a>
                        <a href="<?php echo SITEURL . "account/account/CreateAccountRequest" ?>" class="btn btn-success  m-l-2 waves-effect waves-light pull-right">New Account?</a>

                    </div>
                </div>


            </form> 
        </div>                                 

    </div>
</div>


<script>
    $(function () {

        $('#ForgotPasswordRequestForm').bootstrapValidator({
            message: false,
//            container: 'tooltip',
            trigger: 'blur',
            live: 'enabled',
//            submitButtons: null,
            feedbackIcons: {
                // valid: 'glyphicon glyphicon-ok',
                // invalid: 'glyphicon glyphicon-remove',
                // validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                in_email: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Email cannot be empty'
                        },
                        emailAddress: {
                            message: 'Invalid Email'
                        },
                        remote: {
                            url: '<?php echo SITEURL . "account/account/getEmail" ?>',
                            type: 'GET',
                            message: 'There is no account associated with this email.'
                        }
                    }
                },
            }

        }).on('success.form.bv', function (e) {
            e.preventDefault();
        });
    });</script>


<script>

    var forgotpassword = angular.module("ForgetPasword", []);
    forgotpassword.controller("FogotPaaswordReq", function ($scope) {


        $scope.email = "";

        $scope.LoginBtn = "Submit";

        $scope.forgotpassword = function () {


            if (!$("#ForgotPasswordRequestForm").data('bootstrapValidator').validate().isValid())
            {

                return  false;
            }


            $scope.LoginBtn = "Processing";
            var form = $("#ForgotPasswordRequestForm");
            var url = "<?php echo SITEURL . "account/account/forgotPasswordRequest" ?>";
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


                        // window.location.href = data['redirectTo'];

                    } else
                    {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                    }
                    $scope.LoginBtn = "Submit";
                    $scope.$apply();
                }
            });



        };



    });

</script>