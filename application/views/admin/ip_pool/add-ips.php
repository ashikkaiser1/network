<div class="row">
    <div class="col-sm-12">
        <!--        <h1 class="text-danger">Don't use this module.</h1>-->
        <div class="panel panel-default"  ng-controller="add_update_ip">
            <div class="panel-heading"><h3 class="panel-title">
                    <?php echo $panel_title ?>
                </h3></div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" id="IPFORM" ng-submit="create_update_ips()"> 
                    <div class="form-group">
                        <label class="col-md-2 control-label">IP Address</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="ip_address" value="<?php echo isset($ip_pool['ip_address']) ? $ip_pool['ip_address'] : '' ?>" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Domain</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="name" value="<?php echo isset($ip_pool['name']) ? $ip_pool['name'] : '' ?>" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">IP status</label>
                        <div class="col-md-3">
                            <?php
                            echo form_dropdown("status", array("1" => "Active", "0" => "IN-Active"), isset($ip_pool['status']) ? $ip_pool['status'] : '', "class='form-control'")
                            ?> 

                        </div>
                    </div>

                    <div class="form-group"> 
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-10">

                            <button type="submit" class="btn btn-purple waves-effect waves-light">
                                <span class="fa fa-save"></span>
                                {{saveBtn}}</button>
                            <button type="Reset" class="btn btn-danger waves-effect waves-light">
                                <span class="fa fa-remove"></span>
                                Cancel</button>
                        </div>
                    </div>

                </form>
            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col -->
</div>
<script>
    $(function () {

        $('#IPFORM').bootstrapValidator({
            message: false,
//            container: 'tooltip',
            trigger: null,
            live: 'enabled',
//            
            feedbackIcons: {
                // valid: 'glyphicon glyphicon-ok',
                // invalid: 'glyphicon glyphicon-remove',
                // validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                ip_address: {// field name
                    validators: {
                       ip: {
                            message: 'Please enter a valid IP address'
                        },
                    },
                }
            }

        }).on('success.form.bv', function (e) {
            e.preventDefault();

        });
    });
</script>

<script>
    //var users = angular.module("users", []);
    viral_pro.controller("add_update_ip", function ($scope) {

        $scope.message = "";
        $scope.saveBtn = "<?php echo $FormSubmitBtn ?>";
        $scope.action = "<?php echo $FormAction ?>";
        $scope.create_update_ips = function () {
            //if (!$("#postForm").data('bootstrapValidator').validate().isValid())
            if (!$("#IPFORM").data('bootstrapValidator').validate().isValid())
            {

                return  false;
            }
            var fom = $("#IPFORM")[0];
            $scope.saveBtn = "<?php echo $SubmitAction ?>";

            console.log(fom);

            var formData = new FormData(fom);
            console.log(formData);

            //var form = new FormData($("#IPFORM"));
            $.ajax({
                url: $scope.action,
                type: 'POST',
                dataType: 'json',
                data: $("#IPFORM").serialize(),
                success: function (data, textStatus, jqXHR) {
                    $scope.saveBtn = "<?php echo $FormSubmitBtn ?>";
                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
                        if ($scope.saveBtn !== "Update")
                            $("#IPFORM")[0].reset();

                        angular.element(document.getElementById('ip_controller')).scope().searchByForm();

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