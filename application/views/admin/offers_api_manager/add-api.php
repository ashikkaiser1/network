<div class="row"  ng-controller="offerAPIADDController">
    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading"><h3 class="panel-title"><?php echo $title ?>
                    <a href="<?php echo SITEURL."admin/offers_api_manager" ?>" class=" pull-right btn btn-primary btn-sm"><span class="fa fa-list-ul"></span> All APIs</a>
                </h3></div>
            <div class="panel-body">

                <form class="form-horizontal" id="APIForm" role="form" ng-submit="CreateAPI()">                                    

                    <input type="text" class="form-control hidden" ng-model="api.ons_id"name="ons_id">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Network</label>
                        <div class="col-md-4">
                            <select name="network_id" class="form-control" ng-model="api.network_id">
                                <option ng-repeat="net in networks" value="{{net.network_id}}">
                                    {{net.name}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Affiliate Id</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" ng-model="api.affId" name="affId" placeholder="Affiliate Id of that Netwrok which you selected..">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Affiliate Name</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" ng-model="api.advertiserName"name="advertiserName" placeholder="Assign a advertiser name for that publisher/affiliate">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Affiliate Company</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" ng-model="api.companyName" name="companyName" placeholder="Assign a company to affiliate/publisher">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">API Key</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" ng-model="api.apiKey"name="apiKey" placeholder="API of that network which you selected.">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">API Url</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" ng-model="api.apiUrl" name="apiUrl" placeholder="API Url of network.">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Tracking Link Extension</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" ng-model="api.trackingLinkExten"name="trackingLinkExten" placeholder="Tracking link extension">
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-md-2 control-label">Commisson Cut</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" ng-model="api.commission_cut" name="commission_cut" placeholder="commisson in percentage put a number at what percentage you want to cut down.">
                        </div>
                    </div>




                    <div class="form-group hidden" >

                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Status</label>
                        <div class="col-md-4">
                            <select name="api_status" ng-model="api.api_status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">IN-Active</option>
                            </select>
                        </div>
                    </div>



                    <div class="form-group"> 
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-purple waves-effect waves-light">
                                <span class="fa fa-save"></span>
                                {{saveBtn}}</button>
                            <button type="Reset" class="btn btn-danger waves-effect waves-light" ng-click="reset_form()">
                                <span class="fa fa-remove"></span>
                                Cancel</button>
                        </div>
                    </div>

                </form>


            </div> <!-- panel-body -->
        </div> <!-- panel -->

        <div class="panel panel-default" >
            <div class="panel-heading"><h3 class="panel-title">
                    All APIS

                </h3></div>
            <div class="panel-body">
                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>S.NO.</th>
                            <th>Network</th>
                            <th>Advertiser</th>
                            <th>Company</th>
                            <th>API Key</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr ng-repeat="allNet in allNetworkSetting">
                            <td>{{$index + 1}}</td>
                            <td>
                                <img width="100" src="<?php echo ASSETS . "images/" ?>{{allNet.logo}}"/>

                            </td>
                            <td>
                                {{allNet.advertiserName}}
                            </td>
                            <td>
                                {{allNet.companyName}}
                            </td>
                            <td>
                                {{allNet.apiKey}}
                            </td>
                            <td>
                                <button 
                                    class="btn btn-success btn-sm waves-effect waves-light m-b-5" ng-click="geteditAPI(allNet, $index)">
                                    <span class="fa fa-edit"></span> 
                                </button>

                                <button 
                                    class="btn btn-danger btn-sm waves-effect waves-light m-b-5" ng-click="delete_api(allNet)">
                                    <span class="fa fa-remove"></span> 
                                </button>


                            </td>
                        </tr>
                    </tbody>
                </table>


            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div>

</div> <!-- col -->
</div>

<script>
    //var Category = angular.module("Category", []);
    viral_pro.controller("offerAPIADDController", function ($scope) {

        $scope.message = "";
        $scope.saveBtn = "Save";
        $scope.all_goals = {};
        $scope.campaign_id = {value: "0", text: "None"};
        $scope.allNetworkSetting = {};
        $scope.networks = <?php echo json_encode($networks) ?>;

        $scope.geteditAPI = function (allNet, index) {

            $scope.api = allNet;
            $scope.saveBtn = "Update";

        };
        $scope.reset_form = function () {
            $scope.api = {};
            $scope.saveBtn = "Save";

        };

        $scope.delete_api = function (allNet) {

            swal({
                title: "Are you sure?",
                text: "Your will not be able to recover this API!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn btn-sm btn-danger waves-effect waves-light",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function (isconfirm) {
                if (isconfirm)
                {
                    $.ajax({
                        url: "<?php echo SITEURL . "admin/offers_api_manager/delete_api" ?>",
                        type: 'POST',
                        data: "ons_id=" + allNet.ons_id,
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            if (data['success'])
                            {
                                $.Notification.autoHideNotify('success',
                                        'botton right',
                                        data['msg'],
                                        '');

                                //$("#catForm")[0].reset();
                            } else {
                                $.Notification.autoHideNotify('error',
                                        'botton right',
                                        data['msg'],
                                        '');
                            }
                            $scope.getNetworkSeting();
                            

                        }

                    });
                }
            });


        };
        $scope.CreateAPI = function () {

            var form = $("#APIForm").serialize();
            $.ajax({
                url: "<?php echo SITEURL . "admin/offers_api_manager/other_network_settings" ?>",
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success']) {


                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
                    } else
                    {


                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                    }
                    $scope.reset_form();
                    $scope.$apply();
                    $scope.getNetworkSeting();
                }
            });

        };

        $scope.getNetworkSeting = function () {

            $.ajax({
                url: "<?php echo SITEURL . "admin/offers_api_manager/getNetworkSeting" ?>",
                type: 'POST',
                data: 'data=1',
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success']) {
                        $scope.allNetworkSetting = data['allNetworkSetting'];
                    }

                    $scope.$apply();
                }
            });

        };

        $scope.getNetworkSeting();

    });
</script>
