

<div class="row"  ng-controller="jobs_controller">
    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading">
                <h3 class="panel-title">
                    All Jobs
                    <div class="pull-right">
                        <ul class="bulkActions">
                            <li>
                                <a href="<?php echo SITEURL ?>admin/job_schedule/CreateJob" class=" btn btn-pink waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-plus"></span> Add Jobs</a>
                            </li>
                            <li>
                                <a title="Action Chnage Status" href="" class=" btn btn-success waves-effect waves-light m-b-5 btn-sm">
                                    <span class="fa fa-anchor"></span> Actions</a>
                                <ul class="subOptions">
                                    <li><a href="#" ng-click="bulkAction(1)">Active</a></li>
                                    <li><a href="#" ng-click="bulkAction(0)">Inactive</a></li>
                                    <li><a href="#" ng-click="bulkAction(2)">Completed</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </h3>
            </div>
            <div class="panel-body">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 m-t-10 m-b-10 searchCustom">
                        <!--                        search-->
                        <form id="searchForm" class="form-inline" role="form" ng-submit="searchByForm()" >

                            <div class="form-group m-l-10">
                                <label class="" for="exampleInputEmail2">Name</label>
                                <input type="text" name="job_name" class="form-control input-sm" id="job_name" ng-model="job_name" ng-model="searchText" placeholder="">

                            </div>

                            <div class="form-group m-l-10">
                                <label class="" for="">Type</label>
                                <?php
                                echo form_dropdown('job_type', $this->config->item('jobType'), NORMALCAMP, "class='form-control'");
                                ?>

                            </div>


                            <div class="form-group m-l-10">
                                <label class="" for="">Status</label>
                                <?php echo form_dropdown("status", array("" => "All", "1" => "Active", "0" => "In-Active", "2" => "Completed"), '', "class='form-control'") ?>
                            </div>

                            <button type="submit" class="btn btn-success waves-effect waves-light m-l-10"><span class="fa fa-search">   </span> </button>

                        </form>

                        <!--end search-->
                    </div>





                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <form id="OfferShowForm">
                            <div class="table-responsive table  table-hover">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" ng-model="selectallJobs"/></th>
                                            <th>S. No.</th>
                                            <th>ID</th>
                                            <th style="    width: 20%;">Name</th>
                                            <th>Type</th>
                                            <th>Time</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="job in all_jobs" id="tr{{job.job_id}}">
                                            <td>
                                                <input class="job_ids" ng-checked="selectallJobs" type="checkbox" name="job_id[]" value="{{job.job_id}}"/>
                                            </td>
                                            <td>{{(currentPage - 1) * 10 + ($index + 1)}} </td>
                                            <td>{{job.job_id}}</td>
                                            <td>{{job.job_name}}</td>
                                            <td>
                                                <span titile='Active' ng-if="job.job_type == 1" class=' text-success'> Campaign</span>
                                                <span titile='Inactivated' ng-if="job.job_type == 2" class=' text-danger'> abcd</span>
                                                <span titile='Paused' ng-if="job.job_type == 3" class=' text-primary'> efgh</span>
                                                <span titile='Pending' ng-if="job.job_type == 4" class=' text-warning'> ijkl</span>
                                                <span titile='Deleted' ng-if="job.job_type == 5" class=' text-danger'> mnop</span>
                                            </td>
                                            <td>{{job.time}}</td>
                                            <td>
                                                <span titile='Active' ng-if="job.status == 1" class=' text-primary'> Active</span>
                                                <span titile='Inactivated' ng-if="job.status == 0" class=' text-danger'> In-Active</span>
                                                <span titile='Paused' ng-if="job.status == 2" class=' text-success'> Completed</span>
                                            </td>
                                            <td>
                                                <a href="<?php echo SITEURL ?>admin/job_schedule/updateJob/{{job.job_id}}" class="btn btn-success waves-effect waves-light m-b-5 btn-xs">
                                                    <span class="fa fa-pencil-square-o"></span> Edit</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>

                        <div class="col-md-3">

                        </div>
                        <div class="col-md-6">
                            <pagination 
                                ng-model="currentPage"
                                total-items="1000"
                                max-size="5"  
                                boundary-links="true">
                            </pagination>
                        </div>
                        <div class="col-md-3">

                        </div>
                    </div>
                </div>
            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col -->
</div>

<script>
    //jobs_controller
    var jobs_controller = viral_pro.controller("jobs_controller", function ($scope) {

        $scope.all_jobs = {};
        $scope.searchBtn = "";
        $scope.FormAction = "<?php echo SITEURL ?>admin/job_schedule/allJobs";

        $scope.currentPage = 1;
        $scope.numPerPage = 10;

        $scope.searchByForm = function () {
            $scope.currentPage = 1;
            $scope.search();
        };

        $scope.$watch('currentPage + numPerPage', function () {
            console.log($scope.currentPage + $scope.numPerPage);
            $scope.search();
        });

        $scope.search = function () {
            $scope.searchBtn = "";
            var form = $("#searchForm").serialize();
            $.ajax({
                url: $scope.FormAction + "?page=" + $scope.currentPage,
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_jobs = data['all_jobs'];
                    $scope.searchBtn = "";
                    $scope.$apply();
                }
            });
        };

        $scope.bulkAction = function (action_type)
        {
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn btn-sm btn-success waves-effect waves-light",
                confirmButtonText: "Yes, Change it!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function (isConfirm) {
                if (isConfirm)
                {
                    var form = $("#OfferShowForm").serialize();
                    $.ajax({
                        url: "<?php echo SITEURL ?>admin/job_schedule/bulkupdate" + "?status=" + action_type,
                        type: 'POST',
                        data: form,
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            if (data['success'])
                            {
                                $.Notification.autoHideNotify('success', 'botton right', data['msg'], '');
                                $scope.search();
                            }
                            else
                            {
                                $.Notification.autoHideNotify('error', 'botton right', data['msg'], '');
                            }
                        }
                    });
                }
            }
            );

        };
    });
</script>
