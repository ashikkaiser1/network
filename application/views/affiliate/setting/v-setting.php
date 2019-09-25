<div class="page-wrapper" ng-controller="sett_con">

            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                     <h3 class="text-themecolor">Setting</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Account</a></li>

                        <li class="breadcrumb-item active">Setting</li>
                       
                    </ol>
                </div>
            </div>



    <div class="col-sm-12">
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title"> Setting</h3></div>
            <div class="">

                <div class="col-lg-12"> 
                    <div class="panel-group panel-group-joined" id="accordion-test"> 
                        <div class="panel panel-default"> 
                            <div class="panel-heading"> 
                                <h4 class="panel-title"> 
                                    <a data-toggle="collapse" data-parent="#accordion-test" href="#collapseOne" class="" aria-expanded="<?php echo (isset($section) && $section == 1) ? 'true' : 'false';?>">
                                        Basic Info
                                    </a> 
                                </h4> 
                            </div> 
                            <div id="collapseOne" class="panel-collapse collapse <?php echo (isset($section) && $section == 1) ? 'in' : '';?>" aria-expanded="<?php echo (isset($section) && $section == 1) ? 'true' : 'false';?>">  <!--style="height: 0px;" -->
                                <div class="panel-body">
                                    <form class="form-horizontal" role="form" id="usersForm_basic" ng-submit="updateUser('basic')"> 

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Name</label>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" name="name" value="<?php echo isset($user['name']) ? $user['name'] : '' ?>" value="Johan">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label" for="">Email</label>
                                            <div class="col-md-10">
                                                <input type="email" id="example-email" value="<?php echo isset($user['email']) ? $user['email'] : '' ?>"  name="email" class="form-control" placeholder="johan@email.com">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Address</label>
                                            <div class="col-md-10">
                                                <textarea class="form-control" name="address" rows="5"><?php echo isset($user['address']) ? $user['address'] : '' ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group"> 
                                            <div class="col-sm-2">
                                            </div>
                                            <div class="col-sm-10">

                                                <button type="submit" class="btn btn-info waves-effect waves-light">{{saveBtn}}</button>
                                                <button type="Reset" class="btn btn-danger waves-effect waves-light">Cancel</button>
                                            </div>
                                        </div>

                                    </form>
                                </div> 
                            </div> 
                        </div> 
                        
                        <div class="card"> 
                            <div class="card-body"> 
                                <h4 class="card-title"> 
                                    <a data-toggle="collapse" data-parent="#accordion-test" href="#collapseTwo" aria-expanded="<?php echo (isset($section) && $section == 2) ? 'true' : 'false';?>" class="collapsed">
                                        Security
                                    </a> 
                                </h4> 
                            </div> 
                            <div id="collapseTwo" class="panel-collapse collapse <?php echo (isset($section) && $section == 2) ? 'in' : '';?>" aria-expanded="<?php echo (isset($section) && $section == 2) ? '' : 'false'; ?>"> 
                                <div class="panel-body">
                                    <form class="form-horizontal" role="form" id="usersForm_security" ng-submit="updateUser('security')"> 

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Old Password</label>
                                            <div class="col-md-10">
                                                <input type="password" class="form-control" value=""  name="old_password" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">New Password</label>
                                            <div class="col-md-10">
                                                <input type="password" class="form-control" value=""  name="password" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Password R-Type</label>
                                            <div class="col-md-10">
                                                <input type="password" class="form-control" value=""  name="re_password" value="">
                                            </div>
                                        </div>
                                        <div class="form-group"> 
                                            <div class="col-sm-2">
                                            </div>
                                            <div class="col-sm-10">

                                                <button type="submit" class="btn btn-info waves-effect waves-light">{{saveBtn}}</button>
                                                <button type="Reset" class="btn btn-danger waves-effect waves-light">Cancel</button>
                                            </div>
                                        </div>

                                    </form>
                                </div> 
                            </div> 
                        </div> 
                         <div class="card"> 
                            <div class="card-body"> 
                                <h4 class="card-title"> 
                                    <a data-toggle="collapse" data-parent="#accordion-test" href="#collapseThree" class="collapsed" aria-expanded="<?php echo (isset($section) && $section == 3) ? 'true' : 'false';?>">
                                        Payment
                                    </a> 
                                </h4> 
                            </div> 
                            <div id="collapseThree" class="panel-collapse collapse <?php echo (isset($section) && $section == 3) ? 'in' : '';?>" aria-expanded="<?php echo (isset($section) && $section == 3) ? 'true' : 'false'; ?>"> 
                                <div class="panel-body">
                                    <form class="form-horizontal" role="form" id="usersForm_payment" ng-submit="updateUser('payment')"> 

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Paypal Email</label>
                                            <div class="col-md-10">
                                                <input type="text" name="paypal_email" value="<?php echo isset($user['paypal_email']) ? $user['paypal_email'] : '' ?>"  class="form-control" >
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Payoneer No.</label>
                                            <div class="col-md-10">
                                                <input type="text" name="payoneer" value="<?php echo isset($user['payoneer']) ? $user['payoneer'] : '' ?>"  class="form-control" >
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Bank Name</label>
                                            <div class="col-md-10">
                                                <input type="text" name="bank_name" value="<?php echo isset($user['bank_name']) ? $user['bank_name'] : '' ?>"  class="form-control" >
                                            </div>
                                        </div>          
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Bank Account No.</label>
                                            <div class="col-md-10">
                                                <input type="text" name="bank_account" value="<?php echo isset($user['bank_account']) ? $user['bank_account'] : '' ?>"  class="form-control" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">IFSC Code</label>
                                            <div class="col-md-10">
                                                <input type="text" name="IFSC_code" value="<?php echo isset($user['IFSC_code']) ? $user['IFSC_code'] : '' ?>"  class="form-control" placeholder="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">PAN Number</label>
                                            <div class="col-md-10">
                                                <input type="text" name="PAN" value="<?php echo isset($user['PAN']) ? $user['PAN'] : '' ?>"  class="form-control" placeholder="">
                                            </div>
                                        </div>
                                        <div class="form-group"> 
                                            <div class="col-sm-2">
                                            </div>
                                            <div class="col-sm-10">

                                                <button type="submit" class="btn btn-info waves-effect waves-light">{{saveBtn}}</button>
                                                <button type="Reset" class="btn btn-danger waves-effect waves-light">Cancel</button>
                                            </div>
                                        </div>

                                    </form>
                                </div> 
                            </div> 
                        </div> 



                        <div class="card"> 
                            <div class="card-body"> 
                                <h4 class="card-title"> 
                                    <a data-toggle="collapse" data-parent="#accordion-test" href="#collapseFour" class="collapsed" aria-expanded="<?php echo (isset($section) && $section == 4) ? 'true' : 'false'; ?>">
                                        Global Postback
                                    </a> 
                                </h4> 
                            </div> 
                            <div id="collapseFour" class="panel-collapse collapse <?php echo (isset($section) && $section == 4) ? 'in' : ''; ?>" aria-expanded="<?php echo (isset($section) && $section == 4) ? 'true' : 'false'; ?>"> 
                                <div class="panel-body">
                                    <?php
                                    if (isset($globalPostBack)) {
                                        echo $globalPostBack;
                                    }
                                    ?>
                                </div> 
                            </div> 
                        </div> 

                    </div> 
                </div>

                <!--                 !-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col -->
    </div>
</div>
<script>
    // var setting_app = angular.module("setting_app", ['ui.bootstrap']);
    viral_pro.controller("sett_con", function ($scope) {

        $scope.FormAction = "<?php echo SITEURL . "affiliate/setting/setting_edit" ?>";

        $scope.saveBtn = "Save";

        $scope.updateUser = function (type)
        {
            var form = $("#usersForm_" + type).serialize();
            $.ajax({
                url: $scope.FormAction + "?type=" + type,
                data: form,
                type: 'POST',
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
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
                }
            });
        };

    });
</script>

