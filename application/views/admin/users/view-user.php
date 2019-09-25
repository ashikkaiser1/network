<div class="row">
    <div class="col-sm-12">
        <!--        <h1 class="text-danger">Don't use this module.</h1>-->
        <div class="panel panel-default"  >
            <div class="panel-heading"><h3 class="panel-title">
                    <a href="<?php echo SITEURL . "admin/users/ShowUsers" ?>" class=" btn btn-purple waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-list"></span> All Users</a>
                    <?php echo $panel_title ?></h3></div>
            <div class="panel-body">


                <div class="right" style="    float: right;">

                    <?php
                    if ($user['UTID'] < 4) {
                        ?>
                        <a   href="<?php echo SITEURL . "admin/users/UpdateUser/" . $user['uid'] ?>" type="button" class="btn btn-primary waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span> Edit</a>

                        <?php
                    } else if ($user['UTID'] >= 4) {
                        ?>
                        <a   href="<?php echo SITEURL . "admin/employee/UpdateEmployee/" . $user['uid'] ?>" type="button" class="btn btn-primary waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span> Edit</a>
                        <?php
                    }
                    ?>

                    <a   class="btn btn-primary waves-effect waves-light m-b-5 btn-xs" href="<?php echo SITEURL . "admin/globalpostback/index/" . $user['uid'] ?>"><span class="fa fa-link"></span> Global Post back</a>
              <!--                                            <button type="button" class="btn btn-info waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-eye"></span></button>
                                      <a  ng-if="user.UTID < 4" href="<?php echo SITEURL . "admin/users/UpdateUser/" ?>{{user.uid}}" type="button" class="btn btn-primary waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span></a>
                                      <a  ng-if="user.UTID >= 4" href="<?php echo SITEURL . "admin/employee/UpdateEmployee/" ?>{{user.uid}}" type="button" class="btn btn-primary waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span></a>


                                      <a   class="btn btn-primary waves-effect waves-light m-b-5 btn-xs" href="<?php echo SITEURL . "admin/globalpostback/index/" ?>{{user.uid}}"><span class="fa fa-link"></span></a>
                                      <button type="button" class="btn btn-danger waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-trash"></span></button>-->
                </div>

                <form class="form-horizontal" role="form" id="usersForm" ng-submit="createUser_updateUser()"> 
                    <div class="form-group">
                        <label class="col-md-2 control-label custom-label-cls">Date</label>
                        <div class="col-md-4">

                            <?php echo isset($user['DOJ']) ? $user['DOJ'] : 'NILL' ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label custom-label-cls">Company</label>
                        <div class="col-md-4">
                            <?php echo isset($user['company']) ? $user['company'] : 'NIlL' ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label custom-label-cls">Name</label>
                        <div class="col-md-4">
                            <?php echo isset($user['name']) ? $user['name'] : 'NILL' ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label custom-label-cls" for="">Email</label>
                        <div class="col-md-4">
                            <?php
                            if (!isset($user['email'])) {
                                ?>
                                <?php echo isset($user['email']) ? $user['email'] : 'NILL' ?>
                                <?php
                            } else {
                                echo $user['email'];
                            }
                            ?>


                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label custom-label-cls" for="">User ID</label>
                        <div class="col-md-4">
                            <?php
                            if (!isset($user['username'])) {
                                ?>
                                <?php echo isset($user['username']) ? $user['username'] : 'NILL' ?>
                                <?php
                            } else {
                                echo $user['username'];
                            }
                            ?>

                        </div>
                    </div>

                    <!--                    <div class="form-group">
                                            <label class="col-md-2 control-label custom-label-cls">Password</label>
                                            <div class="col-md-4">
                    <?php // echo isset($user['password']) ? $user['password'] :'NILL'  ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label custom-label-cls">Password R-Type</label>
                                            <div class="col-md-4">
                    <?php // echo isset($user['re_password']) ? $user['re_password'] :'NILL' ?>
                                            </div>
                                        </div>-->




                    <div class="form-group">
                        <label class="col-md-2 control-label custom-label-cls" for="">Contact</label>
                        <div class="col-md-4">
                            <?php echo isset($user['contact']) ? $user['contact'] : 'NILL' ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label custom-label-cls" for="">Skype</label>
                        <div class="col-md-4">
                            <?php echo isset($user['skype_id']) ? $user['skype_id'] : 'NILL' ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label custom-label-cls" for="">Best Time to Reach You?</label>
                        <div class="col-md-4">
                            <?php echo isset($user['contact_time']) ? $user['contact_time'] : 'NILL' ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label custom-label-cls ">
                            Contact Time zone <span class='text-danger'>*</span></label>
                        <div class="col-md-4">
                            <?php echo form_dropdown("contact_timezone", $timeZone, isset($user['contact_timezone']) ? $user['contact_timezone'] : 'NILL', "class='select2 form-control' disabled='true' ") ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label custom-label-cls" for="">Suggested AM</label>
                        <div class="col-md-4">
                            <?php echo isset($user['contact_am']) ? $user['contact_am'] : 'NILL' ?>
                            <?php // echo print_r($user) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label custom-label-cls" for="">Additional Notes</label>
                        <div class="col-md-4">

                            <?php echo isset($user['contact_notes']) ? $user['contact_notes'] : 'NILL' ?>

                        </div>
                    </div>




                    <div class="form-group">
                        <label class="col-md-2 control-label custom-label-cls ">
                            Country <span class='text-danger'>*</span></label>
                        <div class="col-md-4">
                            <?php echo form_dropdown("country_id", $country, isset($user['country_id']) ? $user['country_id'] : 'NILL', "class='select2 form-control' disabled='true'") ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label custom-label-cls ">
                            Timezone <span class='text-danger'>*</span></label>
                        <div class="col-md-4">
                            <?php echo form_dropdown("timeZone", $timeZone, isset($user['timeZone']) ? $user['timeZone'] : 'NILL', "class='select2 form-control' disabled='true' ") ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label custom-label-cls">Address</label>
                        <div class="col-md-6">
                            <?php echo isset($user['address']) ? $user['address'] : 'NILL' ?>
                        </div>
                    </div>
                    <?php
                    if ((isset($UTID) && $UTID == AFFILIATE) || (isset($user['UTID']) && $user['UTID'] == AFFILIATE)) {
                        ?>
                        <div class="form-group">
                            <label class="col-md-2 control-label custom-label-cls">Traffic Info </label>
                            <div class="col-md-10">
                                <div class="">
                                    <div class="panel-group panel-group-joined" id="accordion-test"> 
                                        <div class="panel panel-default"> 
                                            <div class="panel-heading"> 
                                                <h4 class="panel-title"> 

                                                    Traffic Info Option

                                                </h4> 
                                            </div> 

                                            <div class="panel-body">

                                                <div class="form-group">
                                                    <label class="col-md-12 control-label custom-label-cls text-left" style="text-align:left;font-weight:normal">
                                                        What are the verticals that you are currently running?<span class='text-danger'>*</span></label>
                                                    <div class="col-md-10">
                                                        <?php echo form_multiselect("trafic_info[offer_veticals][]", $offerCategory, isset($trafic_info['offer_veticals']) ? $trafic_info['offer_veticals'] : 'NILL', "class='select2 form-control' disabled='true'") ?>

                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label class="col-md-12 control-label custom-label-cls text-left" style="text-align:left;font-weight:normal">
                                                        What are the offer types that you are currently running?<span class='text-danger'>*</span></label>
                                                    <div class="col-md-10">

                                                        <?php foreach ($offerType as $key => $val) {
                                                            ?>
                                                            <div  class="col-md-3" >
                                                                <label style="font-weight:normal">
                                                                    <input type="checkbox" name="trafic_info[offer_type][]" <?php echo isset($trafic_info['offer_type'][$key]) && $trafic_info['offer_type'][$key] == $key ? "checked='true'" : 'NILL' ?> value="<?php echo $key ?>" > <?php echo $val ?></label>
                                                            </div>
                                                        <?php }
                                                        ?>
                                                        <!--                                                        <div  class="col-md-3" >
                                                                                                                    <label style="font-weight:normal">
                                                                                                                        <input type="checkbox"  value="others" class="check_offer_type"> Others</label>
                                                                                                                </div>-->


                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-12 control-label custom-label-cls text-left" style="text-align:left;font-weight:normal">
                                                        What other networks do you work with(AM's name,telephone,email,IM)?<span class='text-danger'>*</span></label>
                                                    <div class="col-md-10">
                                                        <div class="col-md-10">
                                                            <div class="form-group">
                                                                <label class="col-md-2 control-label custom-label-cls text-left" style="font-weight:normal">Network Name</label>
                                                                <div class="col-md-5">
                                                                    <?php echo isset($otherNetwork['network_name']) ? $otherNetwork['network_name'] : 'NILL' ?>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-md-2 control-label custom-label-cls text-left" style="font-weight:normal">Account Manager</label>
                                                                <div class="col-md-5">
                                                                    <?php echo isset($otherNetwork['acc_manager']) ? $otherNetwork['acc_manager'] : 'NILL' ?>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-md-2 control-label custom-label-cls text-left" style="font-weight:normal">Phone</label>
                                                                <div class="col-md-5">
                                                                    <?php echo isset($otherNetwork['phone']) ? $otherNetwork['phone'] : 'NILL' ?>

                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-md-2 control-label custom-label-cls text-left" style="font-weight:normal">Email</label>
                                                                <div class="col-md-5">
                                                                    <?php echo isset($otherNetwork['email']) ? $otherNetwork['email'] : 'NILL' ?>
                                                                </div>
                                                            </div>


                                                        </div>


                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label class="col-md-12 control-label custom-label-cls text-left" style="text-align:left;font-weight:normal">
                                                        What are the Verticals that you're interested in running/learning about more with us?<span class='text-danger'>*</span></label>
                                                    <div class="col-md-10">
                                                        <?php echo form_multiselect("trafic_info[offer_interest][]", $offerCategory, isset($trafic_info['offer_interest']) ? $trafic_info['offer_interest'] : 'NILL', "class='select2 form-control' disabled='true'") ?>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-12 control-label custom-label-cls text-left" style="text-align:left;font-weight:normal">Are there specific offers you are looking to run with our network and how did you find out about them?<span class='text-danger'>*</span></label>
                                                    <div class="col-md-10">
                                                        <?php echo isset($user['offer_specific']) ? $user['offer_specific'] : 'NILL' ?>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-12 control-label custom-label-cls text-left" style="text-align:left;font-weight:normal">What top 3 Regions do you mostly run in? <span class='text-danger'>*</span></label>
                                                    <div class="col-md-10">
                                                        <div class="col-md-10">
                                                            <?php echo form_multiselect("trafic_info[offer_countries][]", $country, isset($trafic_info['offer_countries']) ? $trafic_info['offer_countries'] : 'NILL', "class='select2 form-control' disabled='true'") ?>
                                                        </div>
                                                    </div>
                                                </div>

                                            <!--                                What traffic types do you generally use for promotional purposes?<span class='text-danger'>*</span>-->

                                                <div class="form-group">
                                                    <label class="col-md-12 control-label custom-label-cls text-left" style="text-align:left;font-weight:normal">What traffic types do you generally use for promotional purposes?<span class='text-danger'>*</span></label>
                                                    <div class="col-md-10">
                                                        <?php foreach ($trafficType as $key => $val) {
                                                            ?>
                                                            <div  class="col-md-3" >
                                                                <label style="font-weight:normal">
                                                                    <input type="checkbox" name="trafic_info[offer_promotional][]"  <?php echo isset($trafic_info['offer_promotional'][$key]) && $trafic_info['offer_promotional'][$key] == $key ? "checked='true'" : 'NILL' ?>  value="<?php echo $key ?>" > <?php echo $val ?></label>
                                                            </div>
                                                        <?php }
                                                        ?>
                                                        <!--                                                        <div class="col-md-3" >
                                                                                                                    <label style="font-weight:normal">
                                                                                                                        <input type="checkbox" name="" value="other" class="check_offer_promotional"> Other</label>
                                                                                                                </div>-->


                                                    </div>
                                                </div>
                                            </div> 

                                        </div> 

                                    </div>








                                </div> 

                            </div>
                        </div>

                    <?php } ?>

                    
                    <div class="form-group">
                        <label class="col-md-2 control-label custom-label-cls">Paypal Email</label>
                        <div class="col-md-4">
                            <?php echo isset($user['paypal_email']) &&  $user['paypal_email'] !='' ? $user['paypal_email'] : 'NILL' ?>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-md-2 control-label custom-label-cls">Payoneer No.</label>
                        <div class="col-md-4">
                            <?php echo isset($user['payoneer']) &&  $user['payoneer'] !='' ? $user['payoneer'] : 'NILL' ?>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-md-2 control-label custom-label-cls">Bank Name</label>
                        <div class="col-md-4">
                            <?php echo isset($user['bank_name']) &&  $user['bank_name'] !='' ? $user['bank_name'] : 'NILL' ?>
                        </div>
                    </div>          
                    <div class="form-group">
                        <label class="col-md-2 control-label custom-label-cls">Bank Account No.</label>
                        <div class="col-md-4">
                            <?php echo isset($user['bank_account']) &&  $user['bank_account'] !='' ? $user['bank_account']  : 'NILL' ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label custom-label-cls">IFSC Code</label>
                        <div class="col-md-4">
                            <?php echo isset($user['IFSC_code']) &&  $user['IFSC_code'] !='' ? $user['IFSC_code'] : 'NILL' ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label custom-label-cls">PAN Number</label>
                        <div class="col-md-4">
                            <?php echo isset($user['PAN']) &&  $user['PAN'] !='' ?  $user['PAN'] : 'NILL' ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label custom-label-cls">Swift Code</label>
                        <div class="col-md-10">
                            <?php echo isset($user['swift_code']) &&  $user['swift_code'] !='' ? $user['swift_code'] : 'NILL' ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label custom-label-cls">Bank Verification</label>
                        <div class="col-md-3">
                            <?php
                            echo form_dropdown("bank_verification_status", array("1" => "Verified", "0" => "Not Verified"), isset($user['bank_verification_status']) ? $user['bank_verification_status'] : 'NILL', "class='form-control' disabled='true'")
                            ?>  

                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-2 control-label custom-label-cls">User Verification</label>
                        <div class="col-md-3">
                            <?php
                            echo form_dropdown("verified", array("1" => "Verified", "0" => "Not Verified"), isset($user['verified']) ? $user['verified'] : 'NILL', "class='form-control' disabled='true'")
                            ?> 

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label custom-label-cls">User status</label>
                        <div class="col-md-3">
                            <?php
                            echo form_dropdown("status", $status, isset($user['u_status']) ? $user['u_status'] : 'NILL', "class='form-control'disabled='true'")
                            ?> 
<!--                            <select name="status" class="form-control">
        <option value="1">Active</option>
        <option value="0">De-Active</option>
    </select>-->
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label custom-label-cls">Account Manager</label>
                        <div class="col-sm-3">
                            <?php
                            echo form_dropdown("manager", $AccManager, isset($user['manager']) ? $user['manager'] : '', "class='form-control select2' disabled='true' ")
                            ?> 


                        </div>
                    </div>




                    <div class="form-group">
                        <label class="col-sm-2 control-label custom-label-cls">User Type</label>
                        <div class="col-sm-3">
                            <?php
                            echo form_dropdown("UTID", array("1" => "Administrator", "2" => "Affiliate", "3" => "Advertiser"), isset($user['UTID']) ? $user['UTID'] : 'NILL', "class='form-control' disabled='true'")
                            ?> 


                        </div>
                    </div>

                    <!--                    <div class="form-group"> 
                                            <div class="col-sm-2">
                                            </div>
                                            <div class="col-sm-10">
                    
                                                <button type="submit" class="btn btn-purple waves-effect waves-light">{{saveBtn}}</button>
                                                <button type="Reset" class="btn btn-danger waves-effect waves-light">Cancel</button>
                                            </div>
                                        </div>-->

                </form>
            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col -->
</div>
