<div class="row"  ng-controller="offerDetails">

    <div class="col-sm-6">
        <div class="col-sm-12">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Offer Details
                        <div class="pull-right">
                            <ul class="bulkActions">
                                <li><a href="<?php echo SITEURL . "admin/offer/UpdateOfferDetails/" . $campaign_id; ?>" class=" btn btn-info waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span> Edit</a></li>
                                <li><a href="<?php echo SITEURL . "admin/offer/CopyOffer/" . $campaign_id . "/1"; ?>" class=" btn btn-success waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span> Copy</a></li>
                            </ul>
                        </div>

                    </h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">

                            <div class="form-group m-b-10 col-md-12 m-b-10">
                                <label class="col-md-3 control-label">ID</label>
                                <div class="col-md-9">
                                    <p   class="col-md-12"><?php echo isset($campaign['campaign_id']) ? $campaign['campaign_id'] : 'NIL' ?> </p>
                                </div>
                            </div>

                            <div class="form-group m-b-10 col-md-12">
                                <label class="col-md-3 control-label">Name</label>
                                <div class="col-md-9">
                                    <p class="col-md-12"><?php echo isset($campaign['campaign_name']) ? $campaign['campaign_name'] : 'NIL' ?> </p>
                                </div>
                            </div>

                            <div class="form-group m-b-10 col-md-12">
                                <label class="col-md-3 control-label">Description</label>
                                <div class="col-md-9">
                                    <p class="col-md-12"  style="word-wrap: break-word;"><?php echo isset($campaign['meta']) ? $campaign['meta'] : 'NIL' ?> </p>
                                </div>
                            </div>

                            <div class="form-group m-b-10 col-md-12">
                                <label class="col-md-3 control-label">Preview</label>
                                <div class="col-md-9">
                                    <p class="col-md-12"  style="word-wrap: break-word;">
                                        <a target="_blank" href="<?php echo isset($campaign['preview_link']) ? $campaign['preview_link'] : '#' ?>">
                                            <span class="fa fa-link"></span> 
                                        </a>  
                                    </p>
                                </div>
                            </div>

                            <div class="form-group m-b-10 col-md-12">
                                <label class="col-md-3 control-label">Status</label>
                                <div class="col-md-9">
                                    <p class="col-md-12">
                                        <?php
//                                        echo '<pre>;
//                                        print_r($campaign);

                                        if (isset($campaign['c_status']) && $campaign['c_status'] == 1) {
                                            echo "<span class='text-success'>Active</span>";
                                        } else if (isset($campaign['c_status']) && $campaign['c_status'] == 0) {
                                            echo "<span class='text-danger'>Inactive</span>";
                                        } else if (isset($campaign['c_status']) && $campaign['c_status'] == 2) {
                                            echo "<span class='text-danger'>Pause</span>";
                                        } else if (isset($campaign['c_status']) && $campaign['c_status'] == 3) {
                                            echo "<span class='text-danger'>Pending</span>";
                                        } else if (isset($campaign['c_status']) && $campaign['c_status'] == 4) {
                                            echo "<span class='text-danger'>Delete</span>";
                                        }
                                        ?>

                                    </p>
                                </div>
                            </div>

                            <div class="form-group m-b-10 col-md-12">
                                <label class="col-md-3 control-label">Private</label>
                                <div class="col-md-9">
                                    <p class="col-md-12">
                                        <?php
//                                        echo '<pre>;
//                                        print_r($campaign);

                                        if (isset($campaign['private']) && $campaign['private'] == 1) {
                                            echo "<span class='text-success'>Enable</span>";
                                        } else if (isset($campaign['private']) && $campaign['private'] == 0) {
                                            echo "<span class='text-danger'>Disable</span>";
                                        }
                                        ?>

                                    </p> 
                                </div>
                            </div>

                            <div class="form-group m-b-10 col-md-12">
                                <label class="col-md-3 control-label">Approval Required <span class="fa fa-info-circle text-primary" title="Affiliate required approval to run this offer.."></span> </label>
                                <div class="col-md-9">
                                    <p class="col-md-12">
                                        <?php
