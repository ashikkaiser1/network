<div class="card" id="topEarnersCon" ng-controller="topEarner" >
<form id="topearnerForm">
<input type="hidden" name="startDate"  style="width: 20%" class="form-control datepicker input-sm col-md-2 startDate"  placeholder="">
<input type="hidden" name="endDate"  style="width: 20%" class="form-control  input-sm col-md-2 endDate"  placeholder="">
</form>
</div>

<script>
    
    function call_gettopEarner()
    {
      //   angular.element(document.getElementById('topEarnersCon')).scope().getTopEarner();
    }
    
    var topEarner = viral_pro.controller("topEarner", function ($scope) {
        $scope.FormAction = "<?php echo SITEURL . "affiliate/gateway/index/topearner" ?>";
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