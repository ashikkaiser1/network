<div class="col-sm-12"  ng-controller="Goals">
    <div class="panel panel-default" >
        <div class="panel-heading">
            <h3 class="panel-title">
                Goals  
                <div class="pull-right">
                    <ul class="bulkActions">
                        <li><a href="void:javascript" id="ShowGoalForm" class=" btn btn-info waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-plus"></span> Add Goals</a></li>
                    </ul>
                </div>
            </h3></div>
        <div class="panel-body">
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
                                                <a href="<?php echo SITEURL . "advertiser/goals/UpdateGoals/" . $campaign_id . "/" ?>{{goals.offer_goal_id}}">
                                                    {{goals.name}}
                                                </a>
                                            </td>
                                            <td>{{goals.payOutTypeName}}</td>
                                            <td><?php echo CURR  ?> {{goals.revenue_cost}} </td>
<!--                                            <td>{{goals.RevenueTypeName}}</td>
                                            <td>{{goals.revenue_cost}}</td>-->

                                        </tr>
                                    </tbody>
                                </table>

                            </div> <!-- col -->
                            <div ng-if="all_goals == ''" style="text-align: center; font-size: x-large;">
                            No Data Exist!!
                        </div>
                        </div>

                        <?php
                    }

                    $this->load->view("advertiser/offer/create/offer-details/offer_goal_add");
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>






