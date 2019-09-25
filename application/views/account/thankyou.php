
<div ng-app="thankyouPage" ng-controller="thankyouPage_controller" class="col-lg-12 text-center " style="    background: white;
     margin: 7% auto;" >
    <h1 class="text-center text-uppercase"><?php echo @SITENAME ?></h1>
    <h3 class="text-center">Thank you for Registration</h3>
    <div class="col-lg-12">
        <div class="row">
            <p>Your account is created but you can access your account after verfication.</p>    
            <a href="<?php echo SITEURL ?>" class="btn btn-success btn-lg"><span class="fa fa-user"></span> Login</a>
        </div>

    </div>

</div>

<script>

    var thankyou = angular.module("thankyouPage", ['ui.bootstrap']);

    thankyou.controller("thankyouPage_controller", function ($scope) {

        $scope.sendEmailToadmin = function (username) {

            $.ajax({
                url: "<?php echo SITEURL . "account/account/notifiy_admin_by_mail" ?>";
                data: "username=" + username,
                type: 'GET',
                dataType: 'json',
                beforeSend: function (xhr) {

                },
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                    } else
                    {
                    }
                }

            });

        };
    });
    
    $scope.sendEmailToadmin('<?php echo $this->input->get("username")?>');



</script>

