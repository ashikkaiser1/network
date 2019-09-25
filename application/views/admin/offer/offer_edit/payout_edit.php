<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default"  ng-controller="EditPayout">
            <div class="panel-heading"><h3 class="panel-title">

                    <?php echo $title ?></h3></div>
            <div class="panel-body">
                <form class="form-horizontal" id="PayoutEditForm" role="form" ng-submit="CreateUpdateOfferPayout()">                                    


                    <div class="form-group">
                        <label class="col-md-2 control-label">Offer Name</label>
                        <div class="col-md-10">
                            <input type="text" disabled="" class="form-control" ng-model="title" value="<?php echo isset($campaign['campaign_name']) ? $campaign['campaign_name'] : '' ?>" name="campaign_name">
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="text" class="hidden" name="revenue_type" value="{{revenue_type}}"/>
                        <label class="col-md-2 control-label">I want  </label>
                        <div class="col-md-10">

                            <?php
                            foreach ($payout as $id => $title) {
                                ?>

                                <div class="radio radio-success radio-single ">
                                    <input ng-change="selectRevenuetype()" type="radio" id="singleRadio<?php echo $id ?>" value="<?php echo $id ?>" checked="" ng-model="payout_type"  name="payout_type" >
                                    <label  for="singleRadio<?php echo $id ?>"><?php echo $title ?></label>
                                </div>

                                <!--                                                <label class="btn btn-sm btn-default">
                                                                                    <input type="radio" name="payout_type" value="<?php echo $id ?>"/>
                                                                                    
                                                                                </label>-->
                                <?php
                            }

