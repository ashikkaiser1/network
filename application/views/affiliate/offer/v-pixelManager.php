<div class="" id="postbackManagerController"  ng-controller="postbackManager">
    <div class="col-sm-12">
        <div class="card" >
            <div class="card-header">
                        <h3 class="card-title"> All Landing Pages</h3>

                        </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 m-t-10 m-b-10 ">
                        <form id="postbackForm" class="form-horizontal"  role="form">

                            <input type="hidden" name="campaign_id" value="{{campaign_id}}"/>


                            <div class="form-group">
                                <label class="col-md-2 control-label">Type</label>
                                <div class="col-md-10">
                                    <?php echo form_dropdown("p_type", $p_type, isset($link['p_type']) ? $link['p_type'] : '', "ng-model='post_back.offer_postback.p_type' class='form-control'") ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12 control-label">Code/Url</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" rows="3"  ng-model="post_back.offer_postback.post_back" name="post_back"></textarea>
                                </div>
                            </div>
                            <div class="form-group" ng-if="GoalList != null">
                                <div class="col-md-12 form-group  text-center" ng-init="show_goal = 0" >
                                    <button ng-class=" show_goal == 1 ? 'btn-primary' : 'btn-default'" class="btn  btn-sm" ng-click="show_goal = show_goal == 1 ? 0 : 1">Goal Conversion Pixel Setting</button>
                                </div>
                                <div class="col-md-12" ng-if="show_goal == 1">

                                    <div class="row">
                                        <div class="col-md-12" ng-repeat="goals in GoalList">

                                            <div class="panel panel-default">
                                                <div class="panel-heading"> 
                                                    <h3 class="panel-title">{{goals.name}}</h3> 
                                                </div> 
                                                <div class="panel-body"> 

                                                    <div class="col-md-5">
                                                        <label>Goal ID</label>
                                                        <input type="text"  disabled="" class="form-control text-center" value="{{goals.offer_goal_id}}" placeholder="">
                                                    </div>
                                                    <div class="">
                                                        <input type="hidden" name="goals[{{ $index}}][goal_id]" value="{{goals.offer_goal_id}}"/>
                                                        <input type="hidden" name="goals[{{ $index}}][campaign_id]" value="{{campaign_id}}"/>
                                                        <input type="hidden" name="goals[{{ $index}}][uid]" value="{{uid}}"/>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <label>Postback Type</label>
                                                        <select name="goals[{{ $index}}][p_type]" class="form-control">
                                                            <option ng-repeat="(key,p_type) in p_type_list"
                                                                    value="{{key}}" ng-selected="post_back.offer_postback.goals[goals.offer_goal_id].p_type == key"   
                                                                    >{{p_type}}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-12 m-t-10">
                                                        <label>Postback</label>
                                                        <textarea rows="4" class="form-control" ng-model="post_back.offer_postback.goals[goals.offer_goal_id].post_back" placeholder="callback with macros" name="goals[{{ $index}}][post_back]"></textarea>
                                                    </div>



                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-2"></div>
                                <div class="col-md-10">
                                    <button type="button" ng-disabled="saveBtn=='Processing....'" ng-click="save_postbacks()" class="btn btn-success pull-right waves-effect waves-light m-l-10"><span class="fa fa-save">   </span> {{saveBtn}} </button> 

                                </div>

                            </div>

                            <!--end search-->
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>
<script>

    
    // var genUrlManager = angular.module("gen_url", ['ui.bootstrap']);
    //postbackManager
    var postbackManager = viral_pro.controller("postbackManager", function ($scope) {

        $scope.campaign_id = '<?php echo @$campaign_id ?>';
        $scope.uid = '<?php echo @UID ?>';

        $scope.post_back = {};
        $scope.saveBtn = "SAVE";

        $scope.p_type_list = <?php echo json_encode($p_type) ?>;
        //
        $scope.GoalList = '';

        $scope.campaign_id_change = function (campaign_id) {
            $scope.campaign_id = campaign_id;
            $scope.getOfferPostbackDeails();
        };

        //Save the postback

        $scope.save_postbacks = function () {
            
            $scope.saveBtn = "Processing....";

            var form = $("#postbackForm").serialize();
            $.ajax({
                url: "<?php echo SITEURL . "admin/usr_offer_link_postback/set_up_postback" ?>",
                type: 'POST',
                data: form + "&campaign_id=" + $scope.campaign_id,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    
                    $scope.saveBtn = "SAVE";

                    if (data['success']) {

                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
                    } else
                    {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                    }
                    
                    $scope.$apply();

                }
            });

        };


        //end of save postback


        $scope.getofferGoals = function () {

            if ($scope.campaign_id == 0)
                return;
            $.ajax({
                url: "<?php echo SITEURL . "admin/usr_offer_link_postback/getOfferGoals" ?>",
                type: 'POST',
                data: 'campaign_id=' + $scope.campaign_id,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {

                    $scope.GoalList = data['goals'];
                    $scope.$apply();
                    $scope.getpostbackDetails();

                }

            });

        };
        $scope.getpostbackDetails = function () {

            $.ajax({
                url: "<?php echo SITEURL . "admin/usr_offer_link_postback/get_posback" ?>",
                type: 'POST',
                data: 'campaign_id=' + $scope.campaign_id + "&uid=" + $scope.uid,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {

                    $scope.post_back = data['post_back'];
                    $scope.$apply();
                }

            });
        };

        $scope.getOfferPostbackDeails = function () {
            $scope.getofferGoals();
        };
        $scope.getofferGoals();






    });





</script>