<div class="row">
    <div class="col-sm-12">
        <!--        <h1 class="text-danger">Don't use this module.</h1>-->
        <div class="panel panel-default"  ng-controller="add_update_offer_url">
            <div class="panel-heading"><h3 class="panel-title">
                    <?php echo $panel_title ?>
                </h3></div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" id="OfferUrlForm" ng-submit="create_update_offer_url()"> 
                    <div class="form-group">
                        <label class="col-md-2 control-label" >Campaign</label>
                        <div class="col-md-10">
                            <?php echo form_dropdown("campaign_id", $camapign, isset($offerUrlData['campaign_id']) ? $offerUrlData['campaign_id'] : $campaign_id, "class='form-control campaign_id_select2 '") ?>  

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Name</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="name" value="<?php echo isset($offerUrlData['name']) ? $offerUrlData['name'] : '' ?>" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Preview Url</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="previewUrl" value="<?php echo isset($offerUrlData['previewUrl']) ? $offerUrlData['previewUrl'] : '' ?>" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Landing Url</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="url" value="<?php echo isset($offerUrlData['url']) ? $offerUrlData['url'] : '' ?>" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">status</label>
                        <div class="col-md-10">
                            <?php
                            echo form_dropdown("status", array("1" => "Active", "0" => "IN-Active"), isset($offerUrlData['status']) ? $offerUrlData['status'] : '', "class='form-control'")
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

        $('#OfferUrlForm').bootstrapValidator({
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
    viral_pro.controller("add_update_offer_url", function ($scope) {

        $scope.message = "";
        $scope.saveBtn = "<?php echo $SubmitBtn ?>";
        $scope.action = "<?php echo $FormAction ?>";
        $scope.create_update_offer_url = function () {
            //if (!$("#postForm").data('bootstrapValidator').validate().isValid())
            if (!$("#OfferUrlForm").data('bootstrapValidator').validate().isValid())
            {

                return  false;
            }
            var fom = $("#OfferUrlForm")[0];
            $scope.saveBtn = "<?php echo $Submiting ?>";

            console.log(fom);

            var formData = new FormData(fom);
            console.log(formData);

            //var form = new FormData($("#OfferUrlForm"));
            $.ajax({
                url: $scope.action,
                type: 'POST',
                dataType: 'json',
                data: $("#OfferUrlForm").serialize(),
                success: function (data, textStatus, jqXHR) {
                    $scope.saveBtn = "<?php echo $SubmitBtn ?>";
                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
                        if ($scope.saveBtn !== "Update")
                            $("#OfferUrlForm")[0].reset();

                        //angular.element(document.getElementById('ip_controller')).scope().searchByForm();

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