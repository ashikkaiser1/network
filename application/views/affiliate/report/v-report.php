<div class="row"  ng-controller="rep_con">

    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading"><h3 class="panel-title">
                    Report</h3></div>
            <div class="panel-body">
                <div class="row">




                    <div class="col-md-12 col-sm-12 col-xs-12 ">

                        <ul class="nav nav-tabs tabs" style="width: 100%;">
                            <li class="tab active" style="width: 25%;">
                                <a href="#home-2" data-toggle="tab" aria-expanded="true" ng-click="getreportbyurl()" class="active"> 
                                    <span class="visible-xs"><i class="fa fa-home"></i></span> 
                                    <span class="hidden-xs text-uppercase">Url wise click</span> 
                                </a> 
                            </li> 
                            <li class="tab" style="width: 25%;"> 
                                <a href="#profile-2" data-toggle="tab" aria-expanded="false" ng-click="getreportbyclick()" class=""> 
                                    <span class="visible-xs"><i class="fa fa-user"></i></span> 
                                    <span class="hidden-xs text-uppercase">show clicks & Earning</span> 
                                </a> 
                            </li> 

                            <div class="indicator" style="right: 392px; left: 0px;"></div></ul> 
                        <div class="tab-content"> 
                            <div class="tab-pane active" id="home-2" style="display: block;"> 

                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Link Title</th>
                                            <th>Clicks</th>



                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="repo in all_report_url">
                                            <td>{{ $index + 1}}</td>
                                            <td>{{repo.title}}</td>
                                            <td>{{repo.clicks}}</td>

                                        </tr>
                                    </tbody>

                                </table>
                            </div> 
                            <div class="tab-pane" id="profile-2" style="display: none;">
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Clicks</th>
                                            <th>Earning</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="repo in all_report">
                                            <td>{{ $index + 1}}</td>
                                            <td>{{repo.date}}</td>
                                            <td>{{repo.clicks}}</td>
                                            <td>{{repo.earn}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">

                                            </td>
                                            <td style="font-weight: bold;" class="bold ">Total Clicks : {{clicks}}</td>
                                            <td style="font-weight: bold;" class="bold ">Earning : {{earning}}</td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div> 
                        </div> 










                        <div></div>



                    </div>
                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col -->
    </div>
</div>
<script>
    //var report_app = angular.module("report_app", ['ui.bootstrap']);
    viral_pro.controller("rep_con", function ($scope) {

        $scope.FormAction = "<?php echo SITEURL . "affiliate/report/getReport" ?>";


        $scope.all_report = {};
        $scope.all_report_url = {};
        $scope.earning = 0;
        $scope.clicks = 0;
        $scope.getreportbyclick = function () {

            $.ajax({
                url: $scope.FormAction,
                type: 'POST',
                data: 'getReport=1&groupby=date',
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {

                    $scope.all_report = data;
                    $scope.calculate(data);
                    $scope.$apply();
                }
            });

        };

        $scope.calculate = function (data) {
            $scope.earning = 0;
            $scope.clicks = 0;
            $.each(data, function (index, item) {
                $scope.earning+= parseInt(item.earn);
                $scope.clicks+= parseInt(item.clicks);


            });
            $scope.$apply();
        };

        $scope.getreportbyurl = function () {

            $.ajax({
                url: $scope.FormAction,
                type: 'POST',
                data: 'getReport=1&groupby=post',
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {

                    $scope.all_report_url = data;
                    $scope.$apply();
                }
            });

        };

        $scope.getreportbyclick();
        $scope.getreportbyurl();
    });
</script>