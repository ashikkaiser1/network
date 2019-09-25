<div class="row"  ng-controller="dashboardCon">

    <div class="col-md-12 panel-success dashTopfilter">
        <div class="col-md-4"></div>
        <div class="col-md-4">
          <div class="form-group">
                <div class="col-md-10 col-xs-12 col-sm-12" style="z-index: 22">
                    <div id="reportrange" class="pull-right" style="cursor: pointer;    padding: 5px 10px;    border: 1px solid #ccc;    width: 100%;    color: black;">
                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                        <span></span> <b class="caret"></b>
                    </div>
                </div>
                <div class="col-md-2 col-xs-12 col-sm-12 ">
                    <button type="button" id="showBtn"ng-click="searchByForm()" class="btn btn-success btn-sm waves-effect waves-light m-l-10"> <span class="fa fa-bar-chart">   </span> Show </button>
                </div>
            </div>
        </div>
    </div>

    <!--    all clicks conversion , earnign-->
    <div class="row text-center">

        <form id="CommonStatsForm">
            <input type="hidden" name="startDate"  style="width: 20%" class="form-control datepicker input-sm col-md-2 startDate"  placeholder="">
            <input type="hidden" name="endDate"  style="width: 20%" class="form-control  input-sm col-md-2 endDate" placeholder="">
        </form>
        <div class="col-md-6 col-sm-6 col-lg-3">
            <div class="panel panel-border panel-purple widget-s-1">
                <div class="panel-heading text-left text-size">Clicks</div>
                <div class="panel-body">
                    <img class="dashImgicon" src="<?php echo ASSETS . "affiliate/icons/301-click.png" ?>"/>
                    <div class="h2 text-purple">{{AllClicks}}</div>
                    <!--<span class="text-muted  pull-right">Clicks </span>-->
                    <!--                    <div class="text-right">
                                            <i class="ion-social-usd fa-2x text-purple"></i>
                                        </div>-->
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6 col-lg-3">
            <div class="panel panel-border panel-pink widget-s-1">
                <div class="panel-heading text-left text-size">Conversions</div>
                <div class="panel-body">
                    <img class="dashImgicon" src="<?php echo ASSETS . "affiliate/icons/301-coin-1.png" ?>"/>
                    <div class="h2 text-pink">{{AllConversion}}</div>
<!--                    <span class="text-muted  pull-right">Conversions </span>-->
                    <!--                    <div class="text-right">
                                            <i class="ion-ios7-cart fa-2x text-pink"></i>
                                        </div>-->
                </div>
            </div>
        </div>


        <div class="col-md-6 col-sm-6 col-lg-3">
            <div class="panel panel-border panel-pink widget-s-1">
                <div class="panel-heading text-left text-size">Conversion Rate</div>
                <div class="panel-body">
                    <img class="dashImgicon" src="<?php echo ASSETS . "affiliate/icons/301-profits.png" ?>"/>
                    <div class="h2 text-pink">{{AllConversionRate| number : 1}} %

                    </div>
                     <!--<span class="text-muted  pull-right">Conversion Rate</span>-->

                    <!--                    <div class="text-right">
                                            <i class="ion-ios7-cart fa-2x text-pink"></i>
                                        </div>-->
                </div>
            </div>
        </div>



        <div class="col-md-6 col-sm-6 col-lg-3">
            <div class="panel panel-border panel-success widget-s-1">
                <div class="panel-heading text-left text-size">Payout</div>
                <div class="panel-body"> 
                    <img class="dashImgicon" src="<?php echo ASSETS . "affiliate/icons/301-calculator-1.png" ?>"/>
                    <div class="h2 text-success">{{AllCost| number : 1}}</div>
<!--                    <span class="text-muted text-muted pull-right">Earning </span>-->
                    <!--                    <div class="text-right">
                                            <i class="ion-eye fa-2x text-success"></i>
                                        </div>-->
                </div>
            </div>
        </div> 

    </div>

    <!--    end of all clicks ,conversion and earning-->








    <div class="row">
        <div class="col-lg-6">
            <div class="portlet"><!-- /portlet heading -->
                <div class="portlet-heading">
                    <div class="col-md-12 col-sm-6 col-xs-12  ">
                        <!--                        search-->
                        <form id="searchForm" class="form-inline row" role="form" >


                            <div class="col-md-10">

                                <?php echo form_multiselect("select[]", $stats, $deafult_select, "class='form-control select2 ' style ='width : 100% !important' ") ?>
                                <input type="hidden" name="groupby[date]" value="date"/>
                                <input type="hidden" name="orderby" value="date"/>
                                <input type="hidden" name="sort" value="ASC"/>



                                <!--                                                                                        <label class="text-dark col-md-2 text-center"  style="margin: 4px auto"  for="">From</label>-->
                                <input type="hidden" name="startDate"  style="width: 20%" class="form-control datepicker input-sm col-md-2 startDate" id="startDate" placeholder="">

                                <!--                                                                                        <label class="text-dark col-md-2  text-center" style="margin: 4px auto"  for="">To</label>-->
                                <input type="hidden" name="endDate"  style="width: 20%" class="form-control  input-sm col-md-2 endDate" id="endDate" placeholder="">
                            </div>




                        </form>
                        <!--end search-->
                    </div>


                    <!--                    <div class="portlet-widgets">
                                            <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                                            <span class="divider"></span>
                                            <a data-toggle="collapse" data-parent="#accordion1" href="#portlet1"><i class="ion-minus-round"></i></a>
                                            <span class="divider"></span>
                                            <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                                        </div>-->
                    <div class="clearfix"></div>
                </div>
                <div id="portlet1" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12">
