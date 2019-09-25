

<div class="col-md-12 col-sm-12 col-xs-12 " ng-controller="rep_con">
    <form class="" id="AdvReportForm" role="form" ng-submit="getAdvReport()"> 

        <input type="hidden" value="offer_id" name="groupby[offer_id]"> 
        <input type="hidden" value="offer" name="groupby[offer]">                                           
<!--        <input type="hidden" value="payout_type" name="groupby[payout_type]">                                          
        <input type="hidden" value="revenue_type" name="groupby[revenue_type]">                                               -->
        <input type="hidden"  value="clicks" name="select[clicks]">                                                 
        <input type="hidden"  value="conversion" name="select[conversion]">                                                 
        <input type="hidden"  value="cost" name="select[cost]">                                                 
        <input type="hidden"  value="revenue" name="select[revenue]">                                                 
        <input type="hidden"  value="profit" name="select[profit]">     
        <input type="hidden" value="conversion" name="orderby"/>
        <input type="hidden" value="DESC" name="sort"/>
        <input type="hidden" value="1" name="limit"/>
 <button type="submit" id="ReportSubmit" style="display: none;" >  </button>





    <div class="tab-content panel"> 
    <div class="col-md-12">
         <div class="col-md-4">
                                    <div class="">
                                        <div class="col-md-12">
                                        <div id="reportrange1" class="pull-right" style="cursor: pointer;    padding: 5px 10px;    border: 1px solid #ccc;    width: 100%;    color: black;">
                                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                                <span></span> <b class="caret"></b>
                                            </div>


 <input type="hidden" name="startDate"  style="width: 20%" class="form-control datepicker input-sm col-md-2" id="startDate1" placeholder="">
 <input type="hidden" name="endDate"  style="width: 20%" class="form-control  input-sm col-md-2" id="endDate1" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2    ">
                                    <button type="submit" id="showBtn" class="btn btn-success btn-sm waves-effect waves-light m-l-10"> <span class="fa fa-bar-chart">   </span> Show </button>
                                </div>
                            </div>  
        <div class="tab-pane active" id="home-2" style="display: block;"> 

            <table class="table table-responsive ">
 </form>
                <thead class="tophead">
                    <tr>


                        <th ng-repeat="col in coloumnName" ng-if="checkColType(col)">
                            {{col_Name(col)}}
                        </th>


                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="repo in advance_report">



                        <td ng-repeat="col in coloumnName" ng-if="checkColType(col)">
                            <a ng-if="col=='Offer_ID' || col == 'Offer_Name'" href="<?php echo SITEURL."admin/campaign/offerRequest/" ?>{{repo['Offer_ID']}}">
                                {{repo[col]}}
                            </a>
                            
                            <span ng-if="col !='Offer_ID' && col != 'Offer_Name'"> {{repo[col]}}</span>
                            
                        </td>


                    </tr>
                </tbody>

            </table>
        </div> 

    </div> 

<script type="text/javascript">
    $(function () {

        //  var start = moment().subtract(29, 'days');
        var start = moment().subtract(6, 'days');
        //.subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $("#startDate1").val(start.format("D-MM-YYYY"));
            $("#endDate1").val(end.format("D-MM-YYYY"));
            $('#reportrange1 span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
        }

        $('#reportrange1').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

    });
</script>








    <div></div>



</div>
<script>
    //var report_app = angular.module("report_app", ['ui.bootstrap']);
    viral_pro.controller("rep_con", function ($scope) {

        $scope.FormAction = "<?php echo SITEURL . "admin/report/getAdvanceReport" ?>";


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

//            $("#ReportSubmit").attr("disabled", "true");
//            $("#waiter").show();
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

                    // $("html, body").animate({scrollTop: 0}, 600);
                    // $("#hideme").trigger("click");
                    $scope.coloumnName = Object.keys(data['data'][0]);
                    $scope.advance_report = data['data'];
                    $scope.$apply();

                    if (data['filesuccess'])
                    {
                        window.location = data['filedownload'];

                    }

                }
            });

        };
        
        $scope.checkColType = function (name)
        {
            return !name.includes("RR");
        };



        //        $scope.getreportbyclick();
        //        $scope.getAdvReport();
    });


    $(document).ready(function () {
        $("#ReportSubmit").trigger("click");
    });

</script>