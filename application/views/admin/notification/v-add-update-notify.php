<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default"  ng-controller="notificationAdd">
            <div class="panel-heading"><h3 class="panel-title">
                 <a href="<?php echo SITEURL . "admin/notification/allNotification" ?>" class=" btn btn-purple waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-list"></span> All Notification</a>
                <?php echo $title ?></h3></div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" id="notificationForm" ng-submit="CreateNotification()">                                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Title</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" value="<?php echo isset($notification['title']) ? $notification['title'] : '' ?>" name="title">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Description</label>
                        <div class="col-md-8">
                            <textarea class="form-control" name="description" rows="5"><?php echo isset($notification['description']) ? $notification['description'] : '' ?></textarea>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Link</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" value="<?php echo isset($notification['link']) ? $notification['link'] : '' ?>" name="link">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Status</label>
                        <div class="col-md-4">
                            <?php
                            echo form_dropdown("status", array("1" => "Active", "0" => "In-Active"), isset($notification['status']) ? $notification['status'] : '', "class='form-control' ");
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

                            $('#notificationForm').bootstrapValidator({
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
                                    page_link : {// field name
                                        validators: {
                                            notEmpty: {
                                                message: 'Url cannot be empty'
                                            },
                                            uri: {
                                                message: 'Invalid Url'
                                            }, stringLength: {
                                                min: 3,
                                                max: 30,
                                                message: ''
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
    //var notification = angular.module("notification", []);
    viral_pro.controller("notificationAdd", function ($scope) {

        $scope.message = "";
        $scope.saveBtn = "Save";
        $scope.action = "<?php echo $Formaction ?>";



        $scope.CreateNotification = function () {
            if(!$("#notificationForm").data('bootstrapValidator').validate().isValid())
            {
                
              return  false;
            }
            var fom = $("#notificationForm")[0];
           
            $scope.saveBtn = "<?php echo $Submiting ?>";
           
            console.log(fom);

            var formData = new FormData(fom);
            console.log(formData);

            //var form = new FormData($("#notificationForm"));
            $.ajax({
                url: $scope.action,
                type: 'POST',
                dataType: 'json',
                data: $("#notificationForm").serialize(),
                success: function (data, textStatus, jqXHR) {

                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
                               if(typeof data['data'] == 'undefined')
                               {
                                    $("#notificationForm")[0].reset();
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
