<div class="col-md-12 col-sm-12 col-xs-12">
   
    <div class="table-responsive table  table-hover">
        <table class="table">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Name</th>
                    <th>Payout Type</th>
                    <th>Payout Cost</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                <tr ng-repeat="goals in all_goals| filter :name " id="tr{{goals.offer_goal_id}}">
                    <td>{{goals.offer_goal_id}}</td>
                    <td>
                        <span titile='Active' ng-if="goals.off_goal_status == 1" class='fa fa-circle text-success'></span>
                        <span titile='De-Activated' ng-if="goals.off_goal_status == 0" class='fa fa-circle text-danger'></span>

                        {{goals.name}}


                    </td>
                    <td> {{goals.payOutTypeName}}</td>
                    <td> {{goals.revenue_cost}}</td>

                    <td>
                        <a type="button" href="<?php echo SITEURL . "advertiser/goals/UpdateGoals/" ?>{{goals.campaign_id}}/{{goals.offer_goal_id}} " class="btn btn-primary waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span></a>

                        <button type="button" ng-click="delete_offer_goal(goals.offer_goal_id)" class="btn btn-danger waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-trash"></span></button>
                    </td>

                </tr>

            </tbody>
        </table>
    </div>


</div>