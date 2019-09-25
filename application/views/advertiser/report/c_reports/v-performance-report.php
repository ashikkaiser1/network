<div class="row"  ng-controller="rep_con">
    <nav class="top-nav">
        <h2 class="page-heading blue-bg">Performance Report</h2>
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
                                        <div class="form-group hidden">
                                            <label class="col-md-2 control-label">Data</label>
                                            <div class="col-md-10">
                                                <?php
                                                foreach ($dataCol as $key => $val) {
                                                    ?>
                                                    <label class="col-md-4" style="font-weight: normal" >
                                                        <input type="checkbox" <?php echo isset($pre_checked_options[$key]) ? "checked=''" : '' ?> value="<?php echo $key ?>" name="groupby[<?php echo $key ?>]"/> <?php echo $val ?>
                                                    </label>
                                                    <?php
                                                }
                                                ?>


                                                <?php //echo form_multiselect("groupby[]", $GroupBy, '', "class='form-control select2 '") ?>  

                                            </div>
                                        </div>
                                        <?php
                                        if (isset($global_goal)) {
                                            ?>
                                            <div class="form-group m-t-20 hidden">
                                                <label class="col-md-2 control-label">Goals</label>
                                                <div class="col-md-10">
                                                    <?php
                                                    foreach ($global_goal as $key => $val) {
                                                        ?>
                                                        <label class="col-md-4" style="font-weight: normal" >
                                                            <input type="checkbox" <?php echo isset($pre_checked_options[$key]) ? "checked=''" : '' ?> value="<?php echo $key ?>" name="goals[<?php echo $val ?>]"/> <?php echo $val ?>
                                                        </label>
                                                        <?php
                                                    }
                                                    ?>


                                                    <?php //echo form_multiselect("groupby[]", $GroupBy, '', "class='form-control select2 '") ?>  

                                                </div>
                                            </div>

                                        <?php } ?>


                                        <div class="form-group m-t-20 hidden">
                                            <label class="col-md-2 control-label">Statistics</label>
                                            <div class="col-md-10">
                                                <?php
                                                foreach ($stats as $key => $val) {
                                                    ?>
                                                    <label class="col-md-4" style="font-weight: normal" >
                                                        <input type="checkbox" <?php echo isset($pre_checked_options[$key]) ? "checked=''" : '' ?> value="<?php echo $key ?>" name="select[<?php echo $key ?>]"/> <?php echo $val ?>
                                                    </label>
                                                    <?php
                                                }
                                                ?>


                                                <?php //echo form_multiselect("groupby[]", $GroupBy, '', "class='form-control select2 '") ?>  

                                            </div>
                                        </div>


                                        <div class="form-group m-t-20 hidden">
                                            <label class="col-md-2 control-label">Calculations</label>
                                            <div class="col-md-10">
                                                <?php
                                                foreach ($calculation as $key => $val) {
                                                    ?>
                                                    <label class="col-md-4" style="font-weight: normal" >
                                                        <input type="checkbox" <?php echo isset($pre_checked_options[$key]) ? "checked=''" : '' ?> value="<?php echo $key ?>" name="groupby[<?php echo $key ?>]"/> <?php echo $val ?>
                                                    </label>
                                                    <?php
                                                }
                                                ?>


                                                <?php //echo form_multiselect("groupby[]", $GroupBy, '', "class='form-control select2 '") ?>  

                                            </div>
                                        </div>

                                        <div class="form-group m-t-20 hidden">
                                            <label class="col-md-2  control-label">Interval</label>
                                            <div class="col-md-10">
                                                <?php
                                                foreach ($interval as $key => $val) {
                                                    ?>
                                                    <label class="col-md-4 "  style="font-weight: normal" >
                                                        <input type="checkbox" <?php echo isset($pre_checked_options[$key]) ? "checked=''" : '' ?> value="<?php echo $key ?>" name="groupby[<?php echo $key ?>]"/> <?php echo $val ?>
                                                    </label>
                                                    <?php
                                                }
                                                ?>


                                                <?php //echo form_multiselect("groupby[]", $GroupBy, '', "class='form-control select2 '") ?>  

                                            </div>
                                        </div>









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

                                        <div class="form-group hidden">
                                            <label class="col-md-2 control-label">Order By</label>
                                            <div class="col-md-5">
                                                <?php echo form_dropdown("orderby", $OrderBy, 'date', "class='form-control select2 '") ?>  

                                            </div>
                                        </div>

                                        <div class="form-group hidden">
                                            <label class="col-md-2 control-label">Sort</label>
                                            <div class="col-md-5">
                                                <?php echo form_dropdown("sort", $SortOrder, 'ASC', "class='form-control select2 '") ?>  

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Get Result</label>
                                            <div class="col-md-5">
                                                <?php echo form_dropdown("fileImport", array("" => "In Browser", "excel" => "Excel"), '', "class='form-control select2 '") ?>  
                                            </div>
                                        </div>

                                        <!--                            <div class="form-group">
                                                                        <label class="col-md-2 control-label"></label>
                                                                        <div class="col-md-10">
                                                                            <div class="panel-group panel-group-joined" id="accordion-test"> 
                                                                                <div class="panel panel-default"> 
                                                                                    <div class="panel-heading"> 
                                                                                        <h4 class="panel-title"> 
                                                                                            <a data-toggle="collapse" data-parent="#accordion-test" href="#collapseOne" class="collapsed">
                                                                                                Select Data Fields
                                                                                            </a> 
                                                                                        </h4> 
                                                                                    </div> 
                                                                                    <div id="collapseOne" class="panel-collapse collapse"> 
                                                                                        <div class="panel-body">
                                        
                                        <?php
