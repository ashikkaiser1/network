<div class="col-sm-12"  ng-controller="Goals">
    <div class="card" >
            <div class="card-header">
                        <h3 class="card-title">Goals</h3>

                        </div>
        <div class="card-body">
            <div class="row">
                <div>
                    <?php
                    if (!empty($campaign)) {
                        ?>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <table class="table table-responsive">
                                    <thead>
                                        <tr>
                                            <th>#ID</th>
                                            <th>Name</th>
                                            <th>Payout Type</th>
                                            <th>Payout</th>
    <!--                                            <th>Revenue Type</th>
                                            <th>Revnue</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="goals in all_goals" id="tr{{goals.offer_goal_id}}">
                                            <td>{{goals.offer_goal_id}}
                                            </td>
                                            <td>
                                                {{goals.name}}
                                            </td>
                                            <td>{{goals.payOutTypeName}}</td>
                                            <td><?php echo CURR ?> {{goals.payout_cost}}</td>

                            <!--                                            <td>{{goals.RevenueTypeName}}</td>
                                                                        <td>{{goals.revenue_cost}}</td>-->

                                        </tr>
                                    </tbody>
                                </table>

                            </div> <!-- col -->
                        </div>
                        <div ng-if="all_goals == ''" style="text-align: center; font-size: x-large;">
                            No Data Exist!!
                        </div>
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //var Category = angular.module("Category", []);
    viral_pro.controller("Goals", function ($scope) {

        $scope.message = "";
        $scope.saveBtn = "Save";
        $scope.all_goals = <?php echo json_encode($offer_goals) ?>;


    });
</script>






