
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->                      
           <div class="page-wrapper" ng-controller="dashboardCon">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                
                </div>
                <div class="p-r-20">
                <div id="reportrange" class="input-group bootstrap-touchspin"  style="cursor: pointer;    padding: 5px 10px;    border: 1px solid #ccc;    width: 100%;    color: black;">
                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                        <span></span> <b class="caret"></b>
                    </div></div>
                    <div class="col-md-2 col-xs-12 col-sm-12 ">
                    <button type="button" id="showBtn"ng-click="searchByForm()" class="btn btn-success btn-sm waves-effect waves-light m-l-10"> <span class="fa fa-bar-chart">   </span> Show </button>
                </div>
                
               
            </div>
 <div class="container-fluid">
<div class="row">
      
                    <!-- Column -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            
                            <div class="card-body">
                                <div class="card-title">Clicks </div>
                                <!-- Row -->
                                <div class="row">
                                      <div class="col-lg-4 col-md-6">Today</div>
                                      <div class="col-lg-4 col-md-6">Yday</div>
                                      <div class="col-lg-4 col-md-6">MTD</div>
                                    </div>
                                    <div class="row">
                                      <div class="col-lg-4 col-md-6">{{TodayClicks}}</div>
                                      <div class="col-lg-4 col-md-6">{{EdayClicks}}</div>
                                      <div class="col-lg-4 col-md-6">{{MTDClicks}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     
                    
                    <!-- Column -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            
                            <div class="card-body">
                                <div class="card-title">Conversion </div>
                                <!-- Row -->
                                <div class="row">
                                      <div class="col-lg-4 col-md-6">Today</div>
                                      <div class="col-lg-4 col-md-6">Yday</div>
                                      <div class="col-lg-4 col-md-6">MTD</div>
                                    </div>
                                    <div class="row">
                                      <div class="col-lg-4 col-md-6">{{TodayConversion}}</div>
                                      <div class="col-lg-4 col-md-6">{{EdayConversion}}</div>
                                      <div class="col-lg-4 col-md-6">{{MTDConversion}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                        <div class="card">
                            
                            <div class="card-body">
                                <div class="card-title">Payout </div>
                                <!-- Row -->
                                <div class="row">
                                      <div class="col-lg-4 col-md-6">Today</div>
                                      <div class="col-lg-4 col-md-6">Yday</div>
                                      <div class="col-lg-4 col-md-6">MTD</div>
                                    </div>
                                    <div class="row">
                                      <div class="col-lg-4 col-md-6">{{TodayCost}}</div>
                                      <div class="col-lg-4 col-md-6">{{EdayCost}}</div>
                                      <div class="col-lg-4 col-md-6">{{MTDCost}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                  
                     
                </div>
   




    <div class="row">
        <div class="col-lg-6">
            <div class="card"><!-- /portlet heading -->
                <div class="card-body">
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
 
                    </div>
 
                    <div class="clearfix"></div>
                </div>
                <div id="portlet1" class="panel-collapse collapse in">
                    <div class="card-body">
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
            <div class="card"><!-- /portlet heading -->
                <div class="card-body">
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
                    <div class="card-body">
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


 
                                <div id="piecharts" style="min-width:100%; height: 400px; margin: 0 auto">


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- /Portlet -->
        </div> <!-- end col -->
<?php
    if (isset($LeaderBorad)) {
        echo $LeaderBorad;
    }
    $data = array();
    $data['class'] = 'col-md-6';
    $this->load->view("affiliate/dashboard/featured_offer_silder", $data);

    $this->load->view("affiliate/dashboard/updates");
    ?> 
</div>



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


        $scope.FormAction = "<?php echo SITEURL . "affiliate/dashboard" ?>";
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
            $scope.getTodayStats();
            $scope.getEdayStats();
            $scope.getMTDStats();
            call_gettopEarner();
            //call_gettopEarner
            //$scope.getTopEarner();
        };

        $scope.search_pieChartGraphData = function ()
        {
            $("#showBtn").html("<span class='fa fa-spin fa-spinner'>   </span> Showing ");
            var url = '<?php echo SITEURL . "affiliate/c_report/getAdvanceReport" ?>';
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
            var url = "<?php echo SITEURL . "affiliate/dashboard/getcommonStats" ?>";
            var thisYear = (new Date()).getFullYear();    
var start = new Date("1/1/" + thisYear);
var startDate = moment(start.valueOf()).format("YYYY-MM-D");
            
//            start.format("D-MM-YYYY")
            var endDate =moment().format("YYYY-MM-D");
            $.ajax({
                url: url,
                type: 'POST',
                data: 'startDate='+startDate+'&endDate='+endDate,
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

                        if (data['data'][0]['Cost'] != null)
                            $scope.AllCost = data['data'][0]['Cost'];
                        else
                            $scope.AllCost = 0.0;

                        if (data['data'][0]['CR'] != null)
                            $scope.AllConversionRate = data['data'][0]['CR'];
                        else
                        {
                            $scope.AllConversionRate = ($scope.AllConversion / $scope.AllClicks) * 100;

                            console.log($scope.AllConversionRate);
                        }

                        $scope.$apply();
                    }


                }
            });
        };
        
        $scope.getTodayStats = function ()
        {
            var url = "<?php echo SITEURL . "affiliate/dashboard/getcommonStats" ?>";
            var startDate =moment().subtract(6, 'years').format("YYYY-MM-D");
//            start.format("D-MM-YYYY")
            var endDate =moment().format("YYYY-MM-D");
            $.ajax({
                url: url,
                type: 'POST',
                 data: 'startDate='+endDate+'&endDate='+endDate,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        if (data['data'][0]['Clicks'] != null)
                            $scope.TodayClicks = data['data'][0]['Clicks'];
                        else
                            $scope.TodayClicks = 0;

                        if (data['data'][0]['Conversion'] != null)
                            $scope.TodayConversion = data['data'][0]['Conversion'];
                        else
                            $scope.TodayConversion = 0;
                        if (data['data'][0]['Revenue'] != null)
                            $scope.TodayRevenue = data['data'][0]['Revenue'];
                        else
                            $scope.TodayRevenue = 0.0;

                        if (data['data'][0]['Cost'] != null)
                            $scope.TodayCost = data['data'][0]['Cost'];
                        else
                            $scope.TodayCost = 0.0;

                        if (data['data'][0]['CR'] != null)
                            $scope.TodayConversionRate = data['data'][0]['CR'];
                        else
                        {
                            $scope.TodayConversionRate = ($scope.TodayConversion / $scope.TodayClicks) * 100;

                            console.log($scope.TodayConversionRate);
                        }

                        $scope.$apply();
                    }


                }
            });
        };
        $scope.getEdayStats = function ()
        {
            var url = "<?php echo SITEURL . "affiliate/dashboard/getcommonStats" ?>";
            var startDate =moment().subtract(1, 'days').format("YYYY-MM-D");
//            start.format("D-MM-YYYY")
            var endDate =moment().subtract(1, 'days').format("YYYY-MM-D");
            $.ajax({
                url: url,
                type: 'POST',
                 data: 'startDate='+startDate+'&endDate='+endDate,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        if (data['data'][0]['Clicks'] != null)
                            $scope.EdayClicks = data['data'][0]['Clicks'];
                        else
                            $scope.EdayClicks = 0;

                        if (data['data'][0]['Conversion'] != null)
                            $scope.EdayConversion = data['data'][0]['Conversion'];
                        else
                            $scope.EdayConversion = 0;
                        if (data['data'][0]['Revenue'] != null)
                            $scope.EdayRevenue = data['data'][0]['Revenue'];
                        else
                            $scope.EdayRevenue = 0.0;

                        if (data['data'][0]['Cost'] != null)
                            $scope.EdayCost = data['data'][0]['Cost'];
                        else
                            $scope.EdayCost = 0.0;

                        if (data['data'][0]['CR'] != null)
                            $scope.EdayConversionRate = data['data'][0]['CR'];
                        else
                        {
                            $scope.EdayConversionRate = ($scope.EdayConversion / $scope.EdayClicks) * 100;

                            console.log($scope.EdayConversionRate);
                        }

                        $scope.$apply();
                    }


                }
            });
        };
        $scope.getMTDStats = function ()
        {
            var url = "<?php echo SITEURL . "affiliate/dashboard/getcommonStats" ?>";
            var startDate =moment().startOf('month').format("YYYY-MM-D");
//            start.format("D-MM-YYYY")
           var endDate =moment().endOf('month').format("YYYY-MM-D");
            $.ajax({
                url: url,
                type: 'POST',
                 data: 'startDate='+startDate+'&endDate='+endDate,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        if (data['data'][0]['Clicks'] != null)
                            $scope.MTDClicks = data['data'][0]['Clicks'];
                        else
                            $scope.MTDClicks = 0;

                        if (data['data'][0]['Conversion'] != null)
                            $scope.MTDConversion = data['data'][0]['Conversion'];
                        else
                            $scope.MTDConversion = 0;
                        if (data['data'][0]['Revenue'] != null)
                            $scope.MTDRevenue = data['data'][0]['Revenue'];
                        else
                            $scope.MTDRevenue = 0.0;

                        if (data['data'][0]['Cost'] != null)
                            $scope.MTDCost = data['data'][0]['Cost'];
                        else
                            $scope.MTDCost = 0.0;

                        if (data['data'][0]['CR'] != null)
                            $scope.MTDConversionRate = data['data'][0]['CR'];
                        else
                        {
                            $scope.MTDConversionRate = ($scope.MTDConversion / $scope.MTDClicks) * 100;

                            console.log($scope.MTDConversionRate);
                        }

                        $scope.$apply();
                    }


                }
            });
        };

        $scope.getEarning = function (type)
        {
            var url = "<?php echo SITEURL . "affiliate/dashboard/Earningstats" ?>";
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