<!--                                <span class="fa fa-spin fa-spinner"> </span> -->
                                <div id="webstats" style="min-width:100%; height: 400px; margin: 0 auto">


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- /Portlet -->
        </div> <!-- end col -->




        <div class="col-lg-6">
            <div class="portlet"><!-- /portlet heading -->
                <div class="portlet-heading">
                    <div class="col-md-12 col-sm-6 col-xs-12  ">
                        <select class="form-control" ng-model="chartType" ng-change="showMePieChart()">
                            <option selected="true" value="Clicks">Clicks</option>
                            <option value="Conversion">Conversion</option>
                            <option value="Payout">Pay out</option>
                        </select>
                    </div>

                    <div class="clearfix"></div>
                </div>
                <div id="portlet1" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12">

                                <form id="piechartForm">
                                    <input type="hidden" name="groupby[offer_id]" value="offer_id"  />
                                    <input type="hidden" name="groupby[offer]" value="offer"  />
                                    <input type="hidden" name="select[conversion]" value="conversion"  />
                                    <input type="hidden" name="select[clicks]" value="clicks"  />
                                    <input type="hidden" name="select[payout]" value="payout"  />
                                    <input type="hidden" name="select[cpc]" value="payout"  />
                                    <input type="hidden" name="select[payout]" value="payout"  />
                                    <input type="hidden" name="sort" value="DESC">
                                    <input type="hidden" name="limit" value="1">
                                    <input type="hidden" name="offset" value="5">
                                    <!--                                                                                        <label class="text-dark col-md-2 text-center"  style="margin: 4px auto"  for="">From</label>-->
                                    <input type="hidden" name="startDate"  style="width: 20%" class="form-control datepicker input-sm col-md-2 startDate"  placeholder="">

                                    <!--                                                                                        <label class="text-dark col-md-2  text-center" style="margin: 4px auto"  for="">To</label>-->
                                    <input type="hidden" name="endDate"  style="width: 20%" class="form-control  input-sm col-md-2 endDate"  placeholder="">


                                </form>


<!--                                <span class="fa fa-spin fa-spinner"> </span> -->
                                <div id="piecharts" style="min-width:100%; height: 400px; margin: 0 auto">


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- /Portlet -->
        </div> <!-- end col -->

    </div>

    <?php //$this->load->view("affiliate/dashboard/widgets") ?>



</div> <!-- End row -->





