<div class="row" >

    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading"><h3 class="panel-title">
                    Global Postback</h3></div>
            <div class="panel-body">

                <div class="col-lg-12"> 
                    <div class="panel-group panel-group-joined" id="accordion-test"> 
                        <div class="panel panel-default"> 
                            <div class="panel-heading"> 
                                <h4 class="panel-title"> 
                                    <a data-toggle="collapse" data-parent="#accordion-test" href="#collapseOne" class="" aria-expanded="true">
                                        Setup Global post back
                                    </a> 
                                </h4> 
                            </div> 
                            <div id="collapseOne" class="panel-collapse collapse in" aria-expanded="true"> 
                                <div class="panel-body">
                                    <div ng-controller="globalpostbact">

                                        <form class="form-horizontal" role="form" id="GlobalPostbackForm" ng-submit="updateGlobalPostback()"> 

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Global Post Back</label>
                                                <div class="col-md-10">
                                                    <input type="text" name="post_back" value="<?php echo isset($post_back['post_back']) ? $post_back['post_back'] : '' ?>"  class="form-control" >
                                                    <input type="hidden" name="uid" value="<?php echo isset($uid) ? $uid : '' ?>"  class="form-control" >
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

                                            $scope.FormAction = "<?php echo SITEURL . "admin/globalpostback/setGlobalPostBack/" ?>";

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





                                </div> 
                            </div> 
                        </div> 

                    </div> 
                </div>

                <!--                 !-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col -->
    </div>
</div>
