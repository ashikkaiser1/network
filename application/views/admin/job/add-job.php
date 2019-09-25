<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default"  ng-controller="jobAdd">
            <div class="panel-heading"><h3 class="panel-title">
                    <?php echo $title ?>
                    <div  class="pull-right">
                        <a href="<?php echo SITEURL . "admin/job_schedule/allJobs" ?>" class=" btn btn-purple waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-list"></span> All Jobs</a>
                    </div>
                </h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" id="jobForm" ng-submit="CreateUpdateJob()">                                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Name</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" value="<?php echo isset($jobs['job_name']) ? $jobs['job_name'] : '' ?>" name="job_name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Type</label>
                        <div class="col-md-4">
                            <?php
                            echo form_dropdown("job_Type", $this->config->item('jobType'), isset($jobs['job_Type']) ? $jobs['job_Type'] : '', "class='form-control' ng-model='job_type' ng-change='getview()'");
                            ?>
                        </div>
                    </div>
                    <div  id="customview">
                        <?php
                        if (isset($view)) {
                            echo $view;
                        }
                        ?>
                    </div>


                    <div class="form-group">
                        <label class="col-md-2 control-label">Time</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control datepicker" value="<?php echo isset($jobs['time']) ? $jobs['time'] :  date('d-m-Y', time())  ?>" name="time">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Status</label>
                        <div class="col-md-4">
                            <?php
                            echo form_dropdown("status", array("1" => "Active", "0" => "De-Active"), isset($jobs['status']) ? $jobs['status'] : '', "class='form-control' ");
                            ?>
                        </div>
                    </div>

                    <div class="form-group"> 
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-10">
                            <button type="Submit" class="btn btn-purple waves-effect waves-light">{{saveBtn}}</button>
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

        $('#jobForm').bootstrapValidator({
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
                //domain_name: {// field name
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

<!--<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker();
    });
</script>       -->

<script>
    //var notification = angular.module("notification", []);
    viral_pro.controller("jobAdd", function ($scope) {

        $scope.message = "";
        $scope.saveBtn = "Save";
        $scope.action = "<?php echo $FormAction ?>";

        $scope.CreateUpdateJob = function () {
            if (!$("#jobForm").data('bootstrapValidator').validate().isValid())
            {
                return  false;
            }
            var fom = $("#jobForm")[0];
            $scope.saveBtn = "<?php echo $Submiting ?>";
            // console.log(fom);
            var formData = new FormData(fom);
            // console.log(formData);

            //var form = new FormData($("#jobForm"));
            $.ajax({
                url: $scope.action,
                type: 'POST',
                dataType: 'json',
                data: $("#jobForm").serialize(),
                success: function (data, textStatus, jqXHR) {

                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
//                        if (typeof data['data'] == 'undefined')
//                        {
                        $("#jobForm")[0].reset();
//                            document.getElementById("jobForm").reset();
//                        }

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

        $scope.getview = function () {

            var job_type = $scope.job_type;

            $.ajax({
                url: '<?php echo SITEURL ?>admin/job_schedule/getview/',
                type: 'POST',
                dataType: 'json',
                data: 'job_type=' + job_type,
                success: function (data, textStatus, jqXHR) {

                    if (data['success'])
                    {
                        $("#customview").html(data['view']);

                    } else {

                    }

                }
            });
        };







    });
</script>
