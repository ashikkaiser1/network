<div class="row"  ng-controller="payment_controller">
    <nav class="top-nav">
        <h2 class="page-heading blue-bg">Payments</h2>
    </nav>
    <div class="row">



        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"> 
                    <h3 class="panel-title">Account Summary
                        <button  class="btn text-white pull-right waves-effect waves-light btn-success"
                                 ng-click="dipositmoney = dipositmoney == true ? false : true"
                                 >
                            <span class="fa fa-money"></span> + Diposit Payment
                        </button>
                    </h3> 
                </div> 
                <div class="panel-body"> 
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-6 text-center">
                        <h4 class="text-uppercase color-title">Balance Amount</h4>
                        <h2>
                            <?php
                            echo CURR;

                            if (isset($user_balance) && !empty($user_balance)) {
                                echo " " . $user_balance['balance'];
                            } else {
                                echo " 0.00";
                            }
                            ?> 


                        </h2>

                        <?php
                        if (isset($user_balance) && !empty($user_balance)) {
                            
                        } else {
                            echo "<h6 class='text-center text-danger' >Please deposit amount to add or run offers campaign.</h6>";
                        }
                        ?>

                    </div>

                    <div class="col-md-12" ng-if="dipositmoney">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading"> 
                                    <h3 class="panel-title">Diposit Amount

                                    </h3> 
                                </div> 
                                <div class="panel-body">
                                    <form class="form-horizontal"  id="usersForm_payment" ng-submit="deposit_ammout()"> 

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Amount <?php echo CURR ?></label>
                                            <div class="col-md-10">
                                                <input type="text" name="amt" value="50.00" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Transaction ID</label>
                                            <div class="col-md-10">
                                                <input type="text" name="trn_no" value="" class="form-control">

                                            </div>
                                        </div>


                                        <div class="form-group"> 
                                            <div class="col-sm-2">
                                            </div>
                                            <div class="col-sm-10">
                                                <button type="submit" class="btn btn-purple waves-effect waves-light ng-binding">Deposit</button>
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
                        <th>Transaction ID</th>
                        <th>Amount</th>

                        <th>Date</th>
                        <th>Method</th>
                        <th>Verification</th>
                        <th>Remark</th>
                    </tr>

                </thead>
                <tbody>
                    <tr ng-repeat=" payments in all_payment_history">
                        <td>{{$index + 1}}</td>
                        <td>{{payments.trn_no}}</td>
                        <td>{{payments.amt}}</td>
                        <td>{{payments.dateTime}}</td>
                        <td>
                            <span class="text-primary" ng-if="payments.type == 0">Deposit</span>
                            <span class="text-success" ng-if="payments.type == 1">withdraw</span>
                        </td>
                        <td>
                            <span class="text-danger" ng-if="payments.status == 0">Pending</span>
                            <span class="text-success" ng-if="payments.status == 1">Verified</span>
                        </td>
                        <td>{{payments.remark}}</td>
                    </tr>
                </tbody>

            </table>
            <div></div>



        </div>
    </div>
</div>
<script>
    $(function () {


    });
</script>

<script>
    //var report_app = angular.module("report_app", ['ui.bootstrap']);
    viral_pro.controller("payment_controller", function ($scope) {

        $scope.FormAction = "<?php echo SITEURL . "advertiser/payment/my_paymenthistory" ?>";


        $scope.all_payment_history = {};


        $scope.deposit_ammout = function () {
            $scope.validators();

//            console.log($('#usersForm_payment').data('bootstrapValidator'));
            if (!$("#usersForm_payment").data('bootstrapValidator').validate().isValid())
            {

                return  false;
            }
            var form = $("#usersForm_payment").serialize();

            $.ajax({
                url: "<?php echo SITEURL . "advertiser/payment/deposit_mp_payment" ?>",
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

                        $scope.getPaymentHistory();
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

        $scope.getPaymentHistory = function () {
            $scope.all_payment_history = {};
            $.ajax({
                url: $scope.FormAction,
                type: 'POST',
                data: "data=1",
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {


                    if (data['success'])
                    {
                        $scope.all_payment_history = data['history'];
                    }


                    $scope.$apply();



                }
            });

        };

        $scope.getPaymentHistory();
//        $scope.getAdvReport();


        $scope.validators = function () {

            $('#usersForm_payment').bootstrapValidator({
                message: false,
//            container: 'tooltip',
                trigger: null,
                live: 'enabled',
                feedbackIcons: {
                    // valid: 'glyphicon glyphicon-ok',
                    // invalid: 'glyphicon glyphicon-remove',
                    // validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    amt: {// field name
                        validators: {
                            notEmpty: {
                                message: 'Amount cannot be empty'
                            },
                            regexp: {
                                regexp: /^[0-9.]+$/,
                                message: 'Invalid Name'
                            },
                            stringLength: {
                                min: 1,
                                max: 25,
                                message: 'Amount should not empty.!!'
                            }
                        }
                    },
                    trn_no: {// field name
                        validators: {
                            notEmpty: {
                                message: 'Transaction No. cannot be empty'
                            },
                            regexp: {
                                regexp: /^[a-zA-Z0-9.]+$/,
                                message: 'Invalid Name'
                            },
                            stringLength: {
                                min: 1,
                                max: 25,
                                message: 'Transaction No. is must'
                            }
                        }
                    }

                }

            }).on('success.form.bv', function (e) {
                e.preventDefault();

            }).on('error.form.bv', function (e) {

                $.Notification.autoHideNotify('error',
                        'botton right',
                        "Please Fill all mendatory fields.",
                        '');

            });


        }
    });




</script>