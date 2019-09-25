
<div class="wrapper-page" ng-app="NewAccReq" ng-controller="AccRequest">
    <div class="panel panel-color panel-primary panel-pages">
        <div class="panel-heading bg-img"> 
            <div class="bg-overlay"></div>
            <h3 class="text-center m-t-10 text-white"> WELCOME  <strong></strong> </h3>
        </div> 


        <div class="panel-body">
            <form class="form-horizontal m-t-20" id="newAccountRequestForm" ng-submit="signupRequest()">

                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control input-lg" type="text" name="in_email" ng-model="email" required="" placeholder="email@xyz.com">
                    </div>
                </div>
                
                 <div class="form-group">
                    <div class="col-xs-12">
                        <select class="form-control input-lg" name="in_for">
                            <option value="2">Publisher</option>
                            <option value="3">Advertiser</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group text-center m-t-40">
                    <div class="col-xs-12">
                        <button id="requestBtn" class="btn btn-purple btn-lg w-lg waves-effect waves-light" type="submit">{{signupRequestBtn}}</button>
                    </div>
                </div>
                
                <h3 style="    color: green;    font-size: 18px;    text-align: center;">{{msg}}</h3>
                    


            </form> 
        </div>                                 

    </div>
</div>




<script>

    var signupRequest = angular.module("NewAccReq", []);
    signupRequest.controller("AccRequest", function ($scope) {


        $scope.email = "";

        $scope.signupRequestBtn = "SignUp";

        $scope.signupRequest = function () {
             $scope.msg='';
            $("#requestBtn").attr("disabled", "true");
            $scope.signupRequestBtn = "Processing";
            var form = $("#newAccountRequestForm");
            var url = "<?php echo SITEURL . "account/account/CreateAccountRequest" ?>";
            $.ajax({
                url: url,
                type: 'POST',
                data: form.serialize(),
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $("#requestBtn").removeAttr("disabled");
                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
                                
                       $scope.msg =   data['msg'];        


                        // window.location.href = data['redirectTo'];

                    }
                    else
                    {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                    }
                    $scope.signupRequestBtn = "Signup";
                    $scope.$apply();
                }
            });



        };



    });

</script>
