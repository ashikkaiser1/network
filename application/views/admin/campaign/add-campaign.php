<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default"  ng-controller="AddCampaign">
            <div class="panel-heading"><h3 class="panel-title">
                    <a href="<?php echo SITEURL . "admin/campaign/show_campaign" ?>" class=" btn btn-purple waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-list"></span> All Campaign</a>
                    Create new Campaign</h3></div>
            <div class="panel-body">
                <form class="form-horizontal" id="catForm" role="form" ng-submit="CreateUpdateCampaign()">                                    


                    <div class="form-group">
                        <label class="col-md-2 control-label">Campaign Name</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" value="<?php echo isset($campaign['campaign_name']) ? $campaign['campaign_name'] : '' ?>" name="campaign_name">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-2 control-label">Advertiser</label>
                        <div class="col-md-4">
                            <?php
                            echo form_dropdown("advertiser_id", $affiliates, isset($campaign['advertiser_id']) ? $campaign['advertiser_id'] : '', "class='form-control' ");
                            ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Start Date</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control datepicker" value="<?php echo isset($campaign['start_date']) ? $campaign['start_date'] : '' ?>" name="start_date">
                        </div>
                         <label class="col-md-2 control-label">End Date</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control datepicker" value="<?php echo isset($campaign['end_date']) ? $campaign['end_date'] : '' ?>" name="end_date">
                        </div>
                    </div>

                    
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Revenue Type</label>
                        <div class="col-md-4">
                            <?php
                            echo form_dropdown("revenue_type", $revenue, isset($campaign['revenue_type']) ? $campaign['revenue_type'] : '', "class='form-control'");
                            ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Revenue Cost <?php echo CURR ?></label>
                        <div class="col-md-4">
                            <input type="text" class="form-control " value="<?php echo isset($campaign['revenue_cost']) ? $campaign['revenue_cost'] : '' ?>" name="revenue_cost">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Payout Type</label>
                        <div class="col-md-4">
                            <?php
                            echo form_dropdown("payout_type", $payout, isset($campaign['payout_type']) ? $campaign['payout_type'] : '', "class='form-control'");
                            ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Payout Cost <?php echo CURR ?></label>
                        <div class="col-md-4">
                            <input type="text" class="form-control " value="<?php echo isset($campaign['payout_cost']) ? $campaign['payout_cost'] : '' ?>" name="payout_cost">
                        </div>
                    </div>

<!--                    <div class="form-group">
                        <label class="col-md-2 control-label">Per Click Revenue(admin) <?php echo CURR ?></label>
                        <div class="col-md-10">
                            <input type="text" class="form-control " value="<?php echo isset($campaign['act_ppc']) ? $campaign['act_ppc'] : '' ?>" name="act_ppc">
                        </div>
                    </div>

                                         <div class="form-group">
                                            <label class="col-md-2 control-label">Per Impression Revenue(admin) <?php echo CURR ?></label>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" value="<?php echo isset($campaign['act_ppi']) ? $campaign['act_ppi'] : '' ?>" name="act_ppi">
                                            </div>
                                        </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Per Click Revenue(Affiliate) <?php echo CURR ?></label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" value="<?php echo isset($campaign['payout_cost']) ? $campaign['payout_cost'] : '' ?>" name="payout_cost">
                        </div>
                    </div>-->

                    <div class="form-group">
                        <label class="col-md-2 control-label">Cap</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" value="<?php echo isset($campaign['cap']) ? $campaign['cap'] : '' ?>" name="cap">
                        </div>
                    </div>

                    <!--                     <div class="form-group">
                                            <label class="col-md-2 control-label">Per Impression Revenue(Affiliate) <?php echo CURR ?></label>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" value="<?php echo isset($campaign['per_impression_revenue']) ? $campaign['per_impression_revenue'] : '' ?>" name="per_impression_revenue">
                                            </div>
                                        </div>-->






                    <div class="form-group">
                        <label class="col-md-2 control-label">Status</label>
                        <div class="col-md-4">
                            <?php
                            echo form_dropdown("status", array("1" => "Active", "0" => "De-Active"), isset($campaign['c_status']) ? $campaign['c_status'] : '', "class='form-control' ");
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
            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col -->
</div>
<script>
    $(function () {

        $('#catForm').bootstrapValidator({
            message: false,
//            container: 'tooltip',
            trigger: null,
            live: 'disabled',
            feedbackIcons: {
                // valid: 'glyphicon glyphicon-ok',
                // invalid: 'glyphicon glyphicon-remove',
                // validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                campaign_name: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Campaign Name cannot be empty'
                        },
                        
                        stringLength: {
                            min: 3,
                            max: 250,
                            message: 'Campaign Name must be 3 to 25 characters long'
                        }
                    }
                },
                /* start_date: {// field name
                 validators: {
                 date: {
                 format: 'MM/DD/YYYY',
                 message: 'Start Date is not valid',
                 //max: 'end_date'
                 
                 
                 }
                 }
                 },
                 end_date: {// field name
                 validators: {
                 date: {
                 format: 'MM/DD/YYYY',
                 message: 'End Date is not valid',
                 min: 'start_date'
                 
                 
                 }
                 }*/



            }

        }).on('success.form.bv', function (e) {
            e.preventDefault();

        });
    });
</script>
<script>
    //var Campaign = angular.module("Campaign", []);
    viral_pro.controller("AddCampaign", function ($scope) {

        $scope.message = "";
        $scope.saveBtn = "<?php echo $SubmitBtn ?>";


        $scope.action = "<?php echo $FormAction ?>";



        $scope.CreateUpdateCampaign = function () {

            if (!$("#catForm").data('bootstrapValidator').validate().isValid())
            {

                //alert("Form Not Valida");
                return  false;
            }


            var fom = $("#catForm")[0];

            console.log(fom);

            var formData = new FormData(fom);
            console.log(formData);

            $scope.saveBtn = "<?php echo $Submiting ?>";

            //var form = new FormData($("#catForm"));
            $.ajax({
                url: $scope.action,
                type: 'POST',
                dataType: 'json',
                data: $("#catForm").serialize(),
                success: function (data, textStatus, jqXHR) {
                    $scope.saveBtn = "<?php echo $SubmitBtn ?>";
                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
                        if ($scope.saveBtn != 'Update')
                            $("#catForm")[0].reset();
                    } else {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                    }
                    $scope.$apply();
                }
            });
        };
    });
</script>
<?php
if (isset($allCampaign))
    echo $allCampaign;
?>