//                                            echo form_dropdown("payout_type", $payout, isset($campaign['payout_type']) ? $campaign['payout_type'] : '', "class='form-control'");
                            ?>
                            <span class="help-block"><small>Select one of the model.</small></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Revenue Cost <?php echo CURR ?></label>
                        <div class="col-md-4">
                            <input type="text" class="form-control " id="RevenueCost" value="<?php echo isset($campaign['revenue_cost']) ? $campaign['revenue_cost'] : '' ?>" name="revenue_cost">
                            <span class="help-block"><small>How much Advertiser pay for this offer to you?</small></span>
                        </div>
                    </div>
                    <div class="form-group" >
                        <label class="col-md-2 control-label">Payout</label>
                        <div class="col-md-4">
                            <div class="toggle toggle-success PayoutSelection">
                            </div>
                            <span class="help-block"><small>How do you distribute payout? Flat or Revenue share ?</small></span>
                        </div>
                    </div>

                    <div class="form-group RevshareContainer ExtraFormGroup" style="display: none">
                        <label class="col-md-2 control-label">Rev share %</label>
                        <div class="col-md-4">
                            <input type="text" id="Revshare" onblur="calculate_payoutCost(this)" class="form-control " value="" name="rev_share">
                            <span class="help-block"><small>How much Revenue share ?</small></span>
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-md-2 control-label">Payout Cost <?php echo CURR ?></label>
                        <div class="col-md-4">
                            <input type="text" class="form-control " id="payoutcost"  value="<?php echo isset($campaign['payout_cost']) ? $campaign['payout_cost'] : '' ?>" name="payout_cost">
                            <span class="help-block"><small>How much you will pay to Affiliates/Publishers?</small></span>
                        </div>
                    </div>



                    <script>

                                function calculate_payoutCost(that)
                                {
                                    var rev_share = $(that).val();

                                    if (typeof rev_share != 'undefines' && rev_share != 'NaN')
                                    {
                                        var Reveune = $("#RevenueCost").val();
                                        var payoutCost = (rev_share / 100) * Reveune;
                                        payoutCost = parseFloat(payoutCost).toFixed(2);

                                        $("#payoutcost").val(payoutCost);
                                    }

                                }

                                function  BudgetCalculate(that, id)
                                {
                                    var caps = $(that).val();

                                    if (typeof caps != 'undefined' && caps != 'NaN')
                                    {
                                        var payoutCost = $("#payoutcost").val();
                                        var Budget = payoutCost * caps;

                                        Budget = parseFloat(Budget).toFixed(2);
                                        $("#" + id).val(Budget);
                                    }
                                }

                                $(document).ready(function () {
                                    $('.PayoutSelection').toggles({
                                        drag: true, // allow dragging the toggle between positions
                                        click: true, // allow clicking on the toggle
                                        text: {
                                            on: 'Flat', // text for the ON position
                                            off: 'Revshare' // and off
                                        },
                                        on: true, // is the toggle ON on init
                                        animate: 250, // animation time (ms)
                                        easing: 'swing', // animation transition easing function
                                        checkbox: null, // the checkbox to toggle (for use in forms)
                                        clicker: null, // element that can be clicked on to toggle. removes binding from the toggle itself (use nesting)
                                        width: 100, // width used if not set in css
                                        height: 30, // height if not set in css
                                        type: 'compact' // if this is set to 'select' then the select style toggle will be used
                                    });


                                    // With options (defaults shown below)
                                    $('.DailyCap,.MonthlyCap').toggles({
                                        drag: true, // allow dragging the toggle between positions
                                        click: true, // allow clicking on the toggle
                                        text: {
                                            on: 'Enable', // text for the ON position
                                            off: 'Disable' // and off
                                        },
                                        on: true, // is the toggle ON on init
                                        animate: 250, // animation time (ms)
                                        easing: 'swing', // animation transition easing function
                                        checkbox: null, // the checkbox to toggle (for use in forms)
                                        clicker: null, // element that can be clicked on to toggle. removes binding from the toggle itself (use nesting)
                                        width: 100, // width used if not set in css
                                        height: 30, // height if not set in css
                                        type: 'compact' // if this is set to 'select' then the select style toggle will be used
                                    });


// Getting notified of changes, and the new state:
                                    $('.DailyCap').on('toggle', function (e, active) {
                                        if (active) {
                                            $(".DailyCapContainer").show();
                                            console.log('DailyCap is now ON!');
                                        } else {
                                            $(".DailyCapContainer").hide();
                                            
                                            $(".DailyCapContainer input").val('');
                                            
                                            console.log('DailyCap is now OFF!');
                                        }
                                    });

                                    $('.MonthlyCap').on('toggle', function (e, active) {
                                        if (active) {
                                            $(".MonthlyCapContainer").show();
                                            console.log('MonthlyCap is now ON!');
                                        } else {
                                            $(".MonthlyCapContainer").hide();
                                            $(".MonthlyCapContainer input").val('');
                                            console.log('MonthlyCap is now OFF!');
                                        }
                                    });



                                    $('.PayoutSelection').on('toggle', function (e, active) {
                                        if (active) {
                                            $(".RevshareContainer").hide();
                                            console.log('DailyCap is now ON!');
                                        } else {
                                            $(".RevshareContainer").show();

                                            console.log('DailyCap is now OFF!');
                                        }
                                    });


                                });
                    </script>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Daily Cap</label>
                        <div class="col-md-4">
                            <div class="toggle toggle-success DailyCap"></div>

                        </div>
                    </div>

                    <div class="form-group ExtraFormGroup DailyCapContainer" >
                        <label class="col-md-2 control-label">Daily Cap</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" onchange="BudgetCalculate(this, 'DailyBudget')" value="<?php echo isset($campaign['daily_cap']) ? $campaign['daily_cap'] : '' ?>" name="daily_cap">
                            <span class="help-block"><small>Set cap 0 if there is no limit</small></span>
                        </div>

                        <label class="col-md-2 control-label">Daily Budget</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="DailyBudget" value="<?php echo isset($campaign['daily_budget']) ? $campaign['daily_budget'] : '' ?>" name="daily_budget">
                        </div>
                    </div>

                    <div class="form-group" >
                        <label class="col-md-2 control-label">Monthly Cap</label>
                        <div class="col-md-4">
                            <div class="toggle toggle-success MonthlyCap"></div>
                        </div>
                    </div>

                    <div class="form-group ExtraFormGroup MonthlyCapContainer" >
                        <label class="col-md-2 control-label">Monthly Cap</label>
                        <div class="col-md-4">
                            <input type="text" onchange="BudgetCalculate(this, 'monthBudget')" class="form-control" value="<?php echo isset($campaign['monthly_cap']) ? $campaign['monthly_cap'] : '' ?>" name="monthly_cap">
                            <span class="help-block"><small>Set cap 0 if there is no limit</small></span>
                        </div>

                        <label class="col-md-2 control-label">Monthly Budget</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="monthBudget" value="<?php echo isset($campaign['monthly_budget']) ? $campaign['monthly_budget'] : '' ?>" name="monthly_budget">
                        </div>
                    </div>






                    <div class="form-group"> 
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-10">

                            <button  type="submit" class="btn btn-purple waves-effect waves-light">{{saveBtn}}</button>
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

        $('#PayoutEditForm').bootstrapValidator({
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
                            message: 'Offer Name cannot be empty'
                        },
                        stringLength: {
                            min: 3,
                            max: 2500,
                            message: 'Offer Name must be 3 to 25 characters long'
                        }
                    }
                },
                title: {// field name
                    validators: {
                        notEmpty: {
                            message: ''
                        },
//                                            regexp: {
//                                                regexp: /^[a-zA-Z0-9\s]+$/,
//                                                message: ''
//                                            },
                        stringLength: {
                            min: 3,
                            max: 2500,
                            message: ''
                        }
                    }
                },
                meta: {// field name
                    validators: {
                        notEmpty: {
                            message: ''
                        },
//                                            regexp: {
//                                                regexp: /^[a-zA-Z0-9\s]+$/,
//                                                message: ''
//                                            },
                        stringLength: {
                            min: 3,
                            max: 1000,
                            message: ''
                        }
                    }
                }, url_slug: {// field name
                    validators: {
                        notEmpty: {
                            message: ''
                        },
                        url: {
                            message: ''
                        }, stringLength: {
                            min: 3,
                            max: 2500,
                            message: ''
                        }
                    }
                }
                ,
                'category_id[]': {
                    validators: {
                        notEmpty: {
                            message: 'Please select a category'
                        }
                    }
                }


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
    //var Offer = angular.module("Offer", []);
    viral_pro.controller("EditPayout", function ($scope) {

        $scope.message = "";
        $scope.saveBtn = "<?php echo $SubmitBtn ?>";
        $scope.redirection = 0;

        $scope.action = "<?php echo $FormAction ?>";
        $scope.revenue_type = '<?php echo isset($campaign['revenue_type']) ? $campaign['revenue_type'] : '7' ?>'; // 7 is used for RPI , Revenue per install;
        $scope.payout_type = '<?php echo isset($campaign['payout_type']) ? $campaign['payout_type'] : '8' ?>'; // default selected installs

<?php
if (!empty($post)) {
    ?>
            $scope.image = "<?php echo $post['image'] ?>";
            $scope.title = "<?php echo $post['title'] ?>";
            //$scope.meta = new String("<?php //echo  $post['meta']         ?>");
            $scope.url_slug = "<?php echo $post['url_slug'] ?>";
            $scope.preview_link = "<?php echo $post['preview_link'] ?>";
    <?php
}

if (!empty($campaign)) {
    ?>
            $scope.title = "<?php echo $campaign['campaign_name'] ?>";
            $scope.globalCountry = <?php echo isset($campaign['geo']) && $campaign['geo'] == 1 ? "true" : 'false' ?>;


    <?php
}
?>

        $scope.selectRevenuetype = function () {

//            alert('clicked'+ $scope.payout_type);
            switch ($scope.payout_type) {
                case '6':
                    $scope.revenue_type = 3;
                    break;
                case '5':
                    $scope.revenue_type = 2;
                    break;
                case '4':
                    $scope.revenue_type = 1;
                    break;
                case '8':
                    $scope.revenue_type = 7;
                    break;
                case '11':
                    $scope.revenue_type = 9;
                    break;
                case '12':
                    $scope.revenue_type = 10;
                    break;
                default:
                    break;
            }

        };


        $scope.CreateUpdateOfferPayout = function () {

            if (!$("#PayoutEditForm").data('bootstrapValidator').validate().isValid())
            {

                //alert("Form Not Valida");
                return  false;
            }


            var fom = $("#PayoutEditForm")[0];

            console.log(fom);

            var formData = new FormData(fom);
            console.log(formData);

            $scope.saveBtn = "<?php echo $Submiting ?>";

            //var form = new FormData($("#PayoutEditForm"));
            $.ajax({
                url: $scope.action,
                type: 'POST',
                dataType: 'json',
                data: $("#PayoutEditForm").serialize(),
                success: function (data, textStatus, jqXHR) {
                    $scope.saveBtn = "<?php echo $SubmitBtn ?>";
                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
                        if ($scope.saveBtn != 'Update')
                            $("#PayoutEditForm")[0].reset();

                        window.location = data['redirect'];

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