<div class="row" ng-controller="user_permission_controller">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class=" panel-title"> 
                    Set Affiliate Manager Permissions.
                </h3>
            </div>  
            <div class="panel-body">

                <form id="permission_form" ng-submit="save_permissions()">
                    <div class="row">
                        <input type="hidden" value="<?php echo $uid ?>" name="uid"/>
                        <div class="col-md-12" ng-repeat="menu in all_menus">
                            <div class="checkbox checkbox-success checkbox-circle" ng-if="menu.meta != '' && menu.meta != null">
                                <input id="check{{menu.p_id}}" type="checkbox" name="permission[]" ng-checked="all_permissions[menu.p_id] == menu.p_id ? true : false"  value="{{menu.p_id}}"/>
                                <label for="check{{menu.p_id}}">
                                    {{menu.meta}}
                                </label> 
                            </div>
                            <div class="col-md-11 checkbox checkbox-success checkbox-circle" ng-repeat="child in menu.child">
                                <input id="check{{child.p_id}}" type="checkbox" name="permission[]" ng-checked="all_permissions[child.p_id] == child.p_id ? true : false"  value="{{child.p_id}}"/>
                                <label for="check{{child.p_id}}" class="col-md-12" ng-if="child.meta != '' && child.meta != null">
                                    {{child.meta}}
                                </label>  
                            </div>
                        </div>
                        <div class="col-md-12 m-t-20">

                            <div class="col-md-11">
                                <button type="submit" class=" btn btn-success btn-sm"> Save Permissions</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    //var userManager = angular.module("user_app", ['ui.bootstrap']);
    //user_permission_controller
    var user_permission_controller = viral_pro.controller("user_permission_controller", function ($scope) {

        $scope.all_permissions = <?php echo json_encode($permissions) ?>;
        $scope.searchBtn = "";
        $scope.FormAction = "<?php echo SITEURL . "admin/employee/permission_manager" ?>";


        $scope.get_menus = function () {
            
            $.ajax({
                url: "<?php echo SITEURL . "admin/system/get_menus" ?>",
                type: 'POST',
                data: "data=1",
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_menus = data['menus'];
                    $scope.$apply();
                }
            });

        };
        $scope.get_menus();
        $scope.save_permissions = function () {

            var form = $("#permission_form").serialize();
            $.ajax({
                url: $scope.FormAction,
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {

                    if (data['success']) {
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
                }
            });
        };

    });
</script>