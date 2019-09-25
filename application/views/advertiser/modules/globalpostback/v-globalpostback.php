<div ng-controller="globalpostbact">

    <form class="form-horizontal" role="form" id="GlobalPostbackForm" ng-submit="updateGlobalPostback()"> 

        <div class="form-group">
            <label class="col-md-2 control-label">Global Post Back</label>
            <div class="col-md-10">
                <input type="text" name="post_back" value="<?php echo isset($post_back['post_back']) ? $post_back['post_back'] : '' ?>"  class="form-control" >
            </div>
        </div>          
        <div class="form-group"> 
            <div class="col-sm-2">
            </div>
            <div class="col-sm-10">

                <button type="submit" class="btn btn-purple waves-effect waves-light">{{saveBtn}}</button>
                <button type="Reset" class="btn btn-danger waves-effect waves-light">Cancel</button>
            </div>
        </div>

    </form>
</div>

<script>
    // var setting_app = angular.module("setting_app", ['ui.bootstrap']);
    viral_pro.controller("globalpostbact", function ($scope) {

        $scope.FormAction = "<?php echo SITEURL . "advertiser/gateway/index/setGlobalpostback" ?>";

        $scope.saveBtn = "Save";

        $scope.updateGlobalPostback = function ()
        {
            var form = $("#GlobalPostbackForm").serialize();
            $.ajax({
                url: $scope.FormAction,
                data: form,
                type: 'POST',
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
                }

            });
        };

    });
</script>



