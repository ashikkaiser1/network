<div class="row" ng-controller="user_controller">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class=" panel-title"> <a href="<?php echo SITEURL . "admin/users/CreateUser" ?>" class=" btn btn-info waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-plus"></span> New </a> Users  </h3>
            </div>  
            <div class="panel-body">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 m-t-10 m-b-10 searchCustom">
                        <!--                        search-->
                        <form id="searchForm" class="form-inline" role="form" ng-submit="searchByForm()" >

                            <div class="form-group m-l-10">
                                <label class="" for="exampleInputEmail2">User ID</label>
                                <input type="text" name="username" class="form-control input-sm" id="" ng-model="searchText" placeholder="">

                            </div>

                            <div class="form-group m-l-10">
                                <label class="" for="">Email</label>
                                <input type="text" name="email" class="form-control" id="" ng-model="Email"  placeholder="">
                            </div>

                            <div class="form-group m-l-10">
                                <label class="" for="">Affiliate ID</label>
                                <input type="text" name="aff_id" class="form-control" id="" ng-model="AffId" placeholder="">
                            </div>

                            <div class="form-group m-l-10">
                                <label class="" for="">Status</label>
                                <?php echo form_dropdown("status", array("" => "All", "1" => "Active", "0" => "De-Activated"), '', "class='form-control'") ?>
                            </div>


                            <button type="submit" class="btn btn-success waves-effect waves-light m-l-10"><span class="fa fa-search">   </span> </button>

                        </form>
                        <!--end search-->
                    </div>


                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Date of Join</th>
                                        <th>User ID</th>
                                        <th>Email</th>
<!--                                        <th>Affiliate ID</th>-->
                                        <th>User Type</th>
                                        <th>Verified</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    ?>
                                    <tr ng-repeat="user in all_users| filter :searchText | filter : Email | filter : AffId "  >
                                        <td>{{ $index + 1}}</td>

                                        <td>
                                            <span titile='Active' ng-if="user.u_status == 1" class='fa fa-circle text-success'></span>
                                            <span titile='Active' ng-if="user.u_status == 0" class='fa fa-circle text-danger'></span>
                                            {{user.name}}
                                        </td>
                                        <td>{{user.DOJ}}</td>
                                        <td>{{user.username}}</td>
                                        <td>{{user.email}}</td>
<!--                                        <td>{{user.aff_id}}</td>-->
                                        <td>{{user.usertype_name}}</td>
                                        <td>
                                            <span titile='Active' ng-if="user.verified == 1" class='fa fa-check text-success'></span>
                                            <span titile='Active' ng-if="user.verified == 0" class='fa fa-remove text-danger'></span>


                                        </td>

                                        <td>
                                            <a class="btn btn-pink waves-effect waves-light m-b-5 btn-xs" href="<?php echo SITEURL . "admin/users/ViewUser/" ?>{{user.uid}}" ><span class="fa fa-eye"></span></a>
<!--                                            <button type="button" class="btn btn-info waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-eye"></span></button>-->
                                            <a href="<?php echo SITEURL . "admin/users/UpdateUser/" ?>{{user.uid}}" type="button" class="btn btn-primary waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span></a>
                                            <a   class="btn btn-primary waves-effect waves-light m-b-5 btn-xs" href="<?php echo SITEURL."admin/globalpostback/index/"?>{{user.uid}}"><span class="fa fa-link"></span></a>
                                            <button type="button" class="btn btn-danger waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-trash"></span></button>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
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
    //user_controller
    var user_controller = viral_pro.controller("user_controller", function ($scope) {

        $scope.all_users = {};
        $scope.searchBtn = "";
        $scope.FormAction = "<?php echo SITEURL . "admin/users/ShowUsers" ?>";


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

        $scope.search = function () {
            $scope.searchBtn = "";
            var form = $("#searchForm").serialize();
            $.ajax({
                url: $scope.FormAction+"?page="+$scope.currentPage,
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_users = data;
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
        $scope.getUsers();
    });
</script>