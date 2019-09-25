<div class="row"  ng-controller="rep_con">
    <nav class="top-nav">
        <h2 class="page-heading blue-bg">Conversion Report</h2>
    </nav>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel-group panel-group-joined" id="accordion-test"> 
                <div class="panel panel-default" >
                    <div class="panel-heading">
                        <a data-toggle="collapse" id="hideme" data-parent="#accordion-test" href="#collapseOne" class="collapsed">
                            <h3 class="panel-title text-center">
                                <span class="fa  fa-list-alt"></span> Filters</h3>
                        </a>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-9 col-sm-6 col-xs-12  ">
                                    <form class="form-horizontal" id="AdvReportForm" role="form" ng-submit="getAdvReport()"> 
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Timeframe</label>
                                            <div class="col-md-5">

                                                <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                                    <span></span> <b class="caret"></b>
                                                </div>

                                                <script type="text/javascript">
                                                            $(function () {

                                                                // var start = moment().subtract(29, 'days');
                                                                var start = moment().subtract(6, 'days');
                                                                //.subtract(29, 'days');
                                                                var end = moment();
                                                                function cb(start, end) {
                                                                    $("#startDate").val(start.format("D-MM-YYYY"));
                                                                    $("#endDate").val(end.format("D-MM-YYYY"));
                                                                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                                                                }

                                                                $('#reportrange').daterangepicker({
                                                                    startDate: start,
                                                                    endDate: end,
                                                                    ranges: {
                                                                        'Today': [moment(), moment()],
                                                                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                                                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                                                                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                                                                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                                                                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                                                                    },
                                                                    maxDate: new Date()
                                                                }, cb);

                                                                cb(start, end);

                                                            });
                                                </script>


                                                <!--                                                                                        <label class="text-dark col-md-2 text-center"  style="margin: 4px auto"  for="">From</label>-->
                                                <input type="hidden" name="startDate"  style="width: 20%" class="form-control datepicker input-sm col-md-2" id="startDate" placeholder="">

                                                <!--                                                                                        <label class="text-dark col-md-2  text-center" style="margin: 4px auto"  for="">To</label>-->
                                                <input type="hidden" name="endDate"  style="width: 20%" class="form-control  input-sm col-md-2" id="endDate" placeholder="">


                                            </div>






                                        </div>





                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Get Result</label>
                                            <div class="col-md-5">
                                                <?php echo form_dropdown("fileImport", array("" => "In Browser", "excel" => "Excel"), '', "class='form-control select2 '") ?>  

                                            </div>
                                        </div>

                                        <div> 
                                            <input type="hidden" name="select[conversion]" value="conversion"/>
                                            <input type="hidden" name="select[payout]" value="payout"/>
                                        </div>

                                        <div class="form-group"> 
                                            <div class="col-sm-2">
                                            </div>
                                            <div class="col-sm-10">

                                                <button type="submit" id="ReportSubmit" class="btn btn-purple waves-effect waves-light"><span id="waiter" style="display: none" class="fa fa-spin fa-spinner"></span> Generate Report</button>

                                            </div>
                                        </div>

                                    </form>

                                    <form id="combineForm">

                                        <input type="hidden" name="groupby[offer_id]" value="offer_id"/>
                                        <input type="hidden" name="groupby[offer]" value="offer"/>
                                        <input type="hidden" name="groupby[date]" value="date"/>


                                    </form>




                                </div>



                            </div> <!-- panel-body -->
                        </div> <!-- panel -->
                    </div>
                </div> <!-- col -->
            </div>

        </div>


        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"> 
                    <h3 class="panel-title">Report Summery</h3> 
                </div> 
                <div class="panel-body"> 
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-3 text-center">
                        <h4 class="text-uppercase color-title">Conversions</h4>
                        <h2>{{conversion}}</h2>
                    </div>
                    <div class="col-md-3">
                        <h4 class="text-uppercase color-title">Payout</h4>
                        <h2>{{payout}}</h2>
                    </div>
                </div> 
            </div>




            <div id="graphs" style="min-width: 310px; height: 400px; margin: 0 auto;background: white;">


            </div>



        </div>



        <div class="col-md-12 col-sm-12 col-xs-12 ">
            <table class="table table-responsive table-bordered" style="    background: white">
                <thead class="tophead">
                    <tr>
                        <th>#</th>

                        <th ng-repeat="col in coloumnName">
                            {{col_Name(col)}}
                        </th>
    <!--                                            <th>Clicks</th>
                        <th>Conversion</th>
                        <th>Install</th>
                        <th>Event 1</th>
                        <th>Event 2</th>
                        <th>Payout</th>
                        <th>Revenue</th>
                        <th>Profit</th>-->



                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="repo in advance_report">
                        <td>{{ $index + 1}}</td>


                        <td ng-repeat="col in coloumnName">

                            <span ng-if="col != 'Referrer_Page'"> {{repo[col]}}</span>
                            <a ng-if="col == 'Referrer_Page' && repo[col] != ''" href="{{repo[col]}}"><span  class="fa fa-link"></span> {{repo[col]| limitTo:20:0}}</a>
                        </td>
    <!--                                            <td></td>
    
                        <td>{{repo.clicks}}</td>
                        <td>{{repo.conversion}}</td>
                        <td>{{repo.Install}}</td>
                        <td>{{repo.Event_1}}</td>
                        <td>{{repo.Event_2}}</td>
                        <td>{{repo.earn}}</td>
                        <td>{{repo.revCost}}</td>
                        <td>{{repo.profit}}</td>-->

                    </tr>
                </tbody>

            </table>
            <div></div>



        </div>
    </div>
