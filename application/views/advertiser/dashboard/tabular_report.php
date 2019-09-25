

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 " ng-controller="rep_con">
    <form class="" id="AdvReportForm" role="form" ng-submit="getAdvReport()" > 

        <input type="hidden" value="offer_id" name="groupby[offer_id]"> 
        <input type="hidden" value="offer" name="groupby[offer]">                                           
<!--        <input type="hidden" value="payout_type" name="groupby[payout_type]">                                          
        <input type="hidden" value="revenue_type" name="groupby[revenue_type]">                                               -->
        <input type="hidden"  value="clicks" name="select[clicks]">                                                 
        <input type="hidden"  value="conversion" name="select[conversion]">                                                 
        <!--<input type="hidden"  value="cost" name="select[cost]">-->                                                 
        <input type="hidden"  value="payout" name="select[payout]">                                                 
        <!--<input type="hidden"  value="profit" name="select[profit]">-->     
        <input type="hidden" value="payout" name="orderby"/>
        <input type="hidden" value="DESC" name="sort"/>
        <input type="hidden" value="1" name="limit"/>

        <!--
                            <input type="checkbox" checked="" value="cpc" name="groupby[cpc]"> CPC                                                
        
                            <input type="checkbox" value="cpa" name="groupby[cpa]"> CPA                                                
        
                            <input type="checkbox" checked="" value="rpc" name="groupby[rpc]"> RPC                                                
        
                            <input type="checkbox" value="rpa" name="groupby[rpa]"> RPA                                                
        
                            <input type="checkbox" value="cpm" name="groupby[cpm]"> CPM                                                
        
                            <input type="checkbox" value="rpm" name="groupby[rpm]"> RPM                                                -->

        <!--
                            <input type="checkbox" value="year" name="groupby[year]"> Year                                                
        
                            <input type="checkbox" value="month" name="groupby[month]"> Month                                                
        
                            <input type="checkbox" value="week" name="groupby[week]"> Week                                                -->

<!--        <input type="hidden"   value="date" name="groupby[date]">                                                 -->
        <!--
                            <input type="checkbox" value="hour" name="groupby[hour]"> Hour                                                -->



        <!--                                        <div class="form-group">
                                                    <label class="col-md-2 control-label">Order By
                                                        <div class="col-md-5">
                                                            <select name="orderby" class="form-control select2  select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                                                <option value="campaign">Campaign</option>
                                                                <option value="uid">Affiliate</option>
                                                                <option value="date">Date</option>
                                                            </select><span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-autocomplete="list" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-orderby-9z-container"><span class="select2-selection__rendered" id="select2-orderby-9z-container" title="Campaign">Campaign</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>  
        
                                                        </div>
                                                </div>-->

        <!--                                        <div class="form-group">
                                                    <label class="col-md-2 control-label">Sort
                                                        <div class="col-md-5">
                                                            <select name="sort" class="form-control select2  select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                                                <option value="ASC">ASC</option>
                                                                <option value="DESC">DESC</option>
                                                            </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-autocomplete="list" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-sort-2k-container"><span class="select2-selection__rendered" id="select2-sort-2k-container" title="ASC">ASC</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>  
        
                                                        </div>
                                                </div>
        
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Get Result
                                                        <div class="col-md-5">
                                                            <select name="fileImport" class="form-control select2  select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                                                <option value="" selected="selected">In Browser</option>
                                                                <option value="excel">Excel</option>
                                                            </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-autocomplete="list" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-fileImport-zd-container"><span class="select2-selection__rendered" id="select2-fileImport-zd-container" title="In Browser">In Browser</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>  
        
                                                        </div>
                                                </div>-->

        <!--                            <div class="form-group">
                                        <label class="col-md-2 control-label">
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
        
          
        
                                                                                                                <div ng-repeat="colum in dataCol">
                                                                                                                    <label>
                                                                                                                        <input type="checkbox" name="colselect[]"  value="{{colum.colVal}}" />
                                                                                                                        {{colum.colNam}}
                                                            
                                                                                                                    
                                                                                                                </div>
        
                                                        </div> 
                                                    </div> 
                                                </div> 
        
        
                                            </div> 
        
                                        </div>
                                    </div>-->


        <button type="submit" id="ReportSubmit" class="btn hidden  btn-purple waves-effect waves-light"> <span id="waiter" style="display: none;" class="fa fa-spin fa-spinner"></span> Generate Report</button>



    </form>

    <div class="tab-content panel"> 
        <div class="tab-pane active" id="home-2" style="display: block;"> 

            <table class="table table-responsive ">
                <thead class="tophead">
                    <tr>
<!--                        <th>#</th>-->

                        <th ng-repeat="col in coloumnName" ng-if="checkColType(col)">
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
<!--                        <td>{{ $index + 1}}</td>-->


                        <td ng-repeat="col in coloumnName" ng-if="checkColType(col)">
                            <a ng-if="col=='Offer_ID' || col == 'Offer_Name'" href="<?php echo SITEURL."advertiser/campaign/offerRequest/" ?>{{repo['Offer_ID']}}">
                                {{repo[col]}}
                            </a>
                            
                            <span ng-if="col !='Offer_ID' && col != 'Offer_Name'"> {{repo[col]}}</span>
                            
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
    <div>
        
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
                $scope.getAdvReport();
        
//       getAdvReport
    });


    $(document).ready(function () {
//        $("#ReportSubmit").trigger("click");
    });

</script>