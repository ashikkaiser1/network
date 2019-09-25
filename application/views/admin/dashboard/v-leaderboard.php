<div class="col-md-4">
    <div class="panel panel-border panel-success" ng-controller="topEarner" >
        <div class="panel-heading"> 
            <h3 class="panel-title">Top Earners</h3> 
        </div> 
        <div class="panel-body"> 
           
            
            <div  ng-if="all_earners==''"style="text-align: center;font-size: larger" class="text-danger text-center">
                            Sorry, there is no data currently
           </div>
            
            <table class="table">

                <tbody>
                    <tr ng-repeat="earner in all_earners"> 
                        <td><a href="<?php echo SITEURL."admin/users/ViewUser/" ?>{{earner.uid}}">{{earner.name}}</a></td>
                        <td> <?php echo CURR ?> {{earner.earn}}</td>
                    </tr>
                </tbody>

            </table>
        </div> 
    </div>
</div>

<script>
    var topEarner = viral_pro.controller("topEarner", function ($scope) {
        $scope.FormAction = "<?php echo SITEURL . "admin/leaderboard/getTopEarners" ?>";
        $scope.all_earners = {};
        $scope.getTopEarner = function () {
            var url = $scope.FormAction;
            $.ajax({
                url: url,
                type: 'POST',
                data: "",
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_earners = data['topEarner'];
                    $scope.$apply();
                }
            });
        };

      
        $scope.getTopEarner();

    });

</script>