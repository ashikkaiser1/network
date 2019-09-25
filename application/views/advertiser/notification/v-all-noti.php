<div class="row" id="App2" ng-controller="noti_controller" >

    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading"><h3 class="panel-title">
                    Updates </h3></div>
            <div class="panel-body">

                <div class="row">


                    <ul class="col-md-12 list-unstyled" >

                        <li class="list-group">
                            <!-- list item-->
                            <a ng-repeat="noti in notification" href="{{noti.link}}" class="list-group-item col-md-12">
                                <div class="col-md-2">
                                    <div class="bottom-calander">
                                        <div class="font18">
                                            {{noti.n_date}}
                                        </div>
                                        <div class="font10 ">
                                            {{noti.n_monnth}} {{noti.n_year}}
                                        </div>
                                    </div>
                                </div>
                                <div class="media col-md-9">
                                    <!--                    <div class="pull-left">
                                                            <em class="fa fa-user-plus fa-2x text-info"></em>
                                                        </div>-->
                                    <div class="media-body clearfix">
                                        <!--                        <div class="media-heading">{{noti.title}}</div>-->
                                        <div  ng-bind-html="reder_html(noti.description)"> 
                                        </div>

                                        <div class="datetimesize"  >
                                            {{about_time_ago(noti.add_date)}}
                                        </div>
                                    </div>
                                </div>
                            </a>


                        </li>
                    </ul> 
                </div>

                <!--                 !-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col -->
    </div>
</div>

<script>

</script>

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

        $scope.about_time_ago = function (add_date)
        {



////--------first code starts
////            split time and fetch time from index 1
//            var a = add_date.split(" ");
//            var time = a[1];
//            var date = moment(add_date).format("DD-MM-YYYY");
//            var current_dateandtime = moment(new Date()).format("DD-MM-YYYY HH:mm:ss");
//
//            var days = moment.utc(moment(current_dateandtime, "DD-MM-YYYY").diff(moment(date, "DD-MM-YYYY"))).format("DD");
//            var months = moment.utc(moment(current_dateandtime, "DD-MM-YYYY").diff(moment(date, "DD-MM-YYYY"))).format("MM");
//            var years = moment.utc(moment(current_dateandtime, "DD-MM-YYYY").diff(moment(date, "DD-MM-YYYY"))).format("yy");
//
//            var hours = moment.utc(moment(current_dateandtime, "HH:mm:ss").diff(moment(time, "HH:mm:ss"))).format("hh");
//            var minutes = moment.utc(moment(current_dateandtime, "HH:mm:ss").diff(moment(time, "HH:mm:ss"))).format("mm");
//            var seconds = moment.utc(moment(current_dateandtime, "HH:mm:ss").diff(moment(time, "HH:mm:ss"))).format("ss");
////--------first code ends



//--------second code start
//            var diffTime = moment('2017-05-01T16:22:12')
//                    .diff('2017-04-19T13:22:27');
//            var duration = moment.duration(diffTime);
//            var years = duration.years(),
//                    days = duration.days(),
//                    hrs = duration.hours(),
//                    mins = duration.minutes(),
//                    seconds = duration.seconds();
//
//            var div = document.createElement('div');
//            div.innerHTML = years + ' years ' + days + ' days ' + hrs + ' hrs ' + mins + ' mins ' + secs + ' sec';
//            document.body.appendChild(div);


//            var old_date = moment(add_date).format("YYYY-MM-DD");
//            var old_time = moment(add_date).format("HH:mm:ss");
//
//            var current_date = moment(new Date()).format("YYYY-MM-DD");
//            var current_time = moment(new Date()).format("HH:mm:ss");
//
//            var diffTime = moment(current_date + 'T' + current_time).diff(old_date + 'T' + old_time);
//            var duration = moment.duration(diffTime);
//            var years = duration.years(),
//                    months = duration.months(),
//                    days = duration.days(),
//                    hours = duration.hours(),
//                    minutes = duration.minutes(),
//                    seconds = duration.seconds();


//--------second code ends


////--------third code start
//            var old_date = moment(add_date).format("YYYY-MM-DD");
//            var old_time = moment(add_date).format("HH:mm:ss");
//
//            var current_date = moment(new Date()).format("YYYY-MM-DD");
//            var current_time = moment(new Date()).format("HH:mm:ss");
//
//            var diffTime = moment(current_date + 'T' + current_time).diff(old_date + 'T' + old_time);
//            var duration = moment.duration(diffTime);
//            var days = Math.trunc(duration.asDays()),
//                    hours = duration.hours(),
//                    minutes = duration.minutes(),
//                    seconds = duration.seconds();
//            if (days > 30)
//            {
//                months = Math.trunc(days / 30);
//                days = Math.trunc(days % 30);
//            }
//            if(months > 12)
//            {
//                years = Math.trunc(months/12);
//                months = Math.trunc(months%12);
//            }
////--------third code ends


//--------fourth code starts
//            var old_date = moment(add_date).format("YYYY-MM-DD");
//            var old_time = moment(add_date).format("HH:mm:ss");
//
//            var current_date = moment(new Date()).format("YYYY-MM-DD");
//            var current_time = moment(new Date()).format("HH:mm:ss");

//            var old_date = moment(add_date).format("ddd MMM DD YYYY HH:mm:ss") + " GMT+0530 (India Standard Time)";
            var olddate = moment(add_date).format("YYYY-MM-DD HH:mm:ss");
//            alert(old_date);
            var old_date = new Date(olddate);
            var current_date = new Date();
//             alert(current_date);
            var one_day = 1000 * 60 * 60 * 24;

            // Convert both dates to milliseconds
//            var date1_ms = old_date.getTime();
//            var date2_ms = current_date.getTime();

            // Calculate the difference in milliseconds
//            var difference_ms = date2_ms - date1_ms;
            var difference_ms = current_date - old_date;
            // alert(difference_ms);

            var seconds = Math.trunc(difference_ms / 1000);
            var mill_sec = difference_ms % 1000;
            //          console.log("before seconds = " + seconds + ", millsec = " + mill_sec);
            if (seconds >= 60)
            {
                var minutes = Math.trunc(seconds / 60);
                seconds = seconds % 60;
            }   //        console.log("after min = " + minutes + ", sec = " + seconds);
            if (minutes >= 60)
            {
                var hours = Math.trunc(minutes / 60);
                minutes = minutes % 60;
            }
            var years, months;
            if (hours >= 24)
            { //var days = Math.round(hours / 24);
                var days = Math.trunc(difference_ms / one_day);
//                console.log(days);

                hours = hours % 24;
            }
            if (days >= 30)
            {
                var months = Math.round(days / 30);
//                 months--;
                days = (days % 30);
            }
            if (months >= 12)
            {
                var years = Math.round(months / 12);
                months = months % 12;
            }


//alert();
            // Convert back to days and return
//            return Math.round(difference_ms / one_day)+" days";
//--------fourth code ends


            var str = 'about ';

            if (years > 0)
                str += years + " years ";
            if (--months > 0)
                str += months + " months ";
            if (days > 0)
                str += days + " days ";
            if (hours > 0)
                str += hours + " hours ";
            if (minutes > 0)
                str += minutes + " minutes ";
            if (seconds > 0)
                str += seconds + " seconds ";

            return str + " ago";

//            return years + " years, " + months + "m " + days  + "d " + hours + "h " + minutes + "m " + seconds + "s";

        };


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
