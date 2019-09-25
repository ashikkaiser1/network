<div class="page-wrapper" ng-controller="offerDetails">

            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                     <h3 class="text-themecolor"><?php echo isset($campaign['campaign_name']) ? $campaign['campaign_name'] : '' ?></h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Offers</a></li>
                        <li class="breadcrumb-item active"><?php echo isset($campaign['campaign_name']) ? $campaign['campaign_name'] : '' ?></li>
                       
                    </ol>
                </div>
            </div>
<div class="container-fluid">
<div class="row">

        <div class="col-sm-6">
            <div class="col-sm-12">
                <div class="card" >
                    <div class="card-header">
                        <h3 class="card-title">  Offer Details </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                           
                                
                                 <div class="form-group col-md-4">
                                        <label class="col-md-12 control-label">ID</label> 
                                  </div>
                                    <div class="form-group col-md-8">
                                         <p   class="col-md-12"><?php echo isset($campaign['campaign_id']) ? $campaign['campaign_id'] : 'NIL' ?> </p> 
                                  
                                  </div>
                                  <div class="form-group col-md-4">
                                        <label class="col-md-12 control-label">Name</label> 
                                  </div>
                                    <div class="form-group col-md-8">
                                        <p class="col-md-12"><?php echo isset($campaign['campaign_name']) ? $campaign['campaign_name'] : 'NIL' ?> </p>
                                  </div>
                                   <div class="form-group col-md-4">
                                        <label class="col-md-12 control-label">Description</label> 
                                  </div>
                                    <div class="form-group col-md-8">
                                        <p class="col-md-12" ng-init="height = '50px'" ng-mouseover="height = 'auto'" ng-mouseleave="height = '50px'"

                                           title="<?php echo @$campaign['meta']; ?>"  style="    overflow: hidden;
                                           height: {{height}};">
                                           <?php
                                           if (isset($campaign['meta']) && $campaign['meta'] != '' && strlen($campaign['meta']) > 100) {
                                               $desc = $campaign['meta'];
                                               echo $desc;
//                                                    substr($desc, 0 ,100) ." .......";
                                           } else {
                                               echo isset($campaign['meta']) ? $campaign['meta'] : 'NIL';
                                           }
                                           ?>


                                        </p>
                                  </div>
                                         
                                <div class="form-group col-md-4">
                                        <label class="col-md-12 control-label">Preview</label> 
                                  </div>
                                    <div class="form-group col-md-8">
                                        <p class="col-md-12"  style="word-wrap: break-word;">
                                                        <a target="_blank"
                                                           title="<?php echo @$campaign['preview_link'] ?>"
                                                           href="<?php echo isset($campaign['preview_link']) ? $campaign['preview_link'] : '#' ?>">
                                                            <span class="fa fa-link"></span> 
                                                        </a>  
                                                    </p>
                                  </div>
                                  
                                  <div class="form-group col-md-4">
                                        <label class="col-md-12 control-label">Status</label> 
                                  </div>
                                    <div class="form-group col-md-8">
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
                                  
                                  <div class="form-group col-md-4">
                                        <label class="col-md-12 control-label">Private</label> 
                                  </div>
                                    <div class="form-group col-md-8">
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
                                  
                                  <div class="form-group col-md-4">
                                      <label class="col-md-12 control-label">Approval Required <span class="fa fa-info-circle text-primary" title="Affiliate required approval to run this offer.."></span> </label>
                                  </div>
                                    <div class="form-group col-md-8">
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
                                  
                                  <div class="form-group col-md-4">
                                        <label class="col-md-12 control-label">Expires</label>                                  </div>
                                    <div class="form-group col-md-8">
                                                                                           <p class="col-md-12"><?php echo isset($campaign['end_date']) && $campaign['end_date'] != '' ? date("M-d-Y", strtotime($campaign['end_date'])) : 'NIL' ?> </p>

                                  </div>
                                  
                                
                                            

                                           




                                        <div class="col-md-4">
                                            <?php if ($campaign['image'] != '0') {
                                                ?>
                                                <img class="offer_imagess" src="<?php echo $campaign['image'] ?>"/>
                                                <?php
                                            } else {
                                                ?>
                                                <img src="http://www.freeiconspng.com/uploads/no-image-icon-6.png" class="offer_imagess"/>
                                                <?php }
                                            ?>

                                        </div>
                                    </div>
                              





                            </div> <!-- col -->
                        </div>
                  </div>
            <?php
            if (isset($payout))
                echo $payout;
            ?>


            <?php
            if (isset($goals))
                echo $goals;
            ?>

           



        </div>

        <div class="col-sm-6">
<div class="col-sm-12">
                <div class="card" >
                    <div class="card-header">
                        <h3 class="card-title">  Tracking Link </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
           
                            <?php
                            if (isset($trackingPanel))
                                echo $trackingPanel;
                            ?>
                            <?php //$this->load->view("affiliate/offer/offer_request_form") ?>
                        </div>
                    </div>
                </div>
            </div>

           
<?php
            if (isset($OfferUrls))
                echo $OfferUrls;
            ?>
            <?php
            if (isset($PixelManager))
                echo $PixelManager;
            ?>

            
             

            <?php
            if (isset($getTargeting))
                echo $getTargeting;
            ?>




        </div>
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
        $scope.FormAction = "<?php echo SITEURL . "affiliate/campaign/get_offerUrl" ?>";
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
                url: "<?php echo SITEURL . "affiliate/campaign/generateLink" ?>",
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
                url: "<?php echo SITEURL . "affiliate/campaign/generatePublisherLink" ?>",
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