<script type="text/javascript">
    $(function () {

        //  var start = moment().subtract(29, 'days');
        var start = moment().subtract(6, 'days');
        //.subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $(".startDate").val(start.format("D-MM-YYYY"));
            $(".endDate").val(end.format("D-MM-YYYY"));
            $('#reportrange span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));

            console.log("Clicked");
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

<script>

    //var dashboard = angular.module("viral_pro", ['ui.bootstrap']);
    //genUrlController
    var dashboardCon = viral_pro.controller("dashboardCon", function ($scope, $timeout) {


        $scope.FormAction = "<?php echo SITEURL . "advertiser/dashboard" ?>";
        $scope.startDate = '';
        $scope.endDate = '';
        //  $scope.graphType = 1;
        $scope.today = 0.0;
        $scope.yesterday = 0.0;
        $scope.month = 0.0;
        $scope.all_piecharts = {};
        $scope.chartType = "Clicks";


//        $scope.$watch('graphType', function () {
//            $scope.getGraphpData($scope.graphType);
//
//        });

        $scope.showMePieChart = function (type) {

            var data = $scope.all_piecharts[$scope.chartType];
            $scope.drawPiechart(data['series'], data['name'], data['tooltip'], 1);
        };
        $scope.searchByForm = function ()
        {
//            $scope.startDate = $("#startDate").val();
//            $scope.endDate = $("#endDate").val();
            //call ajax for line graph datae
            $scope.getGraphpData();

            //calll aja function for piechart data 
            $scope.search_pieChartGraphData();

            //call ajax for top widgets clicks convertion earning conversion rate   
            $scope.getExtraStats();
//            $("#ReportSubmit").trigger("click");
//            call_gettopEarner();
            //call_gettopEarner
            //$scope.getTopEarner();
        };

        $scope.search_pieChartGraphData = function ()
        {
            $("#showBtn").html("<span class='fa fa-spin fa-spinner'>   </span> Showing ");
            var url = '<?php echo SITEURL . "advertiser/c_report/getAdvanceReport" ?>';
            var form = $("#piechartForm").serialize();

            $.ajax({
                url: url,
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_piecharts = data['graph'];
                    //$("#showBtn").html("<span class='fa fa-bar-chart'>   </span> Show ");
                    if (!$.isArray(data['data']) || !data['data'].length)
                    {
                        $('#piecharts').html("<p class='if_no_report'><b class='largeit'>OOPS !</b><b><br>It seems you don't have any data for this date range<br>Select Another Date Range</b></p>");
                    } else
                    {
                        $scope.showMePieChart("Clicks");
                    }
                }
            });
        };


        $scope.getGraphpData = function () {
            // cb(start, end);

//           $("#startDate").val(moment().subtract(29, 'days'));
//            $("#endDate").val(moment());

            $("#showBtn").html("<span class='fa fa-spin fa-spinner'>   </span> Showing ");
            var url = $scope.FormAction + "/getstats";
            var form = $("#searchForm").serialize();

            $.ajax({
                url: url,
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $("#showBtn").html("<span class='fa fa-bar-chart'>   </span> Show ");
                    if (!$.isArray(data['y']) || !data['y'].length)
                    {
                        $('#webstats').html("<p class='if_no_report'><b class='largeit'>OOPS !</b><b><br>It seems you don't have any data for this date range<br>Select Another Date Range</b></p>");
                    } else
                    {
                        $scope.drawGraph(data['x'], data['y'], data['gtype'], data['sign'], data['title']);
                    }
                }
            });
        };


        $scope.getExtraStats = function ()
        {
            var url = "<?php echo SITEURL . "advertiser/dashboard/getcommonStats" ?>";
            var form = $("#CommonStatsForm").serialize();
            $.ajax({
                url: url,
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        if (data['data'][0]['Clicks'] != null)
                            $scope.AllClicks = data['data'][0]['Clicks'];
                        else
                            $scope.AllClicks = 0;

                        if (data['data'][0]['Conversion'] != null)
                            $scope.AllConversion = data['data'][0]['Conversion'];
                        else
                            $scope.AllConversion = 0;
                        if (data['data'][0]['Revenue'] != null)
                            $scope.AllRevenue = data['data'][0]['Revenue'];
                        else
                            $scope.AllRevenue = 0.0;

                        if (data['data'][0]['Payout'] != null)
                            $scope.AllCost = data['data'][0]['Payout'];
                        else
                            $scope.AllCost = 0.0;

                        if (data['data'][0]['CR'] != null)
                            $scope.AllConversionRate = data['data'][0]['CR'];
                        else
                            $scope.AllConversionRate = 0.0;
                        $scope.$apply();
                    }


                }
            });
        };

        $scope.getEarning = function (type)
        {
            var url = "<?php echo SITEURL . "advertiser/dashboard/Earningstats" ?>";
            $.ajax({
                url: url,
                type: 'POST',
                data: "type=" + type,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {

                    if (type == "today")
                    {
                        $scope.today = data['earn'];
                    }
                    if (type == "yesterday")
                    {
                        $scope.yesterday = data['earn'];
                    }
                    if (type == "month")
                    {

                        $scope.month = data['earn'];
                    }
                    $scope.$apply();
                }
            });
        };

        $scope.drawGraph = function (x, y, gtype, sign, title)
        {
            $('#webstats').highcharts({
                chart: {
                    type: 'spline'
                },
                title: {
                    text: title,
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
                    align: 'center',
                    verticalAlign: 'bottom',
                    borderWidth: 0
                },
                series: x
            });
        };






        $scope.drawPiechart = function (series, title, tooltip, index)
        {
            // series = Array.prototype.slice.call(series, 0);
            console.log(series);
//            series = 
            $('#piecharts').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: title
                },
                tooltip: {
                    pointFormat: tooltip
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: true
                    }
                },
                series: [series]
            });

            return true;


        };

        //$timeout(, 2000);
        $scope.autoload_graph = function ()
        {
            $(".startDate").val(moment().subtract(6, 'days'));
            $(".endDate").val(moment());
            $scope.searchByForm();
        };




        $scope.autoload_graph();
        $scope.getEarning('today');
        $scope.getEarning('yesterday');
        $scope.getEarning('month');


    });

</script>

<div class="row">
    
    <?php 
    
     $this->load->view("advertiser/dashboard/tabular_report");
     ?>
</div>
<div class="row">

    <?php
    if (isset($LeaderBorad)) {
        echo $LeaderBorad;
    }
//    $data = array();
//    $data['class'] = 'col-md-6';
//    $this->load->view("advertiser/dashboard/featured_offer_silder", $data);

    $this->load->view("advertiser/dashboard/updates");
   
    
    ?> 
</div>