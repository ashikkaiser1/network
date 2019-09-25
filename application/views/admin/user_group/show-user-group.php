<div class="row" ng-controller="groupManager">
    <div class="col-md-6" >
        <div class="panel panel-default" >
            <div class="panel-heading">
                <h3 class="panel-title">
                    Groups

                    <div class="pull-right">
                        <ul class="bulkActions">
                            <li>
                                <a title="Add New" href="<?php echo isset($AddgroupLink) ? $AddgroupLink : '#' ?> " class=" btn btn-info waves-effect waves-light m-b-5 btn-sm">
                                    <span class="fa fa-group"></span> <?php echo isset($AddgroupTitle) ? $AddgroupTitle : '' ?></a>
                            </li>

                        </ul>
                    </div>
                </h3></div>
            <div class="panel-body">
                <div class="row">

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">


                            <div class="table-responsive table  table-hover">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Group Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr ng-repeat="list in allGroup" id="tr{{list.group_id}}">
                                            <td>{{list.group_id}}</td>
                                            <td>{{list.gname}}</td>

                                            <td> 
                                                <button type="button" ng-click="delete_this(list.group_id)" class="btn btn-danger waves-effect waves-light m-b-5 btn-xs">
                                                    <span class="fa fa-trash"></span>
                                                </button>

                                                <button type="button" ng-click="getGroupMembers(list.group_id)"  class="btn btn-primary waves-effect waves-light m-b-5 btn-xs">
                                                    <span class="fa fa-user"></span>
                                                </button>
                                                <a href="<?php echo SITEURL . "admin/user_group/UpdateGroup/" . AFFILIATE . "/" ?>{{list.group_id}}"  class="btn btn-success waves-effect waves-light m-b-5 btn-xs">
                                                    <span class="fa fa-edit"></span>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr ng-if="allGroup.length == 0">
                                            <td colspan="3"><span class="text text-danger">No Result Found</span></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6" id="showGroupAffiliate">
        <div class="panel panel-default" >
            <div class="panel-heading">
                <h3 class="panel-title">
                    Groups Details
                </h3></div>
            <div class="panel-body">
                <div class="row">

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">


                            <div class="table-responsive table  table-hover">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Company</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr ng-repeat="list in allGroupAffiliate" id="tr{{list.uid}}">
                                            <td>
                                                <a href="<?php echo SITEURL."admin/users/ViewUser/" ?>{{list.uid}}">{{list.uid}}</a>
                                                </td>
                                            <td>
                                                <a href="<?php echo SITEURL."admin/users/ViewUser/" ?>{{list.uid}}">{{list.company}} ({{list.name}})</a>
                                            </td>

                                            <td> 
                                                <button type="button" ng-click="delete_thisAffiliate(list.uid)" class="btn btn-danger waves-effect waves-light m-b-5 btn-xs">
                                                    <span class="fa fa-trash"></span>
                                                </button>

                                            </td>
                                        </tr>
                                        <tr ng-if="allGroupAffiliate.length == 0">
                                            <td colspan="3"><span class="text text-danger">No Result Found</span></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>



<script>

</script>
<script>
    //var Category = angular.module("Category", []);
    viral_pro.controller("groupManager", function ($scope) {

        $scope.allGroup = <?php echo json_encode($group) ?>;

        $scope.delete_this = function (group_id)
        {
            swal({
                title: "Are you sure?",
                text: "Your will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn btn-sm btn-danger waves-effect waves-light",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function (isConfirm) {
                if (isConfirm)
                {
                    $.ajax({
                        url: "<?php echo SITEURL . "admin/user_group/deleteGroup" ?>",
                        type: 'POST',
                        data: "group_id=" + group_id,
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            if (data['success'])
                            {
                                $.Notification.autoHideNotify('success',
                                        'botton right',
                                        data['msg'],
                                        '');
                                $("#tr" + group_id).remove();

                                //$("#catForm")[0].reset();
                            } else {
                                $.Notification.autoHideNotify('error',
                                        'botton right',
                                        data['msg'],
                                        '');
                            }

                        }

                    });
                }


            });
        };


        $scope.getGroupMembers = function (group_id)
        {

            $.ajax({
                url: "<?php echo SITEURL . "admin/user_group/getGroupMembers" ?>",
                type: 'POST',
                data: "group_id=" + group_id,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $scope.allGroupAffiliate = data['users'];

                        $("#showGroupAffiliate").show();
                        $scope.$apply();
                        //$("#catForm")[0].reset();
                    } else {
                        $scope.allGroupAffiliate = {};
                    }

                }

            });
        };

        $scope.delete_thisAffiliate = function (uid)
        {
            swal({
                title: "Are you sure?",
                text: "Your will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn btn-sm btn-danger waves-effect waves-light",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function (isConfirm) {
                if (isConfirm)
                {
                    $.ajax({
                        url: "<?php echo SITEURL . "admin/user_group/deleteGroupMember" ?>",
                        type: 'POST',
                        data: "uid=" + uid,
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            if (data['success'])
                            {
                                $.Notification.autoHideNotify('success',
                                        'botton right',
                                        data['msg'],
                                        '');
                                $("#tr" + uid).remove();

                                //$("#catForm")[0].reset();
                            } else {
                                $.Notification.autoHideNotify('error',
                                        'botton right',
                                        data['msg'],
                                        '');
                            }

                        }

                    });
                }


            });
        };



    });
</script>