//                                                  $grp_by = array_chunk($GroupBy, 4);
//                                                  
//                                                  echo "<pre>";
//                                                  print_r($grp_by);
//                                                  
                                        ?>  
                                        
                                                                                                                                                <div ng-repeat="colum in dataCol">
                                                                                                                                                    <label>
                                                                                                                                                        <input type="checkbox" name="colselect[]"  value="{{colum.colVal}}" />
                                                                                                                                                        {{colum.colNam}}
                                                                                            
                                                                                                                                                    </label>
                                                                                                                                                </div>
                                        
                                                                                        </div> 
                                                                                    </div> 
                                                                                </div> 
                                        
                                        
                                                                            </div> 
                                        
                                                                        </div>
                                                                    </div>-->







                                        <div class="form-group"> 
                                            <div class="col-sm-2">
                                            </div>
                                            <div class="col-sm-10">

                                                <button type="submit" id="ReportSubmit" class="btn btn-purple waves-effect waves-light"><span id="waiter" style="display: none" class="fa fa-spin fa-spinner"></span> Generate Report</button>

                                            </div>
                                        </div>

                                    </form>


                                </div>



                            </div> <!-- panel-body -->
                        </div> <!-- panel -->
                    </div>
                </div> <!-- col -->
            </div>

        </div>

        <div class="col-md-12 col-sm-12 col-xs-12 ">
            <div class="tab-content panel"> 
                <div class="tab-pane active" id="home-2" style="display: block;"> 
                    <div id="portlet1" class="panel-collapse collapse in">
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-12">
    <!--                                <span class="fa fa-spin fa-spinner"> </span> -->
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
                </div>
            </div>
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
        $scope.earning = 0;
        $scope.clicks = 0;
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
            $scope.earning = 0;
            $scope.clicks = 0;
            $.each(data, function (index, item) {
                $scope.earning += parseInt(item.earn);
                $scope.clicks += parseInt(item.clicks);
            });
            $scope.$apply();
        };
        $scope.getAdvReport = function () {
            var form = $("#AdvReportForm").serialize();
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
                        return 0;
                    }

                    $("html, body").animate({scrollTop: 0}, 600);
                    $("#hideme").trigger("click");
                    if (typeof data['data'][0] == "undefined")
                    {
                        $('#graphs').html("<p class='if_no_report'><b class='largeit'>OOPS !</b><b><br>It seems you don't have any data for this date range<br>Select Another Date Range</b></p>");
                    } else
                    {
                        $scope.coloumnName = Object.keys(data['data'][0]);
                        $scope.advance_report = data['data'];
                        $scope.drawGraph(data['graph']['x'], data['graph']['y'], data['graph']['gtype'], data['graph']['sign'], data['graph']['title']);
                    }

                    $scope.$apply();
                    if (data['filesuccess'])
                    {
                        window.location = data['filedownload'];
                    }
                }
            });
        };
        $scope.drawGraph = function (x, y, gtype, sign, title)
        {
            $('#graphs').highcharts({
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
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: x
            });
        };
        //        $scope.getreportbyclick();
        //        $scope.getAdvReport();
    });
    $(document).ready(function () {
        $("#ReportSubmit").trigger("click");
    });
</script>