</div>
<script>
    //var report_app = angular.module("report_app", ['ui.bootstrap']);
    viral_pro.controller("rep_con", function ($scope) {

        $scope.FormAction = "<?php echo SITEURL . "advertiser/c_report/getAdvanceReport" ?>";


        $scope.all_report = {};
        $scope.advance_report = {};
        $scope.payout = 0;
        $scope.conversion = 0;

        $scope.coloumnName = {};
//        $scope.getreportbyclick = function () {
//
//            $.ajax({
//                url: $scope.FormAction,
//                type: 'POST',
//                data: 'getReport=1&groupby=date',
//                dataType: 'json',
//                success: function (data, textStatus, jqXHR) {
//
//                    $scope.all_report = data;
//                    $scope.calculate(data);
//                    $scope.$apply();
//                }
//            });
//
//        };
        $scope.col_Name = function (name)
        {
            return name.replace("_", " ");
        };
        $scope.calculate = function (data) {
            $scope.payout = 0;
            $scope.conversion = 0;
            $.each(data, function (index, item) {
                $scope.conversion += parseInt(item.Conversion);
                $scope.payout += parseFloat(item.Payout);


            });
            $scope.$apply();
        };




        $scope.getAdvReport = function () {
            var form = $("#AdvReportForm").serialize();

            form += $("#combineForm").serialize() + "&" + form;
            $("#ReportSubmit").attr("disabled", "true");
            $("#waiter").show();

            $scope.coloumnName = {};
            $scope.advance_report = {};
            $.ajax({
                url: $scope.FormAction,
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {

                    $("#ReportSubmit").removeAttr("disabled");
                    $("#waiter").hide();
                    if (data['success'] == false)
                    {
                        $scope.payout = 0.0;
                        $scope.conversion = 0;
                        return 0;
                    }

                    $("html, body").animate({scrollTop: 0}, 600);
                    $("#hideme").trigger("click");

                    if (typeof data['data'][0] == "undefined")
                    {
                        $('#graphs').html("<p class='if_no_report'><b class='largeit'>OOPS !</b><b><br>It seems you don't have any data for this date range<br>Select Another Date Range</b></p>");

                        $scope.coloumnName = {};
                        $scope.advance_report = {};
                        $scope.payout = 0.0;
                        $scope.conversion = 0;
                    } else
                    {
                        $scope.coloumnName = Object.keys(data['data'][0]);
                        $scope.advance_report = data['data'];
                        $scope.drawGraph(data['graph']['x'], data['graph']['y'], data['graph']['gtype'], data['graph']['sign'], data['graph']['title']);

                        $scope.calculate(data['data']);
                    }

                    $scope.$apply();


                    if (data['filesuccess'])
                    {
                        window.location = data['filedownload'];

                    }

                }
            });

        };


//draw graph
        $scope.drawGraph = function (x, y, gtype, sign, title)
        {
            $('#graphs').highcharts({
                chart: {
                    type: 'spline'
                },
                title: {
                    text: "<b>Conversions Vs Payout</b>",
                    x: -20 //center
                },
                subtitle: {
                    text: '',
                    x: -20
                },
                xAxis: {
                    categories: y
                },
                yAxis: {
                    title: {
                        text: gtype,
                    },
                    plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                },
                tooltip: {
                    valueSuffix: sign,
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: x
            });
        };

//end raph




//        $scope.getreportbyclick();
//        $scope.getAdvReport();
    });


    $(document).ready(function () {
        $("#ReportSubmit").trigger("click");
    });

</script>