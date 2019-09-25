<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default"  ng-controller="AddOffer">
            <div class="panel-heading"><h3 class="panel-title">

                    <?php echo $title ?>
                    <div class="pull-right">
                        <a href="<?php echo SITEURL . "admin/offer/show_campaign" ?>" class=" btn btn-purple waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-list"></span> All Offers</a>
                    </div>

                </h3></div>
            <div class="panel-body">
                <form class="form-horizontal" id="catForm" role="form" ng-submit="CreateUpdateOffer()">                                    

                    <?php $this->load->view("admin/offer/add-offer-widzard"); ?>
                    <div class="row">
                        <div class="col-md-12 OfferTabs" style="display: block" id="BasicTab">
                            <!--                        step 1-->

                            <div class="panel panel-default">
                                <div class="panel-heading"> 
                                    <h3 class="panel-title">Basic</h3> 
                                </div> 
                                <div class="panel-body"> 
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Advertiser</label>
                                        <div class="col-md-6">
                                            <?php
                                            echo form_dropdown("advertiser_id", $affiliates, isset($campaign['advertiser_id']) ? $campaign['advertiser_id'] : '', "class='form-control' ");
                                            ?>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Account Manager</label>
                                        <div class="col-md-6">
                                            <?php
                                            echo form_dropdown("manager", $AccManager, isset($campaign['manager']) ? $campaign['manager'] : '', "class='form-control' ");
                                            ?>

                                        </div>
                                    </div>   

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Preview Link</label>
                                        <div class="col-md-10">
                                            <!--ng-blur="getHttpPost()"-->
                                            <input type="text" 
                                                   placeholder="Offer preview link" 
                                                   class="form-control"
                                                   
                                                   ng-model="preview_link" value="<?php echo isset($post['preview_link']) ? $post['preview_link'] : '' ?>" name="preview_link">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Offer Name</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" ng-model="title" value="<?php echo isset($campaign['campaign_name']) ? $campaign['campaign_name'] : '' ?>" name="campaign_name">
                                        </div>
                                    </div>





                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Description</label>
                                        <div class="col-md-10">
                                            <textarea class="form-control" ng-model="meta" id="metadata"  name="meta" rows="5"><?php echo isset($post['meta']) ? $post['meta'] : '' ?></textarea>
                                            <script>
                                                        $("#metadata").text('<?php echo isset($post['meta']) ? $post['meta'] : '' ?>');
                                            </script>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Tracking Link</label>
                                        <div class="col-md-10">
                                            <input type="text" 
                                                   placeholder="Advertiser Offer tracking link or landing page link with or without parameters."   class="form-control"  ng-model="url_slug" value="<?php echo isset($post['url_slug']) ? $post['url_slug'] : '' ?>" name="url_slug">

                                            <input type="hidden" name="baseUrl_slug" value="{{baseUrl_slug}}" />
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <span class="fa fa-info-circle"></span> Macros Info
                                                </div>

                                                <div class="col-md-12">
                                                    <button type="button" title="{{macro.description}}" class="macroBtn btn btn-default waves-effect waves-light m-b-5" ng-repeat="macro in macros">{{macro.name}}</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Category</label>
                                        <div class="col-md-10">
                                            <?php
                                            echo form_multiselect("category_id[]", $category, isset($post['category_id']) ? $post['category_id'] : '', "class='form-control select2'   ");
                                            ?>

                                        </div>
                                    </div>






                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Image</label>
                                        <div class="col-md-4">
                                            <?php
                                            if (!empty($post)) {
                                                ?>
                                                <input type="hidden" name="post_id" value="<?php echo isset($post['post_id']) ? $post['post_id'] : '' ?>"/>
                                                <img  id='postImage' ng-src='{{image}}' style='width:200px' />
                                                <?php
                                            } else {
                                                echo "<img  id='postImage' ng-src='{{image}}' style='width:200px;display:block'/>";
                                            }
                                            ?>
                                            <input type="hidden" name="image" value="{{image}}" />
                                            <input type="file" class="form-control" value="" name="image">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Start Date</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control datepicker" value="<?php echo isset($campaign['start_date']) ? $campaign['start_date'] : date('d-m-Y', time()) ?>" name="start_date">
                                        </div>
                                        <label class="col-md-2 control-label">End Date</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control datepicker" value="<?php echo isset($campaign['end_date']) ? $campaign['end_date'] : '' ?>" name="end_date">
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Click Life Span</label>
                                        <div class="col-md-4">
                                            <input type="text" name="click_span"class="form-control" placeholder="Number of days " value="<?php echo isset($campaign['click_span']) ? $campaign['click_span'] : '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Status</label>
                                        <div class="col-md-4">
                                            <?php
                                            echo form_dropdown("status", $camapign_status, isset($campaign['c_status']) ? $campaign['c_status'] : '', "class='form-control' ");
                                            ?>
                                        </div>
                                    </div>


                                    <div class="form-group"> 
                                        <div class="col-sm-2">
                                        </div>
                                        <div class="col-sm-10">
                                            <button type="button" ng-click="ShowTab('PayoutTab')" class="btn btn-success  waves-effect waves-light">Next
                                                <span class="fa fa-arrow-right"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div> 
                            </div>

                            <!--step 1 end-->

                        </div>


                        <div class="col-md-12 OfferTabs" id="PayoutTab">

                            <!--                        step 2-->
                            <div class="panel panel-default">
                                <div class="panel-heading"> 
                                    <h3 class="panel-title">Payout</h3> 
                                </div> 
                                <div class="panel-body"> 

                                    <!--                                    <div class="form-group">
                                                                            <label class="col-md-2 control-label">Revenue Type</label>
                                                                            <div class="col-md-4">
                                    <?php
