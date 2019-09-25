

<div class="col-lg-6">
    <div class="panel panel-border panel-info" id="App2" ng-controller="noti_controller">
        <div class="panel-heading"> 
            <h3 class="panel-title">Updates

                <div class="pull-right">
                    <a href="#" ng-click="readNotification()" data-target="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                        <i class="md md-notifications"></i> <span class="badge badge-xs badge-danger">{{totla_new_noti}}</span>
                    </a>
                </div>
            </h3> 
        </div> 
        <div class="panel-body"> 

            <div class="row">


                <ul class="col-md-12 list-unstyled" >
               
                    <li class="list-group">
                        <!-- list item-->
                        <a ng-repeat="noti in notification" href="{{noti.link}}" class="list-group-item">
                            <div class="media">
                                <!--                    <div class="pull-left">
                                                        <em class="fa fa-user-plus fa-2x text-info"></em>
                                                    </div>-->
                                <div class="media-body clearfix">
                                    <!--                        <div class="media-heading">{{noti.title}}</div>-->
                                    <div  ng-bind-html="reder_html(noti.description)"> 
                                    </div>
                                </div>
                            </div>
                        </a>

                        <!-- last list item -->
                        <a href="<?php echo SITEURL."advertiser/dashboard/updates" ?>" class="list-group-item">
                            <small>See all notifications</small>
                        </a>
                    </li>
                </ul> 
            </div>
        </div> 
    </div>
</div>



<script>


    // var notification = angular.module("viral_pro",['ui.bootstrap']);
// var notification = angular.module("viral_pro",['ui.bootstrap']);
    viral_pro.filter("trustUrl", ['$sce', function ($sce) {
            return function (recordingUrl) {
                return $sce.trustAsResourceUrl(recordingUrl);
            };
        }]);
    viral_pro.controller("noti_controller", function ($scope, $sce, $interval) {

        //alert("hi");
        $scope.totla_new_noti = 0;
        $scope.notification = {};

        $scope.getNewNotification_count = function ()
        {
            $.ajax({
                url: "<?php echo SITEURL . "notif/notification/count_new_notification" ?>",
                type: 'POST',
                data: "getNot=1",
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
//                        $scope.notification = data['notification'];
                        if (data['new_notification'] !== "0")
                        {
                            $scope.totla_new_noti = data['new_notification'];
                            console.log("NOti");
                            $scope.$apply();
                        }

                    }
                }
            });
        };

        $scope.getNotification = function () {
            $.ajax({
                url: "<?php echo SITEURL . "notif/notification/getNotification" ?>",
                type: 'POST',
                data: "getNot=1",
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $scope.notification = data['notification'];
                        // $scope.totla_new_noti = data['new_notification'];
                        $scope.$apply();
                    }
                }
            });
        };
        $interval($scope.getNewNotification_count, 10000);


        $scope.sub_des = function (desc)
        {
            return desc.substring(0, 30);
        };

        $scope.readNotification = function ()
        {

            $.ajax({
                url: "<?php echo SITEURL . "notif/notification/i_read_notification" ?>",
                type: 'POST',
                data: "getNot=1",
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $scope.totla_new_noti = data['new_notification'];
                        $scope.$apply();
                        $scope.getNotification();
                    }
                }
            });


        };
        $scope.reder_html = function (html) {


            return $sce.trustAsHtml(html);

        };








        $scope.getNotification();
        $scope.getNewNotification_count();

    });
    // angular.bootstrap(document.getElementById("App2"), ['notification']);
    // angular.bootstrap(document.getElementById("App2"), ['notification']);
</script>