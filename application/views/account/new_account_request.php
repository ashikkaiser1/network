
<div class="wrapper-page" ng-app="NewAccReq" ng-controller="AccRequest">
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
        <div class="panel-heading" style="   <?php echo $logo ?> 
             
             "> 
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


        <div class="panel-body" style="    <?php echo $logo ?> ">
            <form class="form-horizontal m-t-20" id="newAccountRequestForm" ng-submit="signupRequest()">
                <input type="hidden" name="ref_by" value="<?php echo @$ref_by ?>"/>
                <div class="form-group">
                    <div class="col-xs-12 text-center">

                        <label>My Email ID</label>

                        <div class="input-group m-t-10">
                            <input class="form-control input-mini" type="text" name="in_email" ng-model="email" required="" placeholder="email@xyz.com">
                            <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                        </div>



                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12 text-center ">
                        <label>I am a</label>

                        <div class="row text-center">
                            <label class="btn btn-big btn-pink">
                                <input type="radio" checked="" name="in_for" value="2"/>
                                <span class="fa fa-user"></span>
                                Publisher
                            </label>

                            <label class="btn btn-big btn-primary">
                                <input type="radio" name="in_for" value="3"/>  <span class="fa  fa-buysellads"></span> Advertiser
                            </label>
                        </div>
<!--                        <select class="form-control input-lg" name="in_for">
                            <option value="2">Publisher</option>
                            <option value="3">Advertiser</option>
                        </select>-->
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

        $scope.signupRequestBtn = "Verfiy My Email";

        $scope.signupRequest = function () {
            $scope.msg = '';
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

                        $scope.msg = data['msg'];
//                        window.location.href = data['redirectTo'];
                    } else
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