//                                    echo form_dropdown("revenue_type", $revenue, isset($campaign['revenue_type']) ? $campaign['revenue_type'] : '', "class='form-control'");
                                    ?>
                                    
                                                                            </div>
                                                                        </div>-->


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
                                            <input type="text" id="payoutcost" class="form-control " value="<?php echo isset($campaign['payout_cost']) ? $campaign['payout_cost'] : '' ?>" name="payout_cost">
                                            <span class="help-block"><small>How much you will pay to Affiliates/Publishers?</small></span>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Cap</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" value="<?php echo isset($campaign['cap']) ? $campaign['cap'] : '0' ?>" name="cap">
                                            <span class="help-block"><small>Set cap 0 if there is no limit</small></span>
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
                                                        on: false, // is the toggle ON on init
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
                                                            console.log('DailyCap is now OFF!');
                                                        }
                                                    });
                                                    
                                                    $('.MonthlyCap').on('toggle', function (e, active) {
                                                        if (active) {
                                                            $(".MonthlyCapContainer").show();
                                                            console.log('MonthlyCap is now ON!');
                                                        } else {
                                                            $(".MonthlyCapContainer").hide();
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

                                    <div class="form-group ExtraFormGroup DailyCapContainer" style="display: none">
                                        <label class="col-md-2 control-label">Daily Cap</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" onchange="BudgetCalculate(this, 'DailyBudget')" value="<?php echo isset($campaign['cap']) ? $campaign['cap'] : '0' ?>" name="daily_cap">
                                            <span class="help-block"><small>Set cap 0 if there is no limit</small></span>
                                        </div>

                                        <label class="col-md-2 control-label">Daily Budget</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" id="DailyBudget" value="<?php echo isset($campaign['cap']) ? $campaign['cap'] : '0' ?>" name="daily_budget">
                                        </div>
                                    </div>




                                    <div class="form-group" >
                                        <label class="col-md-2 control-label">Monthly Cap</label>
                                        <div class="col-md-4">
                                            <div class="toggle toggle-success MonthlyCap"></div>
                                        </div>
                                    </div>

                                    <div class="form-group ExtraFormGroup MonthlyCapContainer" style="display: none">
                                        <label class="col-md-2 control-label">Monthly Cap</label>
                                        <div class="col-md-4">
                                            <input type="text" onchange="BudgetCalculate(this, 'monthBudget')" class="form-control" value="<?php echo isset($campaign['cap']) ? $campaign['cap'] : '0' ?>" name="monthly_cap">
                                            <span class="help-block"><small>Set cap 0 if there is no limit</small></span>
                                        </div>

                                        <label class="col-md-2 control-label">Monthly Budget</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" id="monthBudget" value="<?php echo isset($campaign['cap']) ? $campaign['cap'] : '0' ?>" name="monthly_budget">
                                        </div>
                                    </div>




                                    <div class="form-group"> 
                                        <div class="col-sm-2">
                                        </div>
                                        <div class="col-sm-10">
                                            <button  type="button" ng-click="ShowTab('BasicTab')" class="btn btn-purple waves-effect waves-light"><span class="fa fa-arrow-left"></span> Prev

                                            </button>
                                            <button type="button"  ng-click="ShowTab('OfferSetTab')"  class="btn btn-success  waves-effect waves-light">Next
                                                <span class="fa fa-arrow-right"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div> 
                            </div>

                            <!-- step 2end-->
                        </div>



                        <div class="col-md-12 OfferTabs" id="OfferSetTab">

                            <!--                        step 3-->
                            <div class="panel panel-default">
                                <div class="panel-heading"> 
                                    <h3 class="panel-title">Offer Setting</h3> 
                                </div> 
                                <div class="panel-body"> 


                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Conversion Status Rule</label>
                                        <div class="col-md-6">
                                            <?php
                                            echo form_dropdown("conv_status", $this->config->item("conv_status"), isset($campaign['conv_status']) ? $campaign['conv_status'] : '', "class='form-control' ");
                                            ?>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Private</label>
                                        <div class="col-md-6">
                                            <?php
                                            echo form_dropdown("private", $private, isset($campaign['private']) ? $campaign['private'] : '', "class='form-control' ");
                                            ?>

                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Redirection</label>
                                        <div class="col-md-4">
                                            <?php
                                            echo form_dropdown("redirection", array("0" => "Disable", "1" => "Enable"), isset($campaign['redirection']) ? $campaign['redirection'] : '0', "class='form-control' ng-model='redirection' ng-change='onchnageRedirection()' ");
                                            ?>
                                        </div>



                                    </div>


                                    <div class="form-group " id="redirectOptio" style="display: none" >
                                        <label class="col-md-2 control-label">Redirection Url</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control " value="<?php echo isset($campaign['redirectUrl']) ? $campaign['redirectUrl'] : '' ?>" name="redirectUrl">

                                            <span style="width: 100%;    text-align: center;    display: block;    padding: 11px;    font-weight: bold;">OR</span>
                                            <?php
                                            echo form_dropdown("r_campaign_id", $offers, isset($campaign['r_campaign_id']) ? $campaign['r_campaign_id'] : '', "class='form-control campaign_id_select2' ");
                                            ?>

                                        </div>


                                    </div>







                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Required Approval</label>
                                        <div class="col-md-4">
                                            <?php
                                            echo form_dropdown("req_approval", array("1" => "Enable", "0" => "Disable"), isset($campaign['req_approval']) ? $campaign['req_approval'] : '0', "class='form-control' ");
                                            ?>
                                        </div>
                                    </div>


                                    <div class="form-group"> 
                                        <div class="col-sm-2">
                                        </div>
                                        <div class="col-sm-10">

                                            <button  type="button" ng-click="ShowTab('PayoutTab')" class="btn btn-purple waves-effect waves-light">

                                                <span class="fa fa-arrow-left"></span> Prev

                                            </button>
                                            <button type="button"  ng-click="ShowTab('TargetTab')"  class="btn btn-success  waves-effect waves-light">Next
                                                <span class="fa fa-arrow-right"></span>
                                            </button>
                                        </div>
                                    </div>



                                </div> 
                            </div>

                            <!-- step 3 end-->
                        </div>

                        <div class="col-md-12 OfferTabs" id="TargetTab">

                            <!--                        step 4-->
                            <div class="panel panel-default">
                                <div class="panel-heading"> 
                                    <h3 class="panel-title">Targeting</h3> 
                                </div> 
                                <div class="panel-body"> 
                                    <div class="form-group">
                                        <label class="col-md-2 control-label text-left" style="">GEO Target <span class='text-danger'>*</span></label>
                                        <div class="col-md-8">

                                            <?php echo form_multiselect("offer_country[]", $country, isset($offer_country) ? $offer_country : '', "id='offer_countries' class='select2 form-control' ") ?>

                                        </div>

                                        <label class="col-md-2 control-label text-left" style="text-align:left;font-weight:normal">
                                            <input type="checkbox" ng-model="globalCountry" ng-click="onSelectGlobe()" name="geo"  value="1"/> Global</label>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-2 control-label text-left" style="">Device (Recommended)</label>
                                        <div class="col-md-6">

                                            <?php echo form_multiselect("offer_devices[]", $this->config->item('deviceType'),'', "id='offer_devices' class='select2 form-control' ") ?>

                                        </div>

                                        <label class="col-md-2 control-label text-left" style="text-align:left;font-weight:normal">
                                            <input type="checkbox" ng-model="Alloffer_devices"  name="Alloffer_devices" value="1" ng-click="onSelectAlloffer_devices()" /> All</label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label text-left" style="">Platform (Optional)</label>
                                        <div class="col-md-6"> 

                                            <?php echo form_multiselect("offer_OS[]", $this->config->item('PlatformType'),'', "id='offer_OS' class='select2 form-control' ") ?>

                                        </div> 

                                        <label class="col-md-2 control-label text-left" style="text-align:left;font-weight:normal">
                                            <input type="checkbox" ng-model="Alloffer_OS"  name="Alloffer_OS" value="1" ng-click="onSelectAlloffer_OS()" /> All</label>
                                    </div>
                                    
                                    
                                    
                                    
                                    <div class="form-group"> 
                                        <div class="col-sm-2">
                                        </div>
                                        <div class="col-sm-10">
                                            <button  type="button" ng-click="ShowTab('OfferSetTab')" class="btn btn-purple waves-effect waves-light">
                                                <span class="fa fa-arrow-left"></span> Prev

                                            </button>
                                            <button type="button"  ng-click="ShowTab('TrackingTab')"  class="btn btn-success  waves-effect waves-light">Next
                                                <span class="fa fa-arrow-right"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div> 
                            </div>

                            <!-- step 4 end-->
                        </div>



                        <div class="col-md-12 OfferTabs" id="TrackingTab">

                            <!--                        step 5-->
                            <div class="panel panel-default">
                                <div class="panel-heading"> 
                                    <h3 class="panel-title">Tracking</h3> 
                                </div> 
                                <div class="panel-body"> 
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Tracking Protocol</label>
                                        <div class="col-md-4">
                                            <?php
                                            //p_type is used for tracking type
                                            echo form_dropdown("p_type", $p_type, isset($campaign['p_type']) ? $campaign['p_type'] : '', "class='form-control' ");
                                            ?>
                                        </div>
                                    </div>


                                    <div class="form-group"> 
                                        <div class="col-sm-2">
                                        </div>
                                        <div class="col-sm-10">
                                            <button  type="button" ng-click="ShowTab('TargetTab')" class="btn btn-purple waves-effect waves-light">
                                                <span class="fa fa-arrow-left"></span>
                                                Prev</button>
                                            <button  type="submit" class="btn btn-purple waves-effect waves-light">
                                                <span class="fa fa-save"></span>
                                                {{saveBtn}}</button>
                                            <button type="Reset" class="btn btn-danger waves-effect waves-light">
                                                <span class="fa fa-remove"></span>
                                                Cancel</button>
                                        </div>
                                    </div>

                                </div> 
                            </div>



                            <!-- step 5 end-->
                        </div>





                    </div>





                </form>
                <?php
                $this->load->view("admin/offer/offer_test/testing");
                ?>

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
            live: 'enable',
            excluded: [':disabled'],
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
            
        }).on('error.form.bv', function (e) {
            
            $.Notification.autoHideNotify('error',
                    'botton right',
                    "Please check all mendatory fields.",
                    '');
            
        });
    });
