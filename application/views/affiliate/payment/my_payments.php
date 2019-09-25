<div class="page-wrapper" ng-controller="payment_controller">

            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                     <h3 class="text-themecolor">Payments</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active">Payments</li>
                       
                    </ol>
                </div>
            </div>

 <div class="col-md-12">
            <div class="card">
                <div  class="card-title"> 
                    <h3>Account Summary  </h3> 
                </div> 
                <div class="card-body"> 
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
                            //  echo "<h6 class='text-center text-danger' >Please deposit amount to add or run offers campaign.</h6>";
                        }
                        ?>

                    </div>



                </div> 
            </div>


        </div>



        <div class="col-md-12 col-sm-12 col-xs-12 ">
            <table class="display nowrap table table-hover table-striped table-bordered" style="    background: white">
                <thead class="tophead">
                    <tr>
                        <th>S.No</th>
                        <th>Mode</th>
                        <th>Transaction ID</th>
                        <th>Amount(<?php echo CURR; ?>)</th>

                        <th>Date</th>
                        <!--<th>Method</th>-->
                        <th>Verification</th>
                        <th>Remark</th>
                    </tr>

                </thead>
                <tbody>
                    <tr ng-repeat=" payments in all_payment_history">
                        <td>{{$index + 1}}</td>
                        <td>{{payments.mode}}</td>
                        <td>{{payments.trn_no}}</td>
                        <td>{{payments.amt}}</td>
                        <td>{{payments.dateTime}}</td>
<!--                        <td>
                            <span class="text-primary" ng-if="payments.type == 0">Deposit</span>
                            <span class="text-success" ng-if="payments.type == 1">withdraw</span>
                        </td>-->
                        <td>
                            <span class="text-danger" ng-if="payments.status == 0">Canceled</span>
                            <span class="text-success" ng-if="payments.status == 1">Verified</span>
                        </td>
                        <td>{{payments.remark}}</td>
                    </tr>
                </tbody>

            </table>

            <div id="no_data" ng-if="all_payment_history == ''" style="text-align: center; font-size: x-large;">
                No Transaction History Exist!!
            </div>

            <div></div>



        </div>
    </div>
</div>
<script>
    //var report_app = angular.module("report_app", ['ui.bootstrap']);
    viral_pro.controller("payment_controller", function ($scope) {

        $scope.FormAction = "<?php echo SITEURL . "affiliate/payment/my_paymenthistory" ?>";


        $scope.all_payment_history = {};




        $scope.getPaymentHistory = function () {
            $scope.all_payment_history = {};
            $.ajax({
                url: $scope.FormAction,
                type: 'POST',
                data: "data=1",
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {

                    $scope.all_payment_history = data['history'];
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
    });




</script>