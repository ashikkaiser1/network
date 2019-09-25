

<div class="page-wrapper" ng-controller="payment_controller">

            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                     <h3 class="text-themecolor">My Payment Profile</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Account</a></li>
                        <li class="breadcrumb-item active">My Payment Profile</li>
                       
                    </ol>
                </div>
            </div>


    <div class="col-sm-12">
        <div class="card" >
            <div class="card-body"> 
                <h3 class="card-title"> Payment
                    <a href="<?php echo SITEURL ?>affiliate/setting?section=3" class="btn btn-success btn-sm waves-effect waves-light pull-right m-l-10">
                        <span class="fa fa-pencil-square-o"> </span>  Edit 
                    </a>
                </h3>
                
            
            <div class="card-body">

                <div class="col-lg-12"> 
                    <form class="form-horizontal" role="form" id="usersForm_payment" ng-submit="updateUser('payment')">

                         <div class="form-group">
                            <label class="col-md-2 control-label">Paypal Email</label>
                            <div class="col-md-10" style="margin-top:7px;">
                                <?php echo (isset($user['paypal_email']) && $user['paypal_email'] != '') ? $user['paypal_email'] : 'NA' ?>
                            </div>
                        </div> 
                        
                         <div class="form-group">
                            <label class="col-md-2 control-label">Payoneer No.</label>
                            <div class="col-md-10" style="margin-top:7px;">
                                <?php echo (isset($user['payoneer']) && $user['payoneer'] != '') ? $user['payoneer'] : 'NA' ?>
                            </div>
                        </div> 
                        
                        <div class="form-group">
                            <label class="col-md-2 control-label">Bank Name</label>
                            <div class="col-md-10" style="margin-top:7px;">
                                <?php echo (isset($user['bank_name']) && $user['bank_name'] != '') ? $user['bank_name'] : 'NA' ?>
                            </div>
                        </div>          
                        <div class="form-group">
                            <label class="col-md-2 control-label">Bank Account No.</label>
                            <div class="col-md-10" style="margin-top:7px;">
                                <?php echo (isset($user['bank_account']) && $user['bank_account'] != '') ? $user['bank_account'] : 'NA' ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">IFSC Code</label>
                            <div class="col-md-10" style="margin-top:7px;">
                                <?php echo (isset($user['IFSC_code']) && $user['IFSC_code'] != '') ? $user['IFSC_code'] : 'NA' ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">PAN Number</label>
                            <div class="col-md-10" style="margin-top:7px;">
                                <?php echo (isset($user['PAN']) && $user['PAN'] != '') ? $user['PAN'] : 'NA' ?>
                            </div>
                        </div>


                    </form> 
                </div>

                <!--                 !-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col -->
    </div>
</div>
<script>
    // var setting_app = angular.module("setting_app", ['ui.bootstrap']);
    viral_pro.controller("payment_controller", function ($scope) {

        $scope.FormAction = "<?php echo SITEURL . "affiliate/setting/setting_edit" ?>";

        $scope.saveBtn = "Save";

        $scope.updateUser = function (type)
        {
            var form = $("#usersForm_" + type).serialize();
            $.ajax({
                url: $scope.FormAction + "?type=" + type,
                data: form,
                type: 'POST',
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                'NA');
                    } else
                    {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                'NA');
                    }
                }

            });
        };

    });
</script>