</script>
<script>
    //var Offer = angular.module("Offer", []);
    viral_pro.controller("AddOffer", function ($scope) {
        
        $scope.message = "";
        $scope.saveBtn = "<?php echo $SubmitBtn ?>";
        $scope.redirection = '0';
        
        $scope.action = "<?php echo $FormAction ?>";
        
        $scope.revenue_type = 7; // 7 is used for RPI , Revenue per install;
        $scope.payout_type = 8; // default selected installs
        
<?php
if (!empty($post)) {
    ?>
            $scope.image = "<?php echo $post['image'] ?>";
            $scope.title = "<?php echo $post['title'] ?>";
            //$scope.meta = new String("<?php //echo  $post['meta']                                                ?>");
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
        
        $scope.onSelectGlobe = function ()
        {
            if ($scope.globalCountry)
                $("#offer_countries").select2("enable", false);
            else
                $("#offer_countries").select2("enable", true);
            //$scope.globalCountry";
        };
        
        $scope.onSelectAlloffer_devices = function ()
        {
            if ($scope.Alloffer_devices)
                $("#offer_devices").select2("enable", false);
            else
                $("#offer_devices").select2("enable", true);
            //$scope.globalCountry";
        };
        
        $scope.onSelectAlloffer_OS = function ()
        {
            if ($scope.Alloffer_OS)
                $("#offer_OS").select2("enable", false);
            else
                $("#offer_OS").select2("enable", true);
            //$scope.globalCountry";
        };
        
        $scope.ShowTab = function (tab_id)
        {
//            if (!$("#catForm").data('bootstrapValidator').validate().isValid())
//            {
//
//                //alert("Form Not Valida");
//                return  false;
//            }
            $("div.OfferTabs").hide();
            $("#" + tab_id).show();
        };
        
        
        $scope.macros = {};
        
        $scope.getMacros = function () {
            
            $.ajax({
                url: "<?php echo SITEURL . "admin/macros/getMacros" ?>",
                type: 'POST',
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.macros = data['macros'];
                    $scope.$apply();
                }
            });
            
        };
        
        $scope.getMacros();
        
        
        $scope.onchnageRedirection = function ()
        {
            // console.log($scope.redirection);
            
            
            
            if ($scope.redirection == 1)
            {
                $("#redirectOptio").show();
            } else
            {
                $("#redirectOptio").hide();
            }
            
        };
        
        
<?php
if (isset($campaign['geo'])) {
    ?>
            $scope.onSelectGlobe();
    <?php
}
?>
        $scope.selectRevenuetype = function(){
            
//            alert('clicked'+ $scope.payout_type);
            switch ($scope.payout_type) {
                case '6': $scope.revenue_type=3; break;
                case '5': $scope.revenue_type=2; break;
                case '4': $scope.revenue_type=1; break;
                case '8': $scope.revenue_type=7; break;
                case '11': $scope.revenue_type=9; break;
                case '12': $scope.revenue_type=10; break;
                default:             
                    break;
            }
            
        };
        
        $scope.CreateUpdateOffer = function () {
            
            if (!$("#catForm").data('bootstrapValidator').validate().isValid())
            {
                
                //alert("Form Not Valida");
                return  false;
            }
            
            
            
            
            var url_slug = btoa($scope.url_slug);
            $scope.baseUrl_slug = url_slug;
            
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
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
//                data: $("#catForm").serialize()+"&baseUrl_slug="+url_slug,
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
                        
                        // window.location = data['redirect'];
                        
                        $("#post_idUrl").val(data['post_id']);
                        
                        $scope.ShowTab('TestingTab');
                        angular.element(document.getElementById('TestingTab')).scope().approve_offer();
                        
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
        
        $scope.getHttpPost = function ()
        {
            var url = $scope.preview_link;
            $.ajax({
                url: "<?php echo SITEURL . "admin/post/getPostDataHttp" ?>",
                type: 'POST',
                data: 'url=' + url,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $scope.title = data['title'];
                        $scope.meta = data['meta'];
                        $scope.image = data['image'];
                        $scope.$apply();
                    }
                    
                }
            });
        };
        
        
        
        
        
        
        
        
    });
</script>
