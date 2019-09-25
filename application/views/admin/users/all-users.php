

<div class="row" ng-controller="user_controller">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class=" panel-title"> 
                    <?php echo isset($title) ? $title : '' ?>

                    <div class="pull-right">
                        <ul class="bulkActions">
                            <li>
                                <a title="Add New" href="<?php echo isset($add_link) ? $add_link : '#' ?> " class=" btn btn-info waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-plus"></span> Add New </a>
                            </li>

                              <?php
                                            if(isset($UTID)  && !($UTID ==4 || $UTID ==5)){
                                                ?>
                            <li>
                                <a title="Send Buld Email" ng-click="send_mail('<?php echo isset($email_link) ? $email_link : '#' ?>')" href="#" class=" btn btn-info waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-envelope"></span> Email </a>
                            </li>
                            <li>
                                <a title="Pending Users" href="<?php echo isset($pending_link) ? $pending_link : '#' ?> " class=" btn btn-warning waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-user"></span> Pending Users </a>
                            </li>
                                            <?php } ?>

                            

                            <li>
                                <a title="Pending Users" href="" class=" btn btn-success waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-anchor"></span> Actions </a>
                                <ul class="subOptions">

                                    <li><a href="#" ng-click="bulkAction(1)">Active</a></li>
                                    <li><a href="#" ng-click="bulkAction(0)">Inactive</a></li>
                                    <li><a href="#" ng-click="bulkAction(2)">Pending</a></li>
                                    <li><a href="#" ng-click="bulkAction(3)">Block</a></li>
                                    <li><a href="#" ng-click="bulkAction(4)">Reject</a></li>
                                </ul>

                            </li>




                        </ul>




                    </div>

                </h3>
            </div>  
            <div class="panel-body">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 m-t-10 m-b-10 searchCustom">
                        <!--                        search-->
                        <form id="searchForm" class="form-inline" role="form" ng-submit="searchByForm()" >

                            <div class="form-group m-l-10 ">
                                <label class="" for="exampleInputEmail2">Search</label>
                                <input type="text" name="search" class="form-control " id="searchSuggetion" ng-model="searchText" placeholder="">
                                <input type="hidden" name="UTID" value="<?php echo isset($UTID) ? $UTID : '' ?>"/>
                                <input type="hidden" name="username" ng-value="searchText" />


                            </div>

                            <!--                            <div class="form-group m-l-10">
                                                            <label class="" for="">Email</label>
                                                            <input type="text" name="email" class="form-control" id="emailsuggestion" ng-model="Email"  placeholder="">
                                                        </div>
                            
                                                        <div class="form-group m-l-10">
                                                            <label class="" for="">Affiliate ID</label>
                                                            <input type="text" name="aff_id" class="form-control" id="" ng-model="AffId" placeholder="">
                                                        </div>-->

                            <div class="form-group m-l-10">
                                <label class="" for="">Status</label>
                                <?php echo form_dropdown("status", $status, '', "class='form-control'") ?>
                            </div>


                            <button type="submit" class="btn btn-success waves-effect waves-light m-l-10"><span class="fa fa-search">   </span> </button>

                        </form>





                        <script>
                                    //    $(document).ready(function () {
                                    //
                                    //        $('input.ad_title').typeahead({
                                    //            name: 'q',
                                    //            remote: '?q=%QUERY'
                                    //
                                    //        });
                                    //
                                    //    });
                                    //$(document).ready(function () {
                                    var options = {
                                        url: function (phrase) {
                                            return '<?php echo SITEURL . "admin/users/search_suggetions" ?>';
                                        },
                                        template: {
                                            type: "custom",
                                            method: function (value, item) {
                                                if (item.company !== null)
                                                {
                                                    var option_selct = "<div class='searchResult'><span class='companyName'>" + item.company + "</span> <span class='userName'>" + item.name + " </span> <span class='userEmail'>" + item.email + " </span></div>"

                                                    return option_selct;
                                                }

                                                return  value;

                                            }

                                        },
                                        getValue: function (element) {
                                            return element.name;
                                        },
                                        list: {
                                            onSelectItemEvent: function () {
                                                //			var value = $("#searchSugg").getSelectedItemData().category_id;
                                                //
                                                //			$("#category_id_sub").val(value).trigger("change");
                                            }
                                        },
                                        ajaxSettings: {
                                            dataType: "json",
                                            method: "POST",
                                            data: {
                                                dataType: "json"
                                            }
                                        },
                                        preparePostData: function (data) {
                                            data.phrase = $("#searchSuggetion").val();
                                            data.UTID = '<?php echo isset($UTID) ? $UTID : '' ?>';
                                            return data;
                                        },
                                        requestDelay: 400
                                    };


                                    $("#searchSuggetion").easyAutocomplete(options);


                        </script>
                        <!--end search-->
                    </div>


                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <form id="UserDatatableForm">



                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" ng-model="selectALLUser"/></th>
                                            <th>#</th>
                                            <th>Company</th>
    <!--                                        <th>Date of Join</th>-->
    <!--                                        <th>User ID</th>
                                            <th>Email</th>-->
                                            <th>Contact Person</th>
                                            <th>Status</th>
    <!--                                        <th>Affiliate ID</th>-->
    <!--                                        <th>User Type</th>-->
    <!--                                        <th>Verified</th>-->
                                            <?php
                                            if(isset($UTID)  && !($UTID ==4 || $UTID ==5)){
                                                ?>
                                             <th>Action</th>
                                            <?php
                                            }
                                            ?>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php ?>

                                        <!--                                    | filter :searchText | filter : Email | filter : AffId-->
                                        <tr ng-repeat="user in all_users" ng-cloak="" >
                                            <td>
                                                <input class="uids" ng-checked="selectALLUser" type="checkbox" name="uid[]" value="{{user.uid}}"/>
                                            </td>
                                            <td>
                                                <a ng-if="user.UTID < 4" title="View"  href="<?php echo SITEURL . "admin/users/ViewUser/" ?>{{user.uid}}" > {{user.uid}}</a>

                                                <a ng-if="user.UTID >= 4" title="View"  href="<?php echo SITEURL . "admin/employee/ViewEmployee/" ?>{{user.uid}}" >{{user.uid}}</a>

                                                <!--                                                                                        {{ $index + 1}}-->

                                            </td>

                                            <td>
    <!--                                            <span titile='Active' ng-if="user.u_status == 1" class='fa fa-circle text-success'></span>
                                                <span titile='Active' ng-if="user.u_status == 0" class='fa fa-circle text-danger'></span>-->

                                                <a ng-if="user.UTID < 4" title="View"  href="<?php echo SITEURL . "admin/users/ViewUser/" ?>{{user.uid}}" > {{user.company}}</a>

                                                <a ng-if="user.UTID >= 4" title="View"  href="<?php echo SITEURL . "admin/employee/ViewEmployee/" ?>{{user.uid}}" >{{user.company}}</a>


                                            </td>
    <!--                                        <td>{{user.DOJ}}</td>-->
    <!--                                        <td>{{user.username}}</td>-->
    <!--                                        <td>{{user.email}}</td>-->
                                            <td>{{user.name}}</td>

                                            <td>
                                                <span ng-if="user.u_status == 0" class="text-danger">Inactive</span>
                                                <span ng-if="user.u_status == 1" class="text-success">Active</span>
                                                <span ng-if="user.u_status == 2" class="text-warning">Pending</span>
                                                <span ng-if="user.u_status == 3" class="text-danger">Block</span>
                                                <span ng-if="user.u_status == 4" class="text-danger">Rejected</span>
                                                <span ng-if="user.u_status == 5" class="text-danger">Deleted</span>
                                            </td>

