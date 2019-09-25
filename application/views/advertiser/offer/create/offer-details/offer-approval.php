<div class="col-sm-12" id="OfferApproval" ng-controller="OfferApproval">
    <div class="panel panel-default" >
        <div class="panel-heading">
            <h3 class="panel-title">
                Offer Approval   </h3></div>
        <div class="panel-body">
            <div class="row">

                <div class="col-lg-12" >
                    <form method="post" id="unApprovedPubForm" action="<?php echo SITEURL . "admin/offer_permission/setApprovePublisher" ?>" >
                        <div class="col-lg-12">
                            <input type="hidden" name="campaign_id" value="<?php echo $campaign_id ?>"/>
                            <div class="form-group m-l-4">
                                <label class="" for="">Un-Approved Publisher</label>
                                <select class="form-control" id="unapprovePub" multiple="" name="uid[]" ng-model='unapprovePub'>

                                </select>

                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group m-l-4">
                                <button type="button" ng-click="submit_form('unApprovedPubForm', '1')" class=" btn btn-success waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-check"></span> Approve</button>
<!--                                <button type="button" ng-click="submit_form('unApprovedPubForm', '2')" class=" btn btn-danger waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-remove"></span> Reject</button>-->
                            </div>
                        </div>
                    </form>


                </div> 
                
                    <div class="col-lg-12" >
                    <form method="post" id="ApprovedPubForm" action="<?php echo SITEURL . "admin/offer_permission/setApprovePublisher" ?>" >
                        <div class="col-lg-12">
                            <input type="hidden" name="campaign_id" value="<?php echo $campaign_id ?>"/>
                            <div class="form-group m-l-4">
                                <label class="" for="">Approved Publisher</label>
                                <select class="form-control" id="ApprovedPub" name="uid[]" multiple="" ng-model='ApprovedPub'>

                                </select>
                            </div>

                        </div>

                        <div class="col-lg-12">
                            <div class="form-group m-l-4">
                                <button type="button" ng-click="submit_form('ApprovedPubForm','2')" class=" btn btn-warning waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-check"></span> Un-approve</button>
                                <button type="button" ng-click="submit_form('ApprovedPubForm','0')" class=" btn btn-danger waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-remove"></span> Block</button>
                            </div>
                        </div>
                    </form>       


                </div> 



                <div class="col-lg-12" >
                    <form method="post" id="BlockedPubForm"  action="<?php echo SITEURL . "admin/offer_permission/setApprovePublisher" ?>"  >
                        <div class="col-lg-12">
                            <input type="hidden" name="campaign_id" value="<?php echo $campaign_id ?>"/>
                            <div class="form-group m-l-4">
                                <label class="" for="">Blocked Publisher</label>
                                <select class="form-control" id="BlockedPub" name="uid[]" multiple="" ng-model='BlockedPub'>

                                </select>
                            </div>

                        </div>

                        <div class="col-lg-12">
                            <div class="form-group m-l-4">
                                <button type="button" ng-click="submit_form('BlockedPubForm','2')" class=" btn btn-warning waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-check"></span> Un-approve</button>
<!--                                <button type="button" ng-click="submit_form('reject')" class=" btn btn-danger waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-remove"></span> Block</button>-->
                            </div>
                        </div>
                    </form>       


                </div> 




            </div>
        </div>
    </div>
</div>




<script>

    viral_pro.controller("OfferApproval", function($scope) {



        $scope.approve_offer = function(post_id, campaign_id, uid)
        {

            $.ajax({
                url: "<?php echo SITEURL . "admin/offer_link_manager/offerApprove" ?>",
                type: 'POST',
                data: 'post_id=' + post_id + "&uid=" + uid,
                dataType: 'json',
                success: function(data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $scope.getCode(post_id, campaign_id);
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');

                    } else {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                    }

                }
            });
        };


        $scope.submit_form = function(form, status)
        {
            var url = $("#" + form).attr("action");
            $.ajax({
                url: url,
                type: 'POST',
                data: $("#" + form).serialize() + "&status=" + status,
                dataType: 'json',
                success: function(data, textStatus, jqXHR) {
                    if (data['success'])
                    {

                        $scope.getpublishers('<?php echo $campaign_id ?>', '', 'unapprovePub', 'getUnApprovedPublisher');
                        $scope.getpublishers('<?php echo $campaign_id ?>', 0, 'BlockedPub', 'getOfferPublisher');
                        $scope.getpublishers('<?php echo $campaign_id ?>', 1, 'uid', 'getOfferPublisher');
                        
                          $scope.getpublishers('<?php echo $campaign_id ?>', 1, 'ApprovedPub', 'getOfferPublisher');

                        
                        // $scope.getCode(post_id, campaign_id);
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');

                    } else {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                    }

                }
            });
        };


        $scope.getpublishers = function(campaign_id, status, id, page)
        {
            $.ajax({
                url: "<?php echo SITEURL . "admin/offer_permission/" ?>" + page,
                type: 'GET',
                data: 'campaign_id=' + campaign_id + "&status=" + status,
                dataType: 'json',
                success: function(data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $("#" + id).html("");
                        var selector = $("#" + id);
                        $.each(data['publisher'], function(index, item) {
                            var options = "<option value='" + index + "'>" + item + "</option>";
                            console.log(options);
                            selector.append(options);
                        });
                        //  unapprovePub
                        //
//                        $.Notification.autoHideNotify('success',
//                                'botton right',
//                                data['msg'],
//                                '');

                    } else {
//                        $.Notification.autoHideNotify('error',
//                                'botton right',
//                                data['msg'],
//                                '');
                    }

                }
            });


        };

        $scope.getpublishers('<?php echo $campaign_id ?>', '', 'unapprovePub', 'getUnApprovedPublisher');
        $scope.getpublishers('<?php echo $campaign_id ?>', 0, 'BlockedPub', 'getOfferPublisher');
        $scope.getpublishers('<?php echo $campaign_id ?>', 1, 'ApprovedPub', 'getOfferPublisher');





    });
//    angular.element(document).ready(function() {
//      angular.bootstrap(document, ['campaign']);
//    });

</script>