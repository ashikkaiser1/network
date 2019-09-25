<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default"  ng-controller="faqAddition">
            <div class="panel-heading"><h3 class="panel-title">
                 <a href="<?php echo SITEURL . "admin/faq/allFAQs" ?>" class=" btn btn-purple waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-list"></span> All FAQs</a>
                <?php echo $title ?></h3></div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" id="FaqFrom" ng-submit="CreateFaq()">                                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Title</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" value="<?php echo isset($faq['faq_title']) ? $faq['faq_title'] : '' ?>" name="faq_title">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Description</label>
                        <div class="col-md-8">
                            <textarea class="form-control" name="faq_desc" rows="5"><?php echo isset($faq['faq_desc']) ? $faq['faq_desc'] : '' ?></textarea>

                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="col-md-2 control-label">Sort Order</label>
                        <div class="col-md-4">
                            <?php
                            echo form_dropdown("faq_order", range(0, 40), isset($faq['faq_order']) ? $faq['faq_status'] : '', "class='form-control' ");
                            ?>
                        </div>
                    </div>
                    
                    

                    <div class="form-group">
                        <label class="col-md-2 control-label">Status</label>
                        <div class="col-md-4">
                            <?php
                            echo form_dropdown("faq_status", array("1" => "Active", "0" => "In-Active"), isset($faq['faq_status']) ? $faq['faq_status'] : '', "class='form-control' ");
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
                                <span class="fa fa-remove"></span>Cancel</button>
                        </div>
                    </div>

                </form>
            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col -->
</div>
<script>
     $(function () {

                            $('#FaqFrom').bootstrapValidator({
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
                                    title: {// field name
                                        validators: {
                                            notEmpty: {
                                                message: 'Title field cannot be empty'
                                            },
                                            stringLength: {
                                                min: 3,
                                                max: 250,
                                                message: 'Title must be 3 to 25 characters long'
                                            }
                                        }
                                    },
                                    
                                }

                            }).on('success.form.bv', function (e) {
                                e.preventDefault();

                            });
                        });
</script>
<script>
    //var notification = angular.module("notification", []);
    viral_pro.controller("faqAddition", function ($scope) {

        $scope.message = "";
        $scope.saveBtn = "Save";
        $scope.action = "<?php echo $Formaction ?>";



        $scope.CreateFaq = function () {
            if(!$("#FaqFrom").data('bootstrapValidator').validate().isValid())
            {
                
              return  false;
            }
            var fom = $("#FaqFrom")[0];
           
            $scope.saveBtn = "<?php echo $Submiting ?>";
           
            console.log(fom);

            var formData = new FormData(fom);
            console.log(formData);

            //var form = new FormData($("#FaqFrom"));
            $.ajax({
                url: $scope.action,
                type: 'POST',
                dataType: 'json',
                data: $("#FaqFrom").serialize(),
                success: function (data, textStatus, jqXHR) {

                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
                               if(typeof data['data'] == 'undefined')
                               {
                                    $("#FaqFrom")[0].reset();
                               }
                       
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
