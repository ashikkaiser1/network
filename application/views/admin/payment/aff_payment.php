

<div class="row" id="aff_payment_controller" ng-controller="aff_payment_controller">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class=" panel-title"> 

                    <?php echo isset($title) ? $title : '' ?>  </h3>
            </div>  
            <div class="panel-body">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 m-t-10 m-b-10 searchCustom hidden">
                        <!--                        search-->
                        <form id="searchForm" class="form-inline hidden" role="form" ng-submit="searchByForm()" >

                            <div class="form-group m-l-10">
                                <label class="" for="exampleInputEmail2">Affiliate</label>
                                <input type="text" name="username" class="form-control input-sm" id="usernamesuggetion" ng-model="searchText" placeholder="">
                            </div>

                            <div class="form-group m-l-10 hidden">
                                <input type="hidden" value="aff_name" name=" groupby[aff_name]"> 
                                <input type="hidden" value="aff_id" name=" groupby[aff_id]"> 

                                <input type="hidden"  value="cost" name="select[cost]">                                                 
                                <input type="hidden" value="DESC" name="sort"
                            </div>
                            <button type="submit" class="btn btn-success waves-effect waves-light m-l-10"><span class="fa fa-search">   </span> </button>

                        </form>

                    </div>
                </div>


                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Earn & Tranfered(<?php echo CURR ?>)</th>
                                    <th>Earn by Offers (<?php echo CURR ?>)</th>
                                    <th>Earn by Referals (<?php echo CURR ?>)</th>
                                    <th title="Earn by Offers + Earn by Referals">Net Total(<?php echo CURR ?>)</th>
                                    <th>Pending Payment(<?php echo CURR ?>)</th>
                                    <th>Payment Action <span class="fa fa-info-circle" title="Generate Invoice button will only show when there is any to be transfer balance is > 0."></span></th>

                                </tr>
                            </thead> 
                            <tbody>
                                <?php
                                ?>
                                <tr ng-repeat="user in all_user_payment_history| filter :searchText | filter : Email | filter : AffId "  >
                                    <td>{{ $index + 1}}</td>

                                    <td>
                                        <a href="<?php echo SITEURL ?>admin/users/ViewUser/{{user.RR_Aff_id}}">
                                            {{user.Aff_Name}}
                                        </a>
                                    </td>
                                    <td>
                                        <span ng-if="user.user_balance == ''">
                                            0.00
                                        </span>
                                        <span ng-if="user.user_balance != ''">
                                            {{user.user_balance.balance}}
                                        </span>
                                    </td>
                                    <td>{{user.Cost}}</td>
                                    <td>{{user.user_balance.refereal_pay}}</td>
                                    
                                    <td>{{user.sum_of_offer_toal_n_referal}}</td>
                                    <td>{{user.balance}}</td>
                                    <td>
                                        <div>
                                            <button ng-click="letTranserToAffiliate(user.RR_Aff_id, user.balance)" class="btn btn-sm btn-success">
                                                <span class="fa fa-money"></span> Generate Invoice & Pay</button>
                                        </div>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-danger text-center" ng-if="all_user_payment_history == ''">
                        <h3 class='text-danger'>There is no data available ....</h3>
                    </div>

                    <div class="col-md-3">

                    </div>
                    <!--                        <div class="col-md-6">
                                                <pagination 
                                                    ng-model="currentPage"
                                                    total-items="1000"
                                                    max-size="5"  
                                                    boundary-links="true">
                                                </pagination>
                                            </div>-->
                    <div class="col-md-3">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Modal -->
<div id="paymentModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Payment Transfer</h4>
            </div>
            <div class="modal-body">
                <?php
                $this->load->view("admin/payment/aff_payment_transfer/my_payments");
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


<script>
    //var userManager = angular.module("user_app", ['ui.bootstrap']);
    //aff_payment_controller
    var aff_payment_controller = viral_pro.controller("aff_payment_controller", function ($scope) {

        $scope.all_user_payment_history = {};
        $scope.searchBtn = "";
        $scope.FormAction = "<?php echo SITEURL . "admin/payments/aff_payments" ?>";


        $scope.currentPage = 1;
        $scope.numPerPage = 10;

        $scope.searchByForm = function () {
            $scope.currentPage = 1;
            $scope.search();
        };

        $scope.letTranserToAffiliate = function (uid, balanceTrnasfer) {

            $("#paymentModal").modal('show');
            angular.element('#payment_controller').scope().init(uid, balanceTrnasfer);
        };

        $scope.change_status = function (status, pay_id, that)
        {
            console.log(that);
//            status = status =="1" ? '0' :'1';
            $.ajax({
                url: "<?php echo SITEURL . "admin/payments/change_status" ?>",
                type: 'POST',
                data: 'amt=' + that.user.amt + '&uid=' + that.user.uid + '&pay_id=' + pay_id + "&status=" + that.user.status,
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

//                    $scope.search();
                }
            });

        };

        $scope.$watch('currentPage + numPerPage', function () {

            console.log($scope.currentPage + $scope.numPerPage);


            $scope.search();

        });

        $scope.search = function () {
            $scope.searchBtn = "";
            var form = $("#searchForm").serialize();
            $.ajax({
                url: $scope.FormAction + "?page=" + $scope.currentPage,
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_user_payment_history = data['aff_payments'];
                    if (data['success']) {
//                        $scope.all_user_payment_history = data['history'];
                    }
                    $scope.$apply();
                }
            });
        };

        //$scope.getUsers();
    });
</script>