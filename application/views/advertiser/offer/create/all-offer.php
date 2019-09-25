<div class="row"  ng-controller="campaign_controller">
    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading"><h3 class="panel-title">
                    <a href="<?php echo SITEURL . "admin/campaign/CreateCampaign" ?>" class=" btn btn-purple waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-plus"></span> Campaign</a>
                    All Campaign</h3></div>
            <div class="panel-body">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 m-t-10 m-b-10 searchCustom">
                        <!--                        search-->
                        <form id="searchForm" class="form-inline" role="form" ng-submit="search()" >

                            <div class="form-group m-l-10">
                                <label class="" for="exampleInputEmail2">Name</label>
                                <input type="text" name="campaign_name" class="form-control input-sm" id="" ng-model="campaign_name" ng-model="searchText" placeholder="">

                            </div>

                            <div class="form-group m-l-10">
                                <label class="" for="">Advertiser</label>
                                <?php
                                echo form_dropdown('uid', $advertiser, "", "class='form-control'");
                                ?>

                            </div>



                            <div class="form-group m-l-10">
                                <label class="" for="">Status</label>
                                <?php echo form_dropdown("status", array("" => "All", "1" => "Active", "0" => "De-Activated"), '', "class='form-control'") ?>
                            </div>


                            <button type="submit" class="btn btn-success waves-effect waves-light m-l-10"><span class="fa fa-search">   </span> </button>

                        </form>
                        <!--end search-->
                    </div>





                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive table  table-hover">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Advertiser</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Cap</th>
                                        <th>AC-PPC (<?php echo CURR ?>) </th>
<!--                                        <th>AC-PPI</th>-->
                                        <th>AFF-PPC (<?php echo CURR ?>) </th>
<!--                                        <th>AFF-PPI</th>-->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr ng-repeat="camp in all_campaign| filter :campaign_name " id="tr{{camp.campaign_id}}">
                                        <td>{{camp.campaign_id}}</td>
                                        <td>
                                            <span titile='Active' ng-if="camp.c_status == 1" class='fa fa-circle text-success'></span>
                                            <span titile='De-Activated' ng-if="camp.c_status == 0" class='fa fa-circle text-danger'></span>

                                            {{camp.campaign_name}}


                                        </td>
                                        <td> {{camp.name}}</td>
                                        <td> {{camp.start_date}}</td>
                                        <td> {{camp.end_date}}</td>
                                        <td> {{camp.cap}}</td>
                                        <td> {{camp.act_ppc}}</td>
<!--                                                <td> {{camp.act_ppi}}</td>-->
                                        <td> {{camp.payout_cost}}</td>
<!--                                                <td> {{camp.per_impression_revenue}}</td>-->
                                        <td>
                                            <a type="button" href="<?php echo SITEURL . "admin/campaign/UpdateCampaign/" ?>{{camp.campaign_id}}" class="btn btn-primary waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span></a>
                                            <a title="Add new post to campaign." type="button" href="<?php echo SITEURL . "admin/campaign/post_to_campaign/" ?>{{camp.campaign_id}}" class="btn btn-success waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-plus"></span></a>
                                            <button type="button" ng-click="delete_campaign(camp.campaign_id)" class="btn btn-danger waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-trash"></span></button>
                                        </td>

                                    </tr>

                                </tbody>
                            </table>
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
            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col -->
</div>

<script>
    //var campaignManager = angular.module("campaign_app", ['ui.bootstrap']);
    //campaign_controller
    var campaign_controller = viral_pro.controller("campaign_controller", function ($scope) {

        $scope.all_campaign = {};
        $scope.searchBtn = "";
        $scope.FormAction = "<?php echo SITEURL . "admin/campaign/show_campaign" ?>";

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
                    $scope.all_campaign = data;
                    $scope.searchBtn = "";
                    $scope.$apply();
                }
            });
        };
        $scope.getCampaign = function () {

            $.ajax({
                url: $scope.FormAction,
                type: 'POST',
                data: 'user=1',
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_campaign = data;
                    $scope.$apply();
                }
            });
        };
        //delete campaing
        $scope.delete_campaign = function (campaign_id)
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
                        url: "<?php echo SITEURL . "admin/campaign/deleteCampaign" ?>",
                        type: 'POST',
                        data: "campaign_id=" + campaign_id,
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            if (data['success'])
                            {
                                $.Notification.autoHideNotify('success',
                                        'botton right',
                                        data['msg'],
                                        '');
                                $("#tr" + campaign_id).remove();
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
        $scope.getCampaign();
    });</script>


<script>



</script>