

<div class="row" ng-controller="user_controller">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class=" panel-title"> <a href="<?php echo isset($add_link) ? $add_link : '#' ?> " class=" btn btn-info waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-plus"></span> New </a> <?php echo isset($title) ? $title : '' ?>  </h3>
            </div>  
            <div class="panel-body">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 m-t-10 m-b-10 searchCustom">
                        <!--                        search-->
                        <form id="searchForm" class="form-inline" role="form" ng-submit="searchByForm()" >

                            <div class="form-group m-l-10">
                                <label class="" for="exampleInputEmail2">User ID</label>
                                <input type="text" name="username" class="form-control input-sm" id="usernamesuggetion" ng-model="searchText" placeholder="">
                                <input type="hidden" name="UTID" value="<?php echo isset($UTID) ? $UTID : '' ?>"/>
                            </div>

                            <div class="form-group m-l-10">
                                <label class="" for="">Email ID</label>
                                <input type="text" name="email" class="form-control" id="emailsuggestion" ng-model="Email"  placeholder="">
                            </div>

                            <!--                            <div class="form-group m-l-10">
                                                            <label class="" for="">Affiliate ID</label>
                                                            <input type="text" name="aff_id" class="form-control" id="" ng-model="AffId" placeholder="">
                                                        </div>-->

                            <div class="form-group m-l-10">
                                <label class="" for="">Status</label>
                                <?php echo form_dropdown("status", $status, $selected_status, "class='form-control'") ?>
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
            return '<?php echo SITEURL . "admin/users/username_suggetions" ?>';
        },
//        template: {
//            type: "custom",
//            method: function (value, item) {
//                if(item.category !==null)
//                {
//                    return  value +" in <span  class='in_category' >"+item.category+" <span> " ;
//                }
//                
//                return  value ;
//                
//            }
//            
//        },
        getValue: function (element) {
            return element.name;
        },
        list: {
		onSelectItemEvent: function() {
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
            data.phrase = $("#usernamesuggetion").val();
            data.UTID = '<?php echo isset($UTID) ? $UTID : '' ?>';
            return data;
        },
        requestDelay: 400
    };


    $("#usernamesuggetion").easyAutocomplete(options);

 var options_email = {
        url: function (phrase) {
            return '<?php echo SITEURL . "admin/users/email_suggetions" ?>';
        },
//        template: {
//            type: "custom",
//            method: function (value, item) {
//                if(item.category !==null)
//                {
//                    return  value +" in <span  class='in_category' >"+item.category+" <span> " ;
//                }
//                
//                return  value ;
//                
//            }
//            
//        },
        getValue: function (element) {
            return element.name;
        },
        list: {
		onSelectItemEvent: function() {
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
            data.phrase = $("#emailsuggestion").val();
            data.UTID = '<?php echo isset($UTID) ? $UTID : '' ?>';
            return data;
        },
        requestDelay: 400
    };


    $("#emailsuggestion").easyAutocomplete(options_email);
</script>
                        <!--end search-->
                    </div>


                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Date of Joining</th>
                                        <th>User ID</th>
                                        <th>Email ID</th>
<!--                                        <th>Affiliate ID</th>-->
                                        <th>User Type</th>
                                        <th>Verification Status</th>
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
                                            <span titile='In Active' ng-if="user.u_status == 0" class='fa fa-circle text-danger'></span>
                                            {{user.name}}
                                        </td>
                                        <td>{{user.DOJ}}</td>
                                        <td>{{user.username}}</td>
                                        <td>{{user.email}}</td>
<!--                                        <td>{{user.aff_id}}</td>-->
                                        <td>{{user.usertype_name}}</td>
                                        <td>

                                            <?php
                                            echo form_dropdown("status", $status, '', "class='form-control input-sm' id='status{{user.uid}}' ng-model='user.u_status'")
                                            ?>


                                        </td>

                                        <td>
                                            <button type="button" class="btn btn-success waves-effect waves-light m-b-5 btn-xs" ng-click="change_status(user.uid)"  ><span class="fa fa-save"></span></button>
                                            <a ng-if="user.UTID < 4" class="btn btn-pink waves-effect waves-light m-b-5 btn-xs" href="<?php echo SITEURL . "admin/users/ViewUser/" ?>{{user.uid}}" ><span class="fa fa-eye"></span></a>

                                            <a ng-if="user.UTID >= 4" class="btn btn-pink waves-effect waves-light m-b-5 btn-xs" href="<?php echo SITEURL . "admin/employee/ViewEmployee/" ?>{{user.uid}}" ><span class="fa fa-eye"></span></a>

<!--                                            <button type="button" class="btn btn-info waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-eye"></span></button>-->
                                            <a  ng-if="user.UTID < 4" href="<?php echo SITEURL . "admin/users/UpdateUser/" ?>{{user.uid}}" type="button" class="btn btn-primary waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span></a>
                                            <a  ng-if="user.UTID >= 4" href="<?php echo SITEURL . "admin/employee/UpdateEmployee/" ?>{{user.uid}}" type="button" class="btn btn-primary waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span></a>



<!--                                            <a   class="btn btn-primary waves-effect waves-light m-b-5 btn-xs" href="<?php echo SITEURL . "admin/globalpostback/index/" ?>{{user.uid}}"><span class="fa fa-link"></span></a>-->


                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
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

        $scope.change_status = function (uid)
        {
            var status = $("#status" + uid).val();
            $.ajax({
                url: "<?php echo SITEURL . "admin/users/change_status" ?>",
                type: 'POST',
                data: 'uid=' + uid + "&status=" + status,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {

                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
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
        //$scope.getUsers();
    });
</script>