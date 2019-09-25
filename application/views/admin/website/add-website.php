<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default"  ng-controller="websiteAdd">
            <div class="panel-heading"><h3 class="panel-title">Create new website</h3></div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" id="websiteForm" ng-submit="CreateWebsite()">                                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Name</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" value="" name="domain_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Url</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" value="" name="page_link">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Status</label>
                        <div class="col-md-10">
                            <select name="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">De-Active</option>
                            </select>
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

                            $('#websiteForm').bootstrapValidator({
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
                                    domain_name: {// field name
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
    //var website = angular.module("website", []);
    viral_pro.controller("websiteAdd", function ($scope) {

        $scope.message = "";
        $scope.saveBtn = "Save";


        $scope.action = "<?php echo SITEURL . "admin/website/CreateWebsite" ?>";



        $scope.CreateWebsite = function () {
            
             
             
            if(!$("#websiteForm").data('bootstrapValidator').validate().isValid())
            {
                
              return  false;
            }
            var fom = $("#websiteForm")[0];
            $scope.saveBtn = "Creating";
           $scope.saveBtn = "<?php echo $Submiting ?>";
           
            console.log(fom);

            var formData = new FormData(fom);
            console.log(formData);

            //var form = new FormData($("#websiteForm"));
            $.ajax({
                url: $scope.action,
                type: 'POST',
                dataType: 'json',
                data: $("#websiteForm").serialize(),
                success: function (data, textStatus, jqXHR) {

                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');

                        $("#websiteForm")[0].reset();
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
<?php
if (isset($allWebsite))
    echo $allWebsite;
?>