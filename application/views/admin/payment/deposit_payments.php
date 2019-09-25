

<div class="row" ng-controller="payment_deposit_controller">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class=" panel-title"> 

                    <?php echo isset($title) ? $title : '' ?>  </h3>
            </div>  
            <div class="panel-body">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 m-t-10 m-b-10 searchCustom">
                        <!--                        search-->
                        <form id="searchForm" class="form-inline" role="form" ng-submit="searchByForm()" >

                            <div class="form-group m-l-10">
                                <label class="" for="exampleInputEmail2">Advertiser</label>
                                <input type="text" name="username" class="form-control input-sm" id="usernamesuggetion" ng-model="searchText" placeholder="">
                                <input type="hidden" name="UTID" value="<?php echo isset($UTID) ? $UTID : '' ?>"/>
                            </div>

                            <div class="form-group m-l-10">
                                <label class="" for="">Email ID</label>
                                <input type="text" name="email" class="form-control" id="emailsuggestion" ng-model="Email"  placeholder="">
                            </div>


                            <div class="form-group m-l-10">
                                <label class="" for="">Status</label>
                                <?php echo form_dropdown("status", $status, '', "class='form-control'") ?>
                            </div>


                            <button type="submit" class="btn btn-success waves-effect waves-light m-l-10"><span class="fa fa-search">   </span> </button>

                        </form>

                    </div>


                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Trn No.</th>
                                        <th>Amt.(<?php echo CURR ?>)</th>
                                        <th>Date Time</th>
                                        <th>Verification</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    ?>
                                    <tr ng-repeat="user in all_user_payment_history| filter :searchText | filter : Email | filter : AffId "  >
                                        <td>{{ $index + 1}}</td>

                                        <td>
                                            <a href="<?php echo SITEURL ?>admin/users/ViewUser/{{user.uid}}">
                                            {{user.name}}
                                            </a>
                                        </td>
                                        <td>{{user.trn_no}}</td>
                                        <td>{{user.amt}}</td>
                                        <td>{{user.dateTimeFromated}}</td>
                                        <td>
                                            <select class="form-control"  ng-change="change_status(user.status,user.pay_id,this)" ng-model="user.status">
                                                <option value="0">Pending</option>
                                                <option value="1">Verified</option>
                                            </select>
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
                        <div class="col-md-6">
                            <pagination 
                                ng-model="currentPage"
                                total-items="1000"
                                max-size="5"  
                                boundary-links="true">
                            </pagination>
                        </div>
                        <div class="col-md-3">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    //var userManager = angular.module("user_app", ['ui.bootstrap']);
    //payment_deposit_controller
    var payment_deposit_controller = viral_pro.controller("payment_deposit_controller", function ($scope) {

        $scope.all_user_payment_history = {};
        $scope.searchBtn = "";
        $scope.FormAction = "<?php echo SITEURL . "admin/payments/showpaymentHostory" ?>";


        $scope.currentPage = 1;
        $scope.numPerPage = 10;

        $scope.searchByForm = function () {
            $scope.currentPage = 1;
            $scope.search();
        };

        $scope.change_status = function (status,pay_id,that)
        {
            console.log(that);
//            status = status =="1" ? '0' :'1';
            $.ajax({
                url: "<?php echo SITEURL . "admin/payments/change_status" ?>",
                type: 'POST',
                data: 'amt='+that.user.amt+'&uid='+that.user.uid+'&pay_id=' + pay_id + "&status=" + that.user.status,
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
                         $scope.all_user_payment_history = data['history'];
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