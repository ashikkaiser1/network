<div class="row">
    <?php $i = 0; ?>
    <div class="col-sm-12">
        <div class="panel panel-default"  ng-controller="AddUpdateSystem">
            <div class="panel-heading"><h3 class="panel-title"><?php echo $title ?></h3></div>
            <div class="panel-body">
                <form class="form-horizontal col-md-7" id="SystemForm" role="form" ng-submit="CreateUpdateSystemSetting()">                                    
                    <div class="form-group">
                        <label class="col-md-3 control-label">Transaction Type</label>
                        <div class="col-md-9">
                            <?php
                            echo form_hidden("option[$i][option_name]", "transactionIdType");
                            echo form_dropdown("option[$i][option_value]", $tr_type, isset($settings['transactionIdType']) ? $settings['transactionIdType'] : '', "class='form-control'");
                            $i++;
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Currency </label>
                        <div class="col-md-9">
                            <?php
                            echo form_hidden("option[$i][option_name]", "CURR");
                            echo form_input("option[$i][option_value]", isset($settings['CURR']) ? $settings['CURR'] : '', "class='form-control'");
                            $i++;
                            ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 control-label">Offer Wall Points Maths : 1 <?php echo CURR ?> is equals to </label>
                        <div class="col-md-9">
                            <?php
                            echo form_hidden("option[$i][option_name]", "POINTS");
                            echo form_input("option[$i][option_value]", isset($settings['POINTS']) ? $settings['POINTS'] : '', "class='form-control' placeholder='Points'");
                            $i++;
                            ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-3 control-label">Users Auto Approval</label>
                        <div class="col-md-9"> 
                            <?php
                            echo form_hidden("option[$i][option_name]", "AUTO_APPROVAL");
                            echo form_dropdown("option[$i][option_value]", array("1" => "Enable", "0" => "Disable"), isset($settings['AUTO_APPROVAL']) ? $settings['AUTO_APPROVAL'] : '1', "class='form-control'");
                            $i++;
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Affiliate Refferal Amt.</label>
                        <div class="col-md-9">
                            <?php
                            echo form_hidden("option[$i][option_name]", "REFERAL_AMT");
                            echo form_input("option[$i][option_value]", isset($settings['REFERAL_AMT']) ? $settings['REFERAL_AMT'] : '0', "class='form-control'");
                            $i++;
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Advertiser Commission Cut.(%)</label>
                        <div class="col-md-9">
                            <?php
                            echo form_hidden("option[$i][option_name]", "COMM_PERCENTAGE");
                            echo form_input("option[$i][option_value]", isset($settings['COMM_PERCENTAGE']) ? $settings['COMM_PERCENTAGE'] : '0', "class='form-control'");
                            $i++;
                            ?>
                        </div>
                    </div>




                    <div class="form-group">
                        <label class="col-md-3 control-label">PROTOCOL </label>
                        <div class="col-md-9">
                            <?php
                            echo form_hidden("option[$i][option_name]", "PROTOCOL");
                            echo form_input("option[$i][option_value]", isset($settings['PROTOCOL']) ? $settings['PROTOCOL'] : '', "class='form-control'");
                            $i++;
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Site Url </label>
                        <div class="col-md-9">
                            <?php
                            echo form_hidden("option[$i][option_name]", "SITEURL");
                            echo form_input("option[$i][option_value]", isset($settings['SITEURL']) ? $settings['SITEURL'] : '', "class='form-control'");
                            $i++;
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Site Name </label>
                        <div class="col-md-9">
                            <?php
                            echo form_hidden("option[$i][option_name]", "SITENAME");
                            echo form_input("option[$i][option_value]", isset($settings['SITENAME']) ? $settings['SITENAME'] : '', "class='form-control'");
                            $i++;
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Host</label>
                        <div class="col-md-9">
                            <?php
                            echo form_hidden("option[$i][option_name]", "HOST");
                            echo form_input("option[$i][option_value]", isset($settings['HOST']) ? $settings['HOST'] : '', "class='form-control'");
                            $i++;
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Postback</label>
                        <div class="col-md-9">
                            <?php
                            echo form_hidden("option[$i][option_name]", "STOSPOSTBACK");
                            echo form_input("option[$i][option_value]", isset($settings['STOSPOSTBACK']) ? $settings['STOSPOSTBACK'] : '', "class='form-control'");
                            $i++;
                            ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-3 control-label">Impression pixel</label>
                        <div class="col-md-9">
                            <?php
                            echo form_hidden("option[$i][option_name]", "IMP_URL");
                            echo form_input("option[$i][option_value]", isset($settings['IMP_URL']) ? $settings['IMP_URL'] : '', "class='form-control'");
                            $i++;
                            ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-3 control-label">Conversion pixel</label>
                        <div class="col-md-9">
                            <?php
                            echo form_hidden("option[$i][option_name]", "CONV_PIXEL");
                            echo form_input("option[$i][option_value]", isset($settings['CONV_PIXEL']) ? $settings['CONV_PIXEL'] : '', "class='form-control'");
                            $i++;
                            ?>
                        </div>
                    </div>





                    <div class="form-group">
                        <label class="col-md-3 control-label">Email Account</label>
                        <div class="col-md-9">
                            <?php
                            echo form_hidden("option[$i][option_name]", "EMAIL_ACC");
                            echo form_input("option[$i][option_value]", isset($settings['EMAIL_ACC']) ? $settings['EMAIL_ACC'] : '', "class='form-control'");
                            $i++;
                            ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-3 control-label">Email Protocol</label>
                        <div class="col-md-9">
                            <?php
                            echo form_hidden("option[$i][option_name]", "EMAIL_PROTOCOL");
                            echo form_input("option[$i][option_value]", isset($settings['EMAIL_PROTOCOL']) ? $settings['EMAIL_PROTOCOL'] : '', "class='form-control'");
                            $i++;
                            ?>
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-md-3 control-label">Email host</label>
                        <div class="col-md-9">
                            <?php
                            echo form_hidden("option[$i][option_name]", "EMAIL_SMTP_HOST");
                            echo form_input("option[$i][option_value]", isset($settings['EMAIL_SMTP_HOST']) ? $settings['EMAIL_SMTP_HOST'] : '', "class='form-control'");
                            $i++;
                            ?>
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-md-3 control-label">Email port</label>
                        <div class="col-md-9">
                            <?php
                            echo form_hidden("option[$i][option_name]", "EMAIL_SMTP_PORT");
                            echo form_input("option[$i][option_value]", isset($settings['EMAIL_SMTP_PORT']) ? $settings['EMAIL_SMTP_PORT'] : '', "class='form-control'");
                            $i++;
                            ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-3 control-label">Email user</label>
                        <div class="col-md-9">
                            <?php
                            echo form_hidden("option[$i][option_name]", "EMAIL_SMTP_USER");
                            echo form_input("option[$i][option_value]", isset($settings['EMAIL_SMTP_USER']) ? $settings['EMAIL_SMTP_USER'] : '', "class='form-control'");
                            $i++;
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Email password</label>
                        <div class="col-md-9">
                            <?php
                            echo form_hidden("option[$i][option_name]", "EMAIL_SMTP_PASS");
                            echo form_input("option[$i][option_value]", isset($settings['EMAIL_SMTP_PASS']) ? $settings['EMAIL_SMTP_PASS'] : '', "class='form-control'");
                            $i++;
                            ?>
                        </div>
                    </div>


                    <div class="form-group"> 
                        <div class="col-sm-3">
                        </div>
                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-purple waves-effect waves-light">
                                <span class="fa fa-save"></span>
                                {{saveBtn}}</button>
                            <button type="Reset" class="btn btn-danger waves-effect waves-light">
                                <span class="fa fa-remove"></span>
                                Cancel</button>
                        </div>
                    </div>
                </form>

                <div class="col-md-5">
                    <?php $this->load->view("admin/system/logo_favicon_manage") ?>
                </div>
            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col -->
</div>
<script>
    $(function () {

        $('#SystemForm').bootstrapValidator({
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
    viral_pro.controller("AddUpdateSystem", function ($scope) {

        $scope.message = "";
        $scope.saveBtn = "Save";
        $scope.action = "<?php echo $FormAction ?>";
        $scope.CreateUpdateSystemSetting = function () {
            if (!$("#SystemForm").data('bootstrapValidator').validate().isValid())
            {
                return  false;
            }
            $scope.saveBtn = "Creating";
            var fom = $("#SystemForm")[0];
            $scope.saveBtn = "<?php echo $Submiting ?>";

            console.log(fom);

            var formData = new FormData(fom);
            console.log(formData);

            //var form = new FormData($("#SystemForm"));
            $.ajax({
                url: $scope.action,
                type: 'POST',
                dataType: 'json',
                data: $("#SystemForm").serialize(),
                success: function (data, textStatus, jqXHR) {

                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');

                        // $("#SystemForm")[0].reset();
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

    });
</script>
