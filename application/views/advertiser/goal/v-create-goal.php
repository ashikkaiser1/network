<div class="row">
    <nav class="top-nav m-b-10">
        <a class="text-white " href="<?php
        echo SITEURL . "advertiser/campaign/offerRequest/" . @$campaign['campaign_id'];
        ?>">
            <h2 class="page-heading blue-bg " style="    font-size: 16px;">
                <span class="fa fa-arrow-left"></span> <?php echo isset($campaign['campaign_name']) ? $campaign['campaign_name'] : '' ?>
            </h2>
        </a>
    </nav>

    <div class="col-sm-12">
        <div class="panel panel-default"  ng-controller="Goals">
            <div class="panel-heading"><h3 class="panel-title"><?php echo $title ?></h3></div>
            <div class="panel-body">
                <form class="form-horizontal" id="GoalForm" role="form" ng-submit="CreateGoal()">   
                    <input type="hidden" name="goal_id" value="0"/>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Offer</label>
                        <div class="col-md-4">
                            <input type="hidden" value="<?php echo @$campaign_id; ?>" name="campaign_id"/>
                            <input type="text" disabled="" class="form-control" value="<?php echo @$campaign['campaign_name'] ?>"/>

                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-2 control-label">Name</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" value="<?php echo isset($goal['name']) ? $goal['name'] : '' ?>" name="name">
                        </div>
                    </div>




                    <div class="form-group">
                        <label class="col-md-2 control-label">Payout Type</label>
                         <input type="text" class="hidden" name="payout_type" value="{{payout_type}}"/>
                        <div class="col-md-4">
                            <?php
                      
                            echo form_dropdown("revenue_type", $revenue, isset($goal['revenue_type']) ? $goal['revenue_type'] : '', "class='form-control' ng-model='revenue_type' ng-change='selectPayouttype()'");
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Payout Cost <?php echo CURR ?></label>
                        <div class="col-md-4">
                            <input type="text" class="form-control " value="<?php echo isset($goal['revenue_cost']) ? $goal['revenue_cost'] : '' ?>" name="revenue_cost">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Status</label>
                        <div class="col-md-4">
                            <?php
                            echo form_dropdown("off_goal_status", array("1" => "Active", "0" => "In-Active"), isset($goal['off_goal_status']) ? $goal['off_goal_status'] : '', "class='form-control'");
                            ?>

                        </div>
                    </div>


                    <div class="form-group"> 
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-10">

                            <button type="submit" class="btn btn-purple waves-effect waves-light">{{saveBtn}}</button>
                            <button type="Reset" class="btn btn-danger waves-effect waves-light">Cancel</button>
                        </div>
                    </div>

                </form>

                <?php
                $this->load->view("advertiser/goal/v-all-goal");
                ?>
            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col -->
</div>
<script>
    $(function () {

        $('#GoalForm').bootstrapValidator({
            message: false,
//            container: 'tooltip',
            trigger: null,
            live: 'enabled',
            feedbackIcons: {
                // valid: 'glyphicon glyphicon-ok',
                // invalid: 'glyphicon glyphicon-remove',
                // validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                goals_name: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Name field cannot be empty'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9\s]+$/,
                            message: 'Invalid Name'
                        },
                        stringLength: {
                            min: 3,
                            max: 25,
                            message: 'Name must be 3 to 25 characters long'
                        }
                    }
                }

            }

        }).on('success.form.bv', function (e) {
            e.preventDefault();

        });
    });
</script>
<script>
    //var Category = angular.module("Category", []);
    viral_pro.controller("Goals", function ($scope) {

        $scope.message = "";
        $scope.saveBtn = "Save";
        $scope.all_goals = {};
        $scope.campaign_id = {value: "0", text: "None"};

        $scope.action = "<?php echo $FormAction ?>";
        
         $scope.revenue_type='<?php echo isset($$goal['revenue_type']) ? $goal['revenue_type'] :7 ?>';
        $scope.payout_type='<?php echo isset($$goal['payout_type']) ? $goal['payout_type'] :8 ?>';;


        $scope.selectPayouttype = function(){
            
//            alert('clicked'+ $scope.payout_type);
            switch ($scope.revenue_type) {
                case '3': $scope.payout_type=6; break;
                case '2': $scope.payout_type=5; break;
                case '1': $scope.payout_type=4; break;
                case '7': $scope.payout_type=8; break;
                case '9': $scope.payout_type=11; break;
                case '10': $scope.payout_type=12; break;
                default:             
                    break;
            }
            
        };
        $scope.CreateGoal = function () {
            if (!$("#GoalForm").data('bootstrapValidator').validate().isValid())
            {
                return  false;
            }

            $scope.saveBtn = "Creating";
            var fom = $("#GoalForm")[0];
            $scope.saveBtn = "<?php echo $Submiting ?>";

            console.log(fom);

            var formData = new FormData(fom);
            console.log(formData);

            //var form = new FormData($("#GoalForm"));
            $.ajax({
                url: $scope.action,
                type: 'POST',
                dataType: 'json',
                data: $("#GoalForm").serialize(),
                success: function (data, textStatus, jqXHR) {

                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
                        var campaign_id = $("input[name='campaign_id']").val();
                        $scope.show_goals(campaign_id);
//                        $("#GoalForm")[0].reset();
                    } else {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                    }
                    $scope.saveBtn = "Save";
                    $scope.$apply();
                }

            });



        };

        $scope.show_goals = function (campaign_id)
        {
            $.ajax({
                url: "<?php echo SITEURL . "advertiser/goals/show_goals/" ?>" + campaign_id,
                type: 'POST',
                dataType: 'json',
//                data: $("#GoalForm").serialize(),
                success: function (data, textStatus, jqXHR) {
//                    if (data['success'])
//                    {
                    $scope.all_goals = data['all_goals'];
                    //}
                    $scope.$apply();
                }

            });
        };

        $scope.delete_offer_goal = function (offer_goal_id)
        {
            swal({
                title: "Are you sure?",
                text: "Your will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn btn-sm btn-danger waves-effect waves-light",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
                    function (isConfirm) {
                        if (isConfirm)
                        {
                            $.ajax({
                                url: "<?php echo SITEURL . "advertiser/goals/deleteGoal" ?>",
                                type: 'POST',
                                data: "offer_goal_id=" + offer_goal_id,
                                dataType: 'json',
                                success: function (data, textStatus, jqXHR) {
                                    if (data['success'])
                                    {
                                        $.Notification.autoHideNotify('success',
                                                'botton right',
                                                data['msg'],
                                                '');
                                        $("#tr" + offer_goal_id).remove();
                                        //$("#catForm")[0].reset();
                                    } else {
                                        $.Notification.autoHideNotify('error',
                                                'botton right',
                                                data['msg'],
                                                '');
                                    }

                                }

                            });
                        }


                    });






        };

        $scope.show_offers_goals = function ()
        {
            var campaign_id = $("input[name='campaign_id']").val();
            $scope.show_goals(campaign_id);
        };


        $scope.show_goals('<?php echo isset($campaign_id) ? $campaign_id : 0 ?>');

    });
</script>
