<div class="row" id="payment_controller"  ng-controller="payment_controller">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"> 
                    <h3 class="panel-title">Account Summary
                        <button  class="btn text-white pull-right waves-effect waves-light btn-success"
                                 ng-click="dipositmoney = dipositmoney == true ? false : true"
                                 >
                            <span class="fa fa-money"></span> + Generate Invoice for Payment
                        </button>
                    </h3> 
                </div> 
                <div class="panel-body"> 
                    <div class="col-md-6 text-center">
                        <h4 class="text-uppercase color-title">Balance Amount</h4>
                        <h2>


                            <span class="text-pink" ng-if="currentBalance.balance != 0.00">
                                <?php
                                echo CURR;
                                ?>
                                {{currentBalance.balance}}</span>
                            <span class="text-danger" ng-if="currentBalance == '' || currentBalance.balance == 0.00">
                                <?php
                                echo CURR;
                                ?>
                                0.00</span>


                        </h2>



                    </div>

                    <div class="col-md-6 ">
                        <div class="row"> 
                            <div class=" row">
                                <label class="col-md-5 control-label">Paypal Email</label>
                                <div class="col-md-5">
                                    {{userPaymentInfo.paypal_email}}
                                </div>
                            </div> 

                            <div class="row">
                                <label class="col-md-5 control-label">Payoneer No.</label>
                                <div class="col-md-5" >
                                    {{userPaymentInfo.payoneer}}
                                </div>
                            </div> 

                            <div class=" row">
                                <label class="col-md-5 control-label">Bank Name</label>
                                <div class="col-md-5" >
                                    {{userPaymentInfo.bank_name}}
                                </div>
                            </div>          
                            <div class=" row">
                                <label class="col-md-5 control-label">Bank Account No.</label>
                                <div class="col-md-5" >
                                    {{userPaymentInfo.bank_account}}
                                </div>
                            </div>
                            <div class=" row">
                                <label class="col-md-5 control-label">IFSC Code</label>
                                <div class="col-md-5" >
                                    {{userPaymentInfo.IFSC_code}}
                                </div>
                            </div>
                            <div class=" row">
                                <label class="col-md-5 control-label">PAN Number</label>
                                <div class="col-md-5" >
                                    {{userPaymentInfo.PAN}}
                                </div>
                            </div>



                        </div>
                    </div>

                    <div class="col-md-12" ng-if="dipositmoney">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading"> 
                                    <h3 class="panel-title">Generate Invoice

                                    </h3> 
                                </div> 
                                <div class="panel-body">
                                    <form class="form-horizontal ng-pristine ng-valid" role="form" id="usersForm_payment" ng-submit="deposit_ammout()"> 

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Mode of payment</label>
                                            <div class="col-md-10">

                                                <?php echo form_dropdown("mode", $this->config->item("PaymentModes"), '', "class='form-control'") ?>

                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Amount <?php echo CURR ?></label>
                                            <div class="col-md-10">
                                                <input type="text" name="amt" value="{{balanceTransfer}}"  class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Transaction ID</label>
                                            <div class="col-md-10">
                                                <input type="text" name="trn_no" value="" class="form-control">
                                                <input type="hidden" name="uid" value="{{uid}}"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Remark</label>
                                            <div class="col-md-10">
                                                <input type="text" name="remark" value="" class="form-control">

                                            </div>
                                        </div>


                                        <div class="form-group"> 
                                            <div class="col-sm-2">
                                            </div>
                                            <div class="col-sm-10">
                                                <button type="submit" class="btn btn-purple waves-effect waves-light ng-binding">Save Invoice</button>
                                                <button type="Reset" class="btn btn-danger waves-effect waves-light">Cancel</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> 
            </div>


        </div>



        <div class="col-md-12 col-sm-12 col-xs-12 ">
            <table class="table table-responsive table-bordered" style="    background: white">
                <thead class="tophead">
                    <tr>
                        <th>S.No</th>
                        <th>Mode</th>
                        <th>Transaction ID</th>
                        <th>Amount(<?php echo CURR ?>)</th>

                        <th>Date</th>
                        <th>Type</th>
                        <th>Trn. Status</th>
                        <th>Remark</th>
                        <th>Action</th>
                    </tr>

                </thead>
                <tbody>
                    <tr ng-repeat=" payments in all_payment_history">
                        <td>{{$index + 1}}</td>
                        <td>{{payments.mode}}</td>
                        <td>{{payments.trn_no}}</td>
                        <td>{{payments.amt}}</td>
                        <td>{{payments.dateTime}}</td>
                        <td>
                            <span class="text-primary" ng-if="payments.type == 0">Deposit</span>
                            <span class="text-success" ng-if="payments.type == 1">withdraw</span>
                        </td>
                        <td>
                            <span class="text-danger" ng-if="payments.status == 0">Cancelled</span>
                            <span class="text-success" ng-if="payments.status == 1">Approved</span>
                        </td>
                        <td>{{payments.remark}}</td>
                        <td>
                            <button ng-if="payments.status == 1" ng-click="remove_paytransaction(payments.pay_id, payments.amt)" class="btn btn-danger btn-xs"><span class="fa fa-remove"></span></button> 
                            <button ng-if="payments.status == 1" ng-click="send_invoice(payments.pay_id)" class="btn btn-success btn-xs"><span class="fa fa-envelope"></span></button> 
                        </td>
                    </tr>
                </tbody>

            </table>
            <div></div>



        </div>
    </div>
