



<div class="row hidden"  id="GoalAddForm" >


    <div class="col-sm-12">

        <div class="panel-heading"><h3 class="panel-title"><?php //echo $title       ?></h3></div>
        <div class="panel-body">
            <form class="form-horizontal" id="GoalForm" role="form" ng-submit="CreateGoal()">   


                <input type="hidden" name="campaign_id" id="goal_campaign_id" value="<?php echo $campaign_id ?>">
                <input type="hidden" name="goal_id" value="0"/>

<!--                <div class="col-md-5">
                    <div class="form-group">
                        <label class=" control-label">Goal Type</label>

                        <?php
                       // echo form_dropdown("goal_id", $global_goals, '', "class='form-control'");
                        ?>

                    </div>
                </div> -->
                <div class="col-md-2">
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class=" control-label">Name</label>

                        <input type="text" class="form-control" placeholder="Name" name="name">

                    </div>
                </div>


<!--                <div class="col-md-5">
                    <div class="form-group">
                        <label class=" control-label">Revenue Type</label>

                        <?php
//                        echo form_dropdown("revenue_type", $revenue, '', "class='form-control'");
                        ?>


                    </div>
                </div>-->
<!--                <div class="col-md-2">
                </div>-->
<!--                <div class="col-md-5">
                    <div class="form-group">
                        <label class="control-label">Revenue Cost <?php echo CURR ?></label>

                        <input type="text" class="form-control " value="<?php //echo isset($goal['revenue_cost']) ? $goal['revenue_cost'] : ''       ?>" name="revenue_cost">

                    </div>
                </div>-->
                <div class="col-md-5">
                    <div class="form-group">
                        <input type="text" class="hidden" name="payout_type" value="{{payout_type}}"/>
                        <label class="control-label">Payout Type</label>

                        <?php
                        echo form_dropdown("revenue_type", $revenue, '', "class='form-control' ng-model='revenue_type' ng-change='selectPayouttype()'");
                        ?>
                    </div>    

                </div>
                <div class="col-md-2">
                </div>


                <div class="col-md-5">
                    <div class="form-group">
                        <label class=" control-label">Payout Cost <?php echo CURR ?></label>

                        <input type="text" class="form-control " value="<?php //echo isset($goal['payout_cost']) ? $goal['payout_cost'] : ''       ?>" name="revenue_cost">

                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="control-label">Status</label>
                        <?php
                        echo form_dropdown("off_goal_status", array("1" => "Active", "0" => "De-Active"), '', "class='form-control'");
                        ?>

                    </div>
                </div>




                <div class="form-group"> 
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-8">

                        <button type="submit" class="btn btn-purple waves-effect waves-light">{{saveBtn}}</button>
                        <button type="Reset" id="CancelGoalAdd" class="btn btn-danger waves-effect waves-light">Cancel</button>
                    </div>
                </div>

            </form>

            <?php
            //$this->load->view("admin/goal/v-all-goal");
            ?>
            <!-- panel-body -->
        </div> <!-- panel -->
        <!-- col -->
    </div>

</div>

<script>

    $("#ShowGoalForm,#CancelGoalAdd").click(function () {

        $("#GoalAddForm").toggleClass("hidden");

    });
</script>

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
                name: {// field name
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
        $scope.all_goals = <?php echo json_encode($offer_goals) ?>;
        $scope.campaign_id = {value: "0", text: "None"};
        
        $scope.revenue_type=7;
        $scope.payout_type=8;

        $scope.action = "<?php echo SITEURL . "advertiser/goals/CreateGoal" ?>";

        
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
            $scope.saveBtn = "<?php echo "Submiting" ?>";

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

                        $("#GoalForm")[0].reset();
                        var campaign_id = $("#goal_campaign_id").val();
                        $scope.show_goals(campaign_id);
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
            var campaign_id = $("#campaign_id :selected").val();
            $scope.show_goals(campaign_id);
        };


        $scope.show_goals('<?php echo isset($campaign_id) ? $campaign_id : 0 ?>');

    });
</script>