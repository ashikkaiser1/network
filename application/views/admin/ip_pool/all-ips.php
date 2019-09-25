<div class="row" id="ip_controller" ng-controller="ip_controller">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class=" panel-title">
                    All IPs 
                </h3>
            </div>  
            <div class="panel-body">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 m-t-10 m-b-10 searchCustom">
                        <!--                        search-->
                        <form id="searchIP" class="form-inline" role="form" ng-submit="searchByForm()" >

                            <div class="form-group m-l-10">
                                <label class="" for="exampleInputEmail2">IP Address</label>
                                <input type="text" name="ip_address" class="form-control input-sm" id=""  placeholder="">
                            </div>
                            <div class="form-group m-l-10">
                                <label class="" for="">Status</label>
                                <?php echo form_dropdown("status", array("1" => "Active", "0" => "IN-Active"), '', "class='form-control'") ?>
                            </div>
                            <button type="submit" class="btn btn-success waves-effect waves-light m-l-10"><span class="fa fa-search"></span></button>
                        </form>
                        <!--end search-->
                    </div>


                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>IP Address</th>
                                        <th>Domain</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    ?>
                                    <tr ng-repeat="ip in all_ips" id="tr{{ip.ip_id}}"  >
                                        <td>{{ $index + 1}}</td>
                                        <td>
                                            {{ip.ip_address}}
                                        </td>
                                         <td>
                                            {{ip.name}}
                                        </td>
                                        <td>
                                            <span ng-if="ip.status == 1" class="text-success" >Active</span>
                                            <span ng-if="ip.status == 0" class="text-success" >In-Active</span>
                                        </td>
                                        <td>
                                            <a href="<?php echo SITEURL . "admin/ip_pool/UpdateIp/" ?>{{ip.ip_id}}" type="button" class="btn btn-primary waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span></a>
                                            <button type="button" ng-click="delete_ip(ip.ip_id)" class="btn btn-danger waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-trash"></span></button>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                         <div class="text-danger text-center" ng-if="all_ips == ''">
                            <h3 class='text-danger'>There is no data available ....</h3>
                        </div>

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
            </div>
        </div>
    </div>
</div>

<script>
    //var ipManager = angular.module("ip_app", ['ui.bootstrap']);
    //ip_controller
    var ip_controller = viral_pro.controller("ip_controller", function ($scope) {

        $scope.all_ips = {};
        $scope.searchBtn = "";
        $scope.FormAction = "<?php echo SITEURL . "admin/ip_pool/show_ips" ?>";


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

        $scope.delete_ip = function (ip_id)
        {
            swal({
                title: "Are you sure?",
                text: "Your will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn btn-sm btn-danger waves-effect waves-light",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function (isConfirm) {
                if (isConfirm)
                {
                    $.ajax({
                        url: "<?php echo SITEURL . "admin/ip_pool/deleteIp" ?>",
                        type: 'POST',
                        data: "ip_id=" + ip_id,
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            if (data['success'])
                            {
                                $.Notification.autoHideNotify('success',
                                        'botton right',
                                        data['msg'],
                                        '');
                                $("#tr" + ip_id).remove();
                                //$("#catForm")[0].reset();
                            } else {
                                $.Notification.autoHideNotify('error',
                                        'botton right',
                                        data['msg'],
                                        '');
                            }

                        }

                    });
                }


            });

        };

        $scope.search = function () {
            $scope.searchBtn = "";
            var form = $("#searchIP").serialize();
            $.ajax({
                url: $scope.FormAction + "?page=" + $scope.currentPage,
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_ips = data['ip_pool'];
                    if (data['success'])
                    {
//                        $scope.all_ips = data['ip_pool'];
                        $scope.searchBtn = "";
                    }

                    $scope.$apply();
                }
            });
        };


    });
</script>