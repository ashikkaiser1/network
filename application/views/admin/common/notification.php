<li id="App2" class="dropdown hidden-xs" ng-controller="noti_controller">
    <a href="#" ng-click="readNotification()" data-target="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
        <i class="md md-notifications"></i> <span class="badge badge-xs badge-danger">{{totla_new_noti}}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-lg" >
        <li class="text-center notifi-title">Notification</li>
        <li class="list-group">
            <!-- list item-->
            <div ng-repeat="noti in notification" href="{{noti.link}}" class="list-group-item notification_box">
                <div class="media">
                    <!--                    <div class="pull-left">
                                            <em class="fa fa-user-plus fa-2x text-info"></em>
                                        </div>-->
                    <div class="media-body clearfix ">
                        <div class="media-heading">{{noti.title}}</div>
                        <div  ng-bind-html="reder_html(noti.description)"> 
                        </div>
                    </div>
                </div>
            </div>

            <!-- last list item -->
            <a href="<?php echo SITEURL . "admin/notification/allNotification/" ?>" class="list-group-item">
                <small>See all notifications</small>
            </a>
        </li>
    </ul>
</li>

<script>

    function approve(request_id, uid, campaign_id)
    {

        //offer approved and 
        swal({
            title: "Are you sure?",
            text: "Offer will be approved for Affiliate!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn btn-sm btn-danger waves-effect waves-light",
            confirmButtonText: "Yes, Approve it!",
            closeOnConfirm: true,
            closeOnCancel: true
        },
                function (isConfirm) {
                    if (isConfirm)
                    {
                        $.ajax({
                            url: "<?php echo SITEURL . "admin/campaign/approve_offer_request" ?>",
                            type: 'POST',
                            data: "request_id=" + request_id + "&uid=" + uid + "&campaign_id=" + campaign_id,
                            dataType: 'json',
                            success: function (data, textStatus, jqXHR) {
                                if (data['success'])
                                {
                                    $.Notification.autoHideNotify('success',
                                            'botton right',
                                            data['msg'],
                                            '');
                                    $("#tr" + request_id).remove();
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
    }


    function reject(request_id, uid, campaign_id)
    {
        //offer reject
        swal({
            title: "Are you sure?",
            text: "Offer will be rejected for Affiliate!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn btn-sm btn-danger waves-effect waves-light",
            confirmButtonText: "Yes, Reject it!",
            closeOnConfirm: true,
            closeOnCancel: true
        },
                function (isConfirm) {
                    if (isConfirm)
                    {
                        $.ajax({
                            url: "<?php echo SITEURL . "admin/campaign/reject_offer_request" ?>",
                            type: 'POST',
                            data: "request_id=" + request_id + "&uid=" + uid + "&campaign_id=" + campaign_id,
                            dataType: 'json',
                            success: function (data, textStatus, jqXHR) {
                                if (data['success'])
                                {
                                    $.Notification.autoHideNotify('success',
                                            'botton right',
                                            data['msg'],
                                            '');
                                    $("#tr" + request_id).remove();
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
    }

    function ChangeStausAPIToken(usr_token_id, status)
    {
        swal({
            title: "Are you sure?",
            //text: "Offer will be approved for Affiliate!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn btn-sm btn-success waves-effect waves-light",
            confirmButtonText: "Yes, Continue it!",
            closeOnConfirm: true,
            closeOnCancel: true
        },
                function (isConfirm) {
                    if (isConfirm)
                    {



                        $.ajax({
                            url: "<?php echo SITEURL . "admin/api_token/ChangeUsrTokenStatus" ?>",
                            type: 'POST',
                            //  data: "usr_token_id=" + usr_token_id + "&status=" + status,
                            data: "usr_token_id=" + usr_token_id + "&status=" + status,
                            dataType: 'json',
                            success: function (data, textStatus, jqXHR) {
                                if (data['success'])
                                {
                                    $.Notification.autoHideNotify('success',
                                            'botton right',
                                            data['msg'],
                                            '');


//                                $("#tr" + request_id).remove();
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
    }




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
                        $scope.totla_new_noti = data['new_notification'];
                        $scope.$apply();
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