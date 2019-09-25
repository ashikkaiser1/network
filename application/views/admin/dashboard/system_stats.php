<div class="col-lg-4">
    <div class="panel panel-border panel-success" ng-controller="system_stats" >
        <div class="panel-heading"> 
            <h3 class="panel-title">System Stats</h3> 
        </div> 
        <div class="panel-body"> 
            <table class="table">

                <tbody>
                    <tr> 
                        <td>
                            Users
                        </td>
                        <td>
                            {{users}}
                        </td>
                    </tr>

                    <tr> 
                        <td>
                            Campaigns
                        </td>
                        <td>
                            {{campaign}}
                        </td>
                    </tr>
                    <tr> 
                        <td>
                            Unique Visitors
                        </td>
                        <td>
                            {{visitors}}
                        </td>
                    </tr>
                </tbody>

            </table>
        </div> 
    </div>
</div>


<script>

    //var dashboard = angular.module("viral_pro", ['ui.bootstrap']);
    //genUrlController
    viral_pro.controller("system_stats", function ($scope) {


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
            var url = $scope.FormAction + "getcommonStats";
            $.ajax({
                url: url,
                type: 'POST',
                data: 'startDate=2016-01-01&endDate=2017-04-01',
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $scope.AllClicks = data['data'][0]['Clicks'];
                        $scope.AllConversion = data['data'][0]['Conversion'];
                        $scope.AllRevenue = data['data'][0]['Revenue'];
                        $scope.AllCost = data['data'][0]['Cost'];
                        $scope.$apply();
                    }


                }
            });
        };

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


//
//        $scope.$watch('graphType', function () {
//            $scope.getGraphpData($scope.graphType);
//
//        });

        $scope.getClicks();
        $scope.getVisiors();
        $scope.getUsers();
        $scope.getCampaign();
        //$scope.getExtraStats();
    });

</script>