<!--                                        <td>{{user.aff_id}}</td>-->
<!--                                        <td>{{user.usertype_name}}</td>-->
<!--                                        <td>
    <span titile='Active' ng-if="user.verified == 1" class='fa fa-check text-success'></span>
    <span titile='Active' ng-if="user.verified == 0" class='fa fa-remove text-danger'></span>


</td>-->
                                            <?php
                                            if(isset($UTID)  && !($UTID ==4 || $UTID ==5)){
                                                ?>
                                            <td>
    <!--                                            <a ng-if="user.UTID < 4" title="View" class="btn btn-pink waves-effect waves-light m-b-5 btn-xs" href="<?php echo SITEURL . "admin/users/ViewUser/" ?>{{user.uid}}" ><span class="fa fa-eye"></span> View</a>
    
                                                <a ng-if="user.UTID >= 4" title="View" class="btn btn-pink waves-effect waves-light m-b-5 btn-xs" href="<?php echo SITEURL . "admin/employee/ViewEmployee/" ?>{{user.uid}}" ><span class="fa fa-eye"> View</span></a>
                                                -->

<!--                                            <button type="button" class="btn btn-info waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-eye"></span></button>
                                            <a  ng-if="user.UTID < 4" href="<?php echo SITEURL . "admin/users/UpdateUser/" ?>{{user.uid}}" type="button" class="btn btn-primary waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span></a>
                                            <a  ng-if="user.UTID >= 4" href="<?php echo SITEURL . "admin/employee/UpdateEmployee/" ?>{{user.uid}}" type="button" class="btn btn-primary waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span></a>


                                            <a   class="btn btn-primary waves-effect waves-light m-b-5 btn-xs" href="<?php echo SITEURL . "admin/globalpostback/index/" ?>{{user.uid}}"><span class="fa fa-link"></span></a>
                                                -->
                                                <button type="button" ng-click="account_login(user.username, user.password)" title="Login to Account" class="btn btn-pink waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-user"></span> Login</button>
                                                <a href="<?php echo isset($email_link) ? $email_link . "?uid={{user.uid}}" : '#' ?>" class="btn btn-success waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-envelope"></span> Email</a>
                                                <a href="<?php echo isset($stats_link) ? $stats_link . "&uid={{user.uid}}" : '#' ?>" class="btn btn-primary waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-bar-chart"></span> Stats</a>
    <!--                                            <button type="button" class="btn btn-danger waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-trash"></span></button>-->
                                            </td>
                                            <?php } ?>

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
                url: $scope.FormAction + "?page=" + $scope.currentPage,
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

        $scope.bulkAction = function (action_type)
        {

            var form = $("#UserDatatableForm").serialize();
            $.ajax({
                url: "<?php echo SITEURL . "admin/users/bultupdate" ?>" + "?status=" + action_type,
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
                        $scope.search();
                    }
                    else
                    {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                    }
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



        $scope.send_mail = function (url)
        {

            var query_string = $("input.uids").serialize();
            url = url + "?" + query_string;
            window.location = url;

        };

        $scope.account_login = function (username, password) {
            $scope.LoginBtn = "Processing";
            //  var form = $("#loginForm");
            var url = "<?php echo SITEURL . "account/account/oAuth" ?>";
            $.ajax({
                url: url,
                type: 'POST',
                data: 'username=' + username + "&password=" + password,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
                        $.Notification.autoHideNotify('info',
                                'botton right',
                                "Redirecting....",
                                '');

                        window.location.href = data['redirectTo'];

                    }
                    else
                    {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                    }
                    $scope.LoginBtn = "Log In";
                    $scope.$apply();
                }
            });



        };



        //$scope.getUsers();
    });
</script>