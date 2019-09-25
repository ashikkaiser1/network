<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default"  ng-controller="domainAdd">
            <div class="panel-heading"><h3 class="panel-title">Create new Tracking domain</h3></div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" id="domainForm" ng-submit="CreateDomain()">                                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Name</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" value="" name="domain_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Url</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" value="" name="domain_url">
                            <span class="help-block"><small>Set the url of tracking domain.</small></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Status</label>
                        <div class="col-md-4">
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

                            $('#domainForm').bootstrapValidator({
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
                                    domain_url : {// field name
                                        validators: {
                                            notEmpty: {
                                                message: 'Url cannot be empty'
                                            },
                                            uri : {
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
    //var domain = angular.module("domain", []);
    viral_pro.controller("domainAdd", function ($scope) {

        $scope.message = "";
        $scope.saveBtn = "Save";


        $scope.action = "<?php echo SITEURL . "admin/domain/CreateDomain" ?>";



        $scope.CreateDomain = function () {
            
             
            if(!$("#domainForm").data('bootstrapValidator').validate().isValid())
            {
                
              return  false;
            }
            $scope.saveBtn = "Creating";
            var fom = $("#domainForm")[0];
           $scope.saveBtn = "<?php echo $Submiting ?>";
           
            console.log(fom);

            var formData = new FormData(fom);
            console.log(formData);

            //var form = new FormData($("#domainForm"));
            $.ajax({
                url: $scope.action,
                type: 'POST',
                dataType: 'json',
                data: $("#domainForm").serialize(),
                success: function (data, textStatus, jqXHR) {

                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');

                        $("#domainForm")[0].reset();
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
if (isset($allDomain))
    echo $allDomain;
?>