<div class="row" ng-controller="refferal_program">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class=" panel-title"> 
                    <?php echo isset($title) ? $title : '' ?>
                </h3>
            </div>  
            <div class="panel-body">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 m-t-10 m-b-10 searchCustom">
                        <!--                        search-->
                        <form id="searchForm" class="form-inline" role="form" ng-submit="searchByForm()" >

                            <div class="form-group m-l-10 ">
                                <label class="" >Search</label>
                                <input type="text" name="search" class="form-control " ng-model="searchText" placeholder="">
                                <input type="hidden" name="UTID" value="<?php echo isset($UTID) ? $UTID : '' ?>"/>
                                <input type="hidden" name="username" ng-value="searchText" />


                            </div>
                            <button type="submit" class="btn btn-success waves-effect waves-light m-l-10"><span class="fa fa-search">   </span> </button>

                        </form>
                    </div>


                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <form id="AffiliateList">



                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>

                                            <th>#ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Reffers</th>
                                            <th>Status</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="user in all_users" ng-cloak="" >
                                            <td>
                                                {{user.uid}}  
                                            </td>
                                            <td>
                                                {{user.name}}  
                                            </td>
    <!--                                        <td>{{user.DOJ}}</td>-->
    <!--                                        <td>{{user.username}}</td>-->
    <!--                                        <td>{{user.email}}</td>-->
                                            <td>{{user.email}}</td>
                                            <td>{{user.mobile}}</td>
                                            <td>
                                                <button ng-click="letcheckRefferals(user)" type="button" class="btn btn-sm btn-info btn-rounded waves-effect waves-light m-b-5">
                                                    {{user.total_referals}}
                                                </button>
                                            </td>

                                            <td>
                                                <span ng-if="user.u_status == 0" class="text-danger">Inactive</span>
                                                <span ng-if="user.u_status == 1" class="text-success">Active</span>
                                                <span ng-if="user.u_status == 2" class="text-warning">Pending</span>
                                                <span ng-if="user.u_status == 3" class="text-danger">Block</span>
                                                <span ng-if="user.u_status == 4" class="text-danger">Rejected</span>
                                                <span ng-if="user.u_status == 5" class="text-danger">Deleted</span>
                                            </td>



                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </form>
                        <div class="text-danger text-center" ng-if="all_users == ''">
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



                <!-- Modal -->
                <div id="RefferModal" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Detail Information About {{myreferals.name}} Referred Affiliates</h4>
                            </div>
                            <div class="modal-body">
                                <?php
                                $this->load->view("admin/refferal_program/show_reffered_affiliate");
                                ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    //var userManager = angular.module("user_app", ['ui.bootstrap']);
    //refferal_program
    var refferal_program = viral_pro.controller("refferal_program", function ($scope) {

        $scope.all_users = {};
        $scope.searchBtn = "";
        $scope.FormAction = "<?php echo SITEURL . "admin/refferal_program/index" ?>";
        $scope.currentPage = 1;
        $scope.numPerPage = 10;

        $scope.searchByForm = function () {
            $scope.currentPage = 1;
            $scope.search();
        };

        $scope.$watch('currentPage + numPerPage', function () {

            console.log($scope.currentPage + $scope.numPerPage);


            $scope.search();

        });

        $scope.letcheckRefferals = function (user) {

            $("#RefferModal").modal('show');
            $scope.get_refferalUser(user);
            $scope.myreferals = user;
        };

        $scope.get_refferalUser = function (user) {
            $scope.all_reffusers = {};
            $.ajax({
                url: $scope.FormAction,
                type: 'POST',
                data: "ref_by=" + user.uid,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_reffusers = data['users'];
                    $scope.$apply();
                }
            });
        };

        $scope.search = function () {
            $scope.searchBtn = "";
            var form = $("#searchForm").serialize();
            $.ajax({
                url: $scope.FormAction + "?page=" + $scope.currentPage,
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_users = data['users'];
                    $scope.searchBtn = "";
                    $scope.$apply();
                }
            });
        };



        $scope.getUsers = function () {

            $.ajax({
                url: $scope.FormAction,
                type: 'POST',
                data: 'user=1',
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_users = data;
                    $scope.$apply();
                }
            });
        };
    });
</script>