//                                        echo '<pre>;
//                                        print_r($campaign);

                                        if (isset($campaign['req_approval']) && $campaign['req_approval'] == 1) {
                                            echo "<span class='text-success'>Enable</span>";
                                        } else if (isset($campaign['req_approval']) && $campaign['req_approval'] == 0) {
                                            echo "<span class='text-danger'>Disable</span>";
                                        }
                                        ?>

                                    </p> 
                                </div>
                            </div>



                            <div class="form-group m-b-10 col-md-12">
                                <label class="col-md-3 control-label">Expires</label>
                                <div class="col-md-9">
                                    <p class="col-md-12"><?php echo isset($campaign['end_date']) && $campaign['end_date'] !='' ? date("M-d-Y", strtotime($campaign['end_date'])) : 'NIL' ?> </p>
                                </div>
                            </div>





                        </div> <!-- col -->
                    </div>
                </div>
            </div>
        </div>

        <?php
        if (isset($payout))
            echo $payout;
        ?>




        <?php
        if (isset($creativePanel))
            echo $creativePanel;
        ?>
        <?php
        if (isset($goals))
            echo $goals;

        if (isset($IpWhiteList))
            echo $IpWhiteList;
        ?>


    </div>

    <div class="col-sm-6">

        <?php
        if (isset($offerApprovalPanel))
            echo $offerApprovalPanel;
        ?>

        <?php
        if (isset($trackingPanel))
            echo $trackingPanel;
        ?>

        <?php
        if (isset($getTargeting))
            echo $getTargeting;
        ?>

        <?php
        if (isset($OfferUrls))
            echo $OfferUrls;
        ?>














    </div>






</div>
<script>

    // var genUrlManager = angular.module("gen_url", ['ui.bootstrap']);
    //offerDetails
    var offerDetails = viral_pro.controller("offerDetails", function ($scope) {
        $scope.checkme = false;
        $scope.all_post = {};
        $scope.link_id = 0;
        $scope.title = '';
        $scope.tracking_link = '';
        $scope.post_back = '';
        $scope.extraParam = {"col_name": '', "col_value": ''};
        $scope.searchBtn = "SEARCH";
        $scope.FormAction = "<?php echo SITEURL . "admin/offer_link_manager/get_offerUrl" ?>";
        $scope.searchByForm = function () {

            $scope.search();
        };
        $scope.search = function () {
            $scope.searchBtn = "SEARCHING...";
            var form = $("#searchForm").serialize();
            $.ajax({
                url: $scope.FormAction,
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_post = data;
                    $scope.searchBtn = "SEARCH";
                    $scope.link_id = data['link']['link_id'];
                    $scope.title = data['link']['title'];
                    $scope.tracking_link = data['link']['gen_link'];
                    $scope.post_back = data['link']['post_back'];

                    $scope.extraParam = data['link_extra'];
                    $scope.$apply();
                    //                    $.each(data, function (index, item) {
                    //                        $scope.getCode(item.post_id, item.campaign_id);
                    //
                    //                    });
                }
            });
        };

        $scope.addExtraPram = function ()
        {
            $scope.extraParam.push({"col_name": '', "col_value": ''});
            $scope.$apply();
        };

//          $scope.RemoveExtraPram = function ()
//        {
//            $scope.extraParam.pop();
//            $scope.$apply();
//        };
        $scope.getCode = function (post_id, campaign_id)
        {
            var domain = '';

            $.ajax({
                url: "<?php echo SITEURL . "admin/offer_link_manager/generateLink" ?>",
                type: 'POST',
                data: 'post_id=' + post_id + '&domain_id=' + domain + '&campaign_id=' + campaign_id,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $("#postcodep" + post_id).html(data['gen_link']);
                    }
                }

            });
        };

        $scope.save = function () {
            var form = $("#genMainLink").serialize();

            $.ajax({
                url: "<?php echo SITEURL . "admin/offer_link_manager/generatePublisherLink" ?>",
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.generatedLink = data['genurl'];
                    $scope.$apply();
                }
            });




        };
    });





</script>