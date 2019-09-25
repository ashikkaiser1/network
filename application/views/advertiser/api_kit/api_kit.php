<div class="row"  ng-controller="api_kit">
    <nav class="top-nav">
        <h2 class="page-heading blue-bg">Api Kit</h2>
    </nav>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel-group panel-group-joined" id="accordion-test"> 
                <div class="panel panel-default" >
                    <div class="panel-body">
                        
                      <h1 class="text-center">Comming Soon</h1>
                        <!--                        <a data-toggle="collapse" id="hideme" data-parent="#accordion-test" href="#collapseOne" class="collapsed">
                                                    <h3 class="panel-title text-center">
                                                        <span class="fa  fa-list-alt"></span> Filters</h3>
                                                </a>-->
                    </div>
                    <!--                    <div id="collapseOne" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-9 col-sm-6 col-xs-12  ">
                                                        <form> tag  if needed then copy and paste it from performance report  
                                                    </div>
                                                </div>  panel-body 
                                            </div>  panel 
                                        </div>-->
                </div> <!-- col -->
            </div>
        </div>

        <!--    <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="tab-content panel"> 
                    <div class="tab-pane active" id="home-2" style="display: block;"> 
                        <div id="portlet1" class="panel-collapse collapse in">
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="fa fa-spin fa-spinner"> </span> 
                                        <div id="graphs" style="min-width: 310px; height: 400px; margin: 0 auto">
        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-responsive table-bordered">
                            <thead class="tophead">
                                <tr>
                                    <th>#</th>
                                    <th ng-repeat="col in coloumnName">
                                        {{col_Name(col)}}
                                    </th>
                                                    <th>Clicks</th>
                                    <th>Conversion</th>
                                    <th>Install</th>
                                    <th>Event 1</th>
                                    <th>Event 2</th>
                                    <th>Payout</th>
                                    <th>Revenue</th>
                                    <th>Profit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="repo in advance_report">
                                    <td>{{ $index + 1}}</td>
        
        
                                    <td ng-repeat="col in coloumnName">
        
                                        <span ng-if="col != 'Referrer_Page'"> {{repo[col]}}</span>
                                        <a ng-if="col == 'Referrer_Page' && repo[col] != ''" href="{{repo[col]}}"><span  class="fa fa-link"></span> {{repo[col]| limitTo:20:0}}</a>
                                    </td>
                                                    <td></td>
        
                                    <td>{{repo.clicks}}</td>
                                    <td>{{repo.conversion}}</td>
                                    <td>{{repo.Install}}</td>
                                    <td>{{repo.Event_1}}</td>
                                    <td>{{repo.Event_2}}</td>
                                    <td>{{repo.earn}}</td>
                                    <td>{{repo.revCost}}</td>
                                    <td>{{repo.profit}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div></div>
            </div>-->
    </div>
</div>
<script>
    //var report_app = angular.module("report_app", ['ui.bootstrap']);
    viral_pro.controller("api_kit", function ($scope) {

//        $scope.FormAction = "<?php // echo SITEURL . "advertiser/c_report/getAdvanceReport" ?>";
//
//
//        $scope.all_report = {};
//        $scope.advance_report = {};
//        $scope.earning = 0;
//        $scope.clicks = 0;
//        $scope.coloumnName = {};
////        $scope.getreportbyclick = function () {
////
////            $.ajax({
////                url: $scope.FormAction,
////                type: 'POST',
////                data: 'getReport=1&groupby=date',
////                dataType: 'json',
////                success: function (data, textStatus, jqXHR) {
////
////                    $scope.all_report = data;
////                    $scope.calculate(data);
////                    $scope.$apply();
////                }
////            });
////
////        };
//        $scope.col_Name = function (name)
//        {
//            return name.replace("_", " ");
//        };
//        $scope.calculate = function (data) {
//            $scope.earning = 0;
//            $scope.clicks = 0;
//            $.each(data, function (index, item) {
//                $scope.earning += parseInt(item.earn);
//                $scope.clicks += parseInt(item.clicks);
//
//
//            });
//            $scope.$apply();
//        };
//
//        $scope.getAdvReport = function () {
//            var form = $("#AdvReportForm").serialize();
//
//            $("#ReportSubmit").attr("disabled", "true");
//            $("#waiter").show();
//
//            $scope.coloumnName = {};
//            $scope.advance_report = {};
//            $.ajax({
//                url: $scope.FormAction,
//                type: 'POST',
//                data: form,
//                dataType: 'json',
//                success: function (data, textStatus, jqXHR) {
//
//                    $("#ReportSubmit").removeAttr("disabled");
//                    $("#waiter").hide();
//                    if (data['success'] == false)
//                    {
//                        return 0;
//                    }
//
//                    $("html, body").animate({scrollTop: 0}, 600);
//                    $("#hideme").trigger("click");
//
//
//                    if (typeof data['data'][0] == "undefined")
//                    {
//                        $('#graphs').html("<p class='if_no_report'><b class='largeit'>OOPS !</b><b><br>It seems you don't have any data for this date range<br>Select Another Date Range</b></p>");
//                    } else
//                    {
//                        $scope.coloumnName = Object.keys(data['data'][0]);
//                        $scope.advance_report = data['data'];
//                        $scope.drawGraph(data['graph']['x'], data['graph']['y'], data['graph']['gtype'], data['graph']['sign'], data['graph']['title']);
//                    }
//
//                    $scope.$apply();
//                    
//                    if (data['filesuccess'])
//                    {
//                        window.location = data['filedownload'];
//                    }
//                }
//            });
//
//        };
//
//        $scope.drawGraph = function (x, y, gtype, sign, title)
//        {
//            $('#graphs').highcharts({
//                chart: {
//                    type: 'spline'
//                },
//                title: {
//                    text: title,
//                    x: -20 //center
//                },
//                subtitle: {
//                    text: '',
//                    x: -20
//                },
//                xAxis: {
//                    categories: y
//                },
//                yAxis: {
//                    title: {
//                        text: gtype,
//                    },
//                    plotLines: [{
//                            value: 0,
//                            width: 1,
//                            color: '#808080'
//                        }]
//                },
//                tooltip: {
//                    valueSuffix: sign,
//                },
//                legend: {
//                    layout: 'vertical',
//                    align: 'right',
//                    verticalAlign: 'middle',
//                    borderWidth: 0
//                },
//                series: x
//            });
//        };
//
//
//
////        $scope.getreportbyclick();
////        $scope.getAdvReport();
//    });
//
//
//    $(document).ready(function () {
//        $("#ReportSubmit").trigger("click");
    });

</script>