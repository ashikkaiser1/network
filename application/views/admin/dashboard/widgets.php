<style>
        .vnative-card {
    box-shadow: 0 4px 8px 0 rgba(0,0,0,.2);
    transition: .3s;
}
.card-box {
    padding: 20px;
    border: 1px solid rgba(54, 64, 74, 0.08);
    -webkit-border-radius: 5px;
    border-radius: 5px;
    -moz-border-radius: 5px;
    background-clip: padding-box;
    margin-bottom: 20px;
    background-color: #ffffff;
}
* {
    outline: none !important;
}
*, ::after, ::before {
    box-sizing: inherit;
}
    .dash-heading {
    font-size: 18px;
    font-weight: 500;
    margin-bottom: 20px;
}
.text-primary {
    color: #7266ba !important;
}
    .m-t-15 {
    margin-top: 15px !important;
}
.list-inline {
    padding-left: 0;
    list-style: none;
}
    .widget-chart ul li {
    width: 31.5%;
    display: inline-block;
    padding: 0px;
}
</style>
<div class="row" ng-controller="widgets">
<div class="col-md-3 col-sm-6 col-lg-4">
 	<div class="card-box vnative-card">
		<h4 class="text-primary header-title m-t-0 dash-heading"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i> &nbsp;Clicks</h4>
		
		<div class="widget-chart text-center">
			<ul class="list-inline m-t-15">
				<li>
				 <h5 class="text-muted font-16">Today</h5>
				 <h4 class="mb-0 counter">{{TodayClicks}}</h4>
				</li>
				<li>
				 <h5 class="text-muted font-16">Yesterday</h5>
				 <h4 class="mb-0 counter">{{EdayClicks}}</h4>
				</li>
				<li>
				 <h5 class="text-muted font-16" data-toggle="tooltip" data-placement="top" data-original-title="Month to date">MTD</h5>
				 <h4 class="mb-0 counter">{{MTDClicks}}</h4>
				</li>
			</ul>
		</div>
	</div>
         
  </div>
    
 <div class="col-md-3 col-sm-6 col-lg-3">
 	<div class="card-box vnative-card">
		<h4 class="text-primary header-title m-t-0 dash-heading"><i class="fa fa-check" aria-hidden="true"></i> &nbsp;CONVERSIONS</h4>
		
		<div class="widget-chart text-center">
			<ul class="list-inline m-t-15">
				<li>
				 <h5 class="text-muted font-16">Today</h5>
				 <h4 class="mb-0 counter">{{TodayConversion}}</h4>
				</li>
				<li>
				 <h5 class="text-muted font-16">Yesterday</h5>
				 <h4 class="mb-0 counter">{{EdayConversion}}</h4>
				</li>
				<li>
				 <h5 class="text-muted font-16" data-toggle="tooltip" data-placement="top" data-original-title="Month to date">MTD</h5>
				 <h4 class="mb-0 counter">{{MTDConversion}}</h4>
				</li>
			</ul>
 	</div>

</div>
</div>
<div class="col-md-3 col-sm-6 col-lg-4">
 	<div class="card-box vnative-card">
		<h4 class="text-primary header-title m-t-0 dash-heading"><i class="fa fa-users" aria-hidden="true"></i> &nbsp;PAYOUT</h4>
		
		<div class="widget-chart text-center">
			<ul class="list-inline m-t-15">
				<li>
				 <h5 class="text-muted font-16">Today</h5>
				 <h4 class="mb-0 counter">{{TodayCost}}</h4>
				</li>
				<li>
				 <h5 class="text-muted font-16">Yesterday</h5>
				 <h4 class="mb-0 counter">{{EdayCost}}</h4>
				</li>
				<li>
				 <h5 class="text-muted font-16" data-toggle="tooltip" data-placement="top" data-original-title="Month to date">MTD</h5>
				 <h4 class="mb-0 counter">{{MTDCost}}</h4>
				</li>
			</ul>
		</div>
 </div>
</div>

 <div class="col-md-3 col-sm-6 col-lg-4">
 	<div class="card-box vnative-card">
		<h4 class="text-primary header-title m-t-0 dash-heading"><i class="fa fa-money" aria-hidden="true"></i> &nbsp;PROFIT</h4>
		
		<div class="widget-chart text-center">
			<ul class="list-inline m-t-15">
				<li>
				 <h5 class="text-muted font-16">Today</h5>
				 <h4 class="mb-0 counter">{{TodayProfit}}</h4>
				</li>
				<li>
				 <h5 class="text-muted font-16">Yesterday</h5>
				 <h4 class="mb-0 counter">{{EdayProfit}}</h4>
				</li>
				<li>
				 <h5 class="text-muted font-16" data-toggle="tooltip" data-placement="top" data-original-title="Month to date">MTD</h5>
				 <h4 class="mb-0 counter">{{MTDProfit}}</h4>
				</li>
			</ul>
		</div>
 </div>