</div>
<script>
    //var report_app = angular.module("report_app", ['ui.bootstrap']);
    viral_pro.controller("payment_controller", function ($scope) {

        $scope.FormAction = "<?php echo SITEURL . "admin/payments/showpaymentHostory" ?>";
        $scope.all_payment_history = {};
        $scope.uid = 0;
        $scope.init = function (uid, balanceTrnasfer) {
            $scope.uid = uid;
            $scope.balanceTransfer = balanceTrnasfer;
            $scope.getPaymentHistory($scope.uid);
            $scope.getUsercurrentBalance();
            $scope.getUserpaymentInfo($scope.uid);
        };
        $scope.getUserpaymentInfo = function (uid) {

            $.ajax({
                url: "<?php echo SITEURL . "admin/payments/getUserPaymentInfo" ?>",
                type: 'POST',
                data: "uid=" + $scope.uid,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {

                    $scope.userPaymentInfo = data['userInfo'];
                    $scope.$apply();
                }
            });
        };
        $scope.getUsercurrentBalance = function () {

            $.ajax({
                url: "<?php echo SITEURL . "admin/payments/getUsercurrentBalance" ?>",
                type: 'POST',
                data: "uid=" + $scope.uid,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {

                    $scope.currentBalance = data['user_balance'];
                    $scope.$apply();
                }
            });
        };
        $scope.deposit_ammout = function () {
            var form = $("#usersForm_payment").serialize();
            $.ajax({
                url: "<?php echo SITEURL . "admin/payments/deposit_mp_payment" ?>",
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
                        $("#usersForm_payment")[0].reset();
                        $scope.getPaymentHistory($scope.uid);
                        $scope.getUsercurrentBalance();
                        angular.element('#aff_payment_controller').scope().search();

                    } else
                    {

                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                    }
                }
            });
        };


        $scope.send_invoice = function (pay_id) {

            $.ajax({
                url: "<?php echo SITEURL . "admin/payments/send_invoice_to_affiliate" ?>",
                type: 'POST',
                data: "pay_id=" + pay_id,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
                    } else
                    {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                    }

                    $scope.$apply();
                    $scope.getPaymentHistory($scope.uid);
                    $scope.getUsercurrentBalance();
                    angular.element('#aff_payment_controller').scope().search();
                }
            });

        };

        $scope.remove_paytransaction = function (pay_id, amt) {
            //this fucntion remove the transaction details from/
            //lagger...


            swal({
                title: "Are you sure?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn btn-sm btn-danger waves-effect waves-light",
                confirmButtonText: "Yes, Confirm it!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
                    function (isConfirm) {
                        if (isConfirm)
                        {
                            $.ajax({
                                url: "<?php echo SITEURL . "admin/payments/change_status" ?>",
                                type: 'POST',
                                data: "pay_id=" + pay_id + "&uid=" + $scope.uid + "&amt=" + amt + "&status=0",
                                dataType: 'json',
                                success: function (data, textStatus, jqXHR) {
                                    if (data['success'])
                                    {
                                        $.Notification.autoHideNotify('success',
                                                'botton right',
                                                data['msg'],
                                                '');
                                    } else
                                    {
                                        $.Notification.autoHideNotify('error',
                                                'botton right',
                                                data['msg'],
                                                '');
                                    }

                                    $scope.$apply();
                                    $scope.getPaymentHistory($scope.uid);
                                    $scope.getUsercurrentBalance();
                                    angular.element('#aff_payment_controller').scope().search();
                                    $scope.send_invoice(pay_id);
                                }
                            });
                        }


                    });






        };


        $scope.getPaymentHistory = function (uid) {
            $scope.all_payment_history = {};
            $.ajax({
                url: $scope.FormAction,
                type: 'POST',
                data: "uid=" + uid,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_payment_history = data['history'];
                    if (data['success'])
                    {
                        //                        $scope.all_payment_history = data['history'];
                    }


                    $scope.$apply();
                }
            });
        };
        //        $scope.getPaymentHistory();
        //        $scope.getAdvReport();
    });




</script>