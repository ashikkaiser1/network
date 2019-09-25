<div class="col-lg-6">
    <div class="panel panel-border panel-success" id="topEarnersCon" ng-controller="topEarner" >
        <form id="topearnerForm">
 
            <!--                                                                                        <label class="text-dark col-md-2 text-center"  style="margin: 4px auto"  for="">From</label>-->
            <input type="hidden" name="startDate"  style="width: 20%" class="form-control datepicker input-sm col-md-2 startDate"  placeholder="">

            <!--                                                                                        <label class="text-dark col-md-2  text-center" style="margin: 4px auto"  for="">To</label>-->
            <input type="hidden" name="endDate"  style="width: 20%" class="form-control  input-sm col-md-2 endDate"  placeholder="">
        </form>
        <div class="panel-heading"> 
            <h3 class="panel-title">Leader Board</h3> 
        </div> 
        <div class="panel-body"> 
            <table class="table">

                <tbody>
                    <tr ng-repeat="earner in all_earners"> 
                        <td>XXXX</td>
                        <td><?php echo CURR ?> {{earner.earn}}</td>
                    </tr>
                </tbody>

            </table>
        </div> 
    </div>
</div>

<script>
    
    function call_gettopEarner()
    {
      //   angular.element(document.getElementById('topEarnersCon')).scope().getTopEarner();
    }
    
    var topEarner = viral_pro.controller("topEarner", function ($scope) {
        $scope.FormAction = "<?php echo SITEURL . "advertiser/gateway/index/topearner" ?>";
        $scope.all_earners = {};
        $scope.getTopEarner = function () {
            var url = $scope.FormAction;
            $.ajax({
                url: url,
                type: 'POST',
                data: $("#topearnerForm").serialize(),
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