</div>
 
<div class="col-md-3 col-sm-6 col-lg-3">
 	<div class="card-box vnative-card">
		<h4 class="text-primary header-title m-t-0 dash-heading"><i class="fa fa-money" aria-hidden="true"></i> &nbsp;REVENUE</h4>
		
		<div class="widget-chart text-center">
			<ul class="list-inline m-t-15">
				<li>
				 <h5 class="text-muted font-16">Today</h5>
				 <h4 class="mb-0 counter">{{TodayRevenue}}</h4>
				</li>
				<li>
				 <h5 class="text-muted font-16">Yesterday</h5>
				 <h4 class="mb-0 counter">{{EdayRevenue}}</h4>
				</li>
				<li>
				 <h5 class="text-muted font-16" data-toggle="tooltip" data-placement="top" data-original-title="Month to date">MTD</h5>
				 <h4 class="mb-0 counter">{{MTDRevenue}}</h4>
				</li>
			</ul>
		</div>
 </div>
</div>
<div class="col-md-3 col-sm-6 col-lg-4">
 	<div class="card-box vnative-card">
		<h4 class="text-primary header-title m-t-0 dash-heading"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i> &nbsp;YTD Report</h4>
		
		<div class="widget-chart text-center">
			<ul class="list-inline m-t-15">
				<li>
				 <h5 class="text-muted font-16">Click</h5>
				 <h4 class="mb-0 counter">{{AllClicks}}</h4>
				</li>
				<li>
				 <h5 class="text-muted font-16">Conversion</h5>
				 <h4 class="mb-0 counter">{{AllRevenue}}</h4>
				</li>
				<li>
				 <h5 class="text-muted font-16" data-toggle="tooltip" data-placement="top" data-original-title="Month to date">Revenue</h5>
				 <h4 class="mb-0 counter">{{AllRevenue}}</h4>
				</li>
			</ul>
		</div>
 </div>
</div>
 

 
        

 

</div>



<script>

    //var dashboard = angular.module("viral_pro", ['ui.bootstrap']);
    //genUrlController
    viral_pro.controller("widgets", function ($scope) {


        $scope.FormAction = "<?php echo SITEURL . "admin/dashboard/" ?>";
        $scope.users = '';
        $scope.campaign = '';
        $scope.visitors = '';
        $scope.clicks = '';


        $scope.getUsers = function ()
        {
            var url = $scope.FormAction + "getTotalUsers";
            $.ajax({
                url: url,
                type: 'POST',
                data: 'getdata=1',
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.users = data['data'];
                    $scope.$apply();
                }
            });

        };

        $scope.getExtraStats = function ()
        {
            var thisYear = (new Date()).getFullYear();    
var start = new Date("1/1/" + thisYear);
var startDate = moment(start.valueOf()).format("YYYY-MM-D");
            
//            start.format("D-MM-YYYY")
            var endDate =moment().format("YYYY-MM-D");
            var url = $scope.FormAction + "getcommonStats";
            $.ajax({
                url: url,
                type: 'POST',
                data: 'startDate='+startDate+'&endDate='+endDate,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        if(data['data'][0]['Clicks'] == null){
                            $scope.AllClicks = 0;
                        }else
                        {
                            $scope.AllClicks = data['data'][0]['Clicks'];
                        }
                        
                        if(data['data'][0]['Conversion'] == null){
                            $scope.AllConversion = 0;
                        }else
                        {
                            $scope.AllConversion = data['data'][0]['Conversion'];
                        }
                        
                        
                        $scope.AllRevenue = data['data'][0]['Revenue'];
                        $scope.AllCost = data['data'][0]['Cost'];
                        $scope.AllProfit = data['data'][0]['Profit'];
                        $scope.$apply();
                    }


                }
            });
        };
        ////rrgdfgdsfgsdfgdfg
