<div class="row">
    <div class="col-sm-12">
        <!--        <h1 class="text-danger">Don't use this module.</h1>-->
        <div class="panel panel-default"  ng-controller="add_update_offer_Cat">
            <div class="panel-heading"><h3 class="panel-title">
                    <?php echo $panel_title ?>
                </h3></div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" id="OfferCateForm" ng-submit="create_update_offer_cat()"> 
                    <div class="form-group">
                        <label class="col-md-2 control-label">Title</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="title" value="<?php echo isset($offer_category['title']) ? $offer_category['title'] : '' ?>" placeholder="">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Status</label>
                        <div class="col-md-3">
                            <?php
                            echo form_dropdown("status", array("1" => "Active", "0" => "IN-Active"), isset($offer_category['status']) ? $offer_category['status'] : '', "class='form-control'")
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

        $('#OfferCateForm').bootstrapValidator({
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
                title: {// field name
                    validators: {
                         notEmpty: {
                            message: 'Title field cannot be empty'
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
    viral_pro.controller("add_update_offer_Cat", function ($scope) {

        $scope.message = "";
        $scope.saveBtn = "<?php echo $FormSubmitBtn ?>";
        $scope.action = "<?php echo $FormAction ?>";
        $scope.create_update_offer_cat = function () {
            //if (!$("#postForm").data('bootstrapValidator').validate().isValid())
            if (!$("#OfferCateForm").data('bootstrapValidator').validate().isValid())
            {

                return  false;
            }
            var fom = $("#OfferCateForm")[0];
            $scope.saveBtn = "<?php echo $SubmitAction ?>";

            console.log(fom);

            var formData = new FormData(fom);
            console.log(formData);

            //var form = new FormData($("#OfferCateForm"));
            $.ajax({
                url: $scope.action,
                type: 'POST',
                dataType: 'json',
                data: $("#OfferCateForm").serialize(),
                success: function (data, textStatus, jqXHR) {
                    $scope.saveBtn = "<?php echo $FormSubmitBtn ?>";
                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
                        if ($scope.saveBtn !== "Update")
                            $("#OfferCateForm")[0].reset();

                        angular.element(document.getElementById('OfferCatController')).scope().searchByForm();

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