$scope.getTodayStats = function ()
        {
            var startDate =moment().subtract(6, 'years').format("YYYY-MM-D");
//            start.format("D-MM-YYYY")
            var endDate =moment().format("YYYY-MM-D");
            var url = $scope.FormAction + "getcommonStats";
            $.ajax({
                url: url,
                type: 'POST',
                data: 'startDate='+endDate+'&endDate='+endDate,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        if(data['data'][0]['Clicks'] == null){
                            $scope.TodayClicks = 0;
                        }else
                        {
                            $scope.TodayClicks = data['data'][0]['Clicks'];
                        }
                        
                        if(data['data'][0]['Conversion'] == null){
                            $scope.TodayConversion = 0;
                        }else
                        {
                            $scope.TodayConversion = data['data'][0]['Conversion'];
                        }
                        
                        
                        $scope.TodayRevenue = data['data'][0]['Revenue'];
                        $scope.TodayCost = data['data'][0]['Cost'];
                        $scope.TodayProfit = data['data'][0]['Profit'];
                        $scope.$apply();
                    }


                }
            });
        };
///dghfgh
$scope.getEdayStats = function ()
        {
            var startDate =moment().subtract(1, 'days').format("YYYY-MM-D");
//            start.format("D-MM-YYYY")
            var endDate =moment().subtract(1, 'days');
            var url = $scope.FormAction + "getcommonStats";
            $.ajax({
                url: url,
                type: 'POST',
                data: 'startDate='+startDate+'&endDate='+startDate,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        if(data['data'][0]['Clicks'] == null){
                            $scope.EdayClicks = 0;
                        }else
                        {
                            $scope.EdayClicks = data['data'][0]['Clicks'];
                        }
                        
                        if(data['data'][0]['Conversion'] == null){
                            $scope.EdayConversion = 0;
                        }else
                        {
                            $scope.EdayConversion = data['data'][0]['Conversion'];
                        }
                        
                        
                        $scope.EdayRevenue = data['data'][0]['Revenue'];
                        $scope.EdayCost = data['data'][0]['Cost'];
                        $scope.EdayProfit = data['data'][0]['Profit'];
                        $scope.$apply();
                    }


                }
            });
        };
///dghfgh
////rrgdfgdsfgsdfgdfg
$scope.getMTDStats = function ()
        {
            var startDate =moment().startOf('month').format("YYYY-MM-D");
//            start.format("D-MM-YYYY")
            var endDate =moment().endOf('month').format("YYYY-MM-D");
            var url = $scope.FormAction + "getcommonStats";
            $.ajax({
                url: url,
                type: 'POST',
                data: 'startDate='+startDate+'&endDate='+endDate,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        if(data['data'][0]['Clicks'] == null){
                            $scope.MTDClicks = 0;
                        }else
                        {
                            $scope.MTDClicks = data['data'][0]['Clicks'];
                        }
                        
                        if(data['data'][0]['Conversion'] == null){
                            $scope.MTDConversion = 0;
                        }else
                        {
                            $scope.MTDConversion = data['data'][0]['Conversion'];
                        }
                        
                        
                        $scope.MTDRevenue = data['data'][0]['Revenue'];
                        $scope.MTDCost = data['data'][0]['Cost'];
                        $scope.MTDProfit = data['data'][0]['Profit'];
                        $scope.$apply();
                    }


                }
            });
        };
///dghfgh
        $scope.getClicks = function ()
        {
            var url = $scope.FormAction + "getTotalClicks";
            $.ajax({
                url: url,
                type: 'POST',
                data: 'getdata=1',
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {

                    $scope.clicks = data['data'];
                    $scope.$apply();
                }
            });
        };

        $scope.getVisiors = function ()
        {
            var url = $scope.FormAction + "getVisitors";
            $.ajax({
                url: url,
                type: 'POST',
                data: 'getdata=1',
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.visitors = data['data'];
                    $scope.$apply();
                }
            });
        };

        $scope.getCampaign = function ()
        {
            var url = $scope.FormAction + "getCampaign";
            $.ajax({
                url: url,
                type: 'POST',
                data: 'getdata=1',
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.campaign = data['data'];
                    $scope.$apply();
                }
            });
        };

        ///code for today ,yesterday,month earning

        $scope.getEarning = function (type)
        {
            var url = "<?php echo SITEURL . "admin/dashboard/Earningstats" ?>";
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

        $scope.getEarning('today');
        $scope.getEarning('yesterday');
        $scope.getEarning('month');

        ///end of code


//
//        $scope.$watch('graphType', function () {
//            $scope.getGraphpData($scope.graphType);
//
//        });

        $scope.getClicks();
        $scope.getVisiors();
        $scope.getUsers();
        $scope.getCampaign();
        $scope.getExtraStats();
        $scope.getTodayStats();
        $scope.getEdayStats();
        $scope.getMTDStats();
    });

</script>
