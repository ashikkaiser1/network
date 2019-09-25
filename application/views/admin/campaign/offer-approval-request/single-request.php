<div class="row"  ng-controller="OfferRequestApplicationCon">
    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading"><h3 class="panel-title">
                    Offer Request Application</h3></div>
            <div class="panel-body">

                <?php
                if (isset($offer_request)) {
                    ?>
                    <div class="row">



                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3  class="panel-title">Details</h3>
                            </div>
                            <div class="panel-body">
                                <p><strong>Offer:</strong> <a href="<?php echo SITEURL."admin/campaign/offerRequest/{$offer_request['campaign_id']}" ?>"><?php echo $offer_request['campaign_name'] ?></a>       	</p>
                                <p><strong>Affiliate:</strong> <a href="<?php echo SITEURL."/admin/users/ShowUsers"; ?>"><?php echo $offer_request['name'] ?> </a></p>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3  class="panel-title">Questions</h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-responsive">
                                    <thead>
                                        <tr>
                                            <th class="al">Question</th>
                                            <th class="al">Answer</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="stat even">
                                            <td class="question_text stat">Where will you promote this offer?</td>
                                            <td class="question_answer stat"><?php echo $offer_request['offerpro'] ?></td>
                                        </tr>
    <!--                                    <tr class="stat odd">
                                            <td class="question_text stat">What traffic sources are you going to run this campaign?</td>
                                            <td class="question_answer stat">in app</td>
                                        </tr>-->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary btn-sm waves-effect waves-light" type="button" ng-click="approve('<?php echo $offer_request['request_id'] ?>', '<?php echo $offer_request['uid'] ?>', '<?php echo $offer_request['campaign_id'] ?>')"><span class="fa fa-check"></span> Approve</button>
                            <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" ng-click="reject('<?php echo $offer_request['request_id'] ?>', '<?php echo $offer_request['uid'] ?>', '<?php echo $offer_request['campaign_id'] ?>')"><span class="fa fa-remove"></span> Reject</button>
                        </div>





                    </div>

                <?php } ?>
            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col -->
</div>

<script>
    //var campaignManager = angular.module("campaign_app", ['ui.bootstrap']);
    //OfferRequestApplicationCon
    var OfferRequestApplicationCon = viral_pro.controller("OfferRequestApplicationCon", function ($scope) {

        $scope.all_offerRequest = {};
        $scope.searchBtn = "";
        $scope.FormAction = "<?php echo SITEURL . "admin/campaign/show_request" ?>";

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
                    $scope.all_offerRequest = data;
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
                    $scope.all_offerRequest = data;
                    $scope.$apply();
                }
            });
        };



        //delete campaing


        $scope.approve = function (request_id, uid, campaign_id)
        {
            swal({
                title: "Are you sure?",
                text: "Offer will be approved for Affiliate!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn btn-sm btn-danger waves-effect waves-light",
                confirmButtonText: "Yes, Approve it!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function (isConfirm) {
                if (isConfirm)
                {
                    $.ajax({
                        url: "<?php echo SITEURL . "admin/campaign/approve_offer_request" ?>",
                        type: 'POST',
                        data: "request_id=" + request_id + "&uid=" + uid + "&campaign_id=" + campaign_id,
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            if (data['success'])
                            {
                                $.Notification.autoHideNotify('success',
                                        'botton right',
                                        data['msg'],
                                        '');
                                $("#tr" + request_id).remove();
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

        $scope.reject = function (request_id, uid, campaign_id)
        {
            swal({
                title: "Are you sure?",
                text: "Offer will be rejected for Affiliate!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn btn-sm btn-danger waves-effect waves-light",
                confirmButtonText: "Yes, Reject it!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function (isConfirm) {
                if (isConfirm)
                {
                    $.ajax({
                        url: "<?php echo SITEURL . "admin/campaign/reject_offer_request" ?>",
                        type: 'POST',
                        data: "request_id=" + request_id + "&uid=" + uid + "&campaign_id=" + campaign_id,
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            if (data['success'])
                            {
                                $.Notification.autoHideNotify('success',
                                        'botton right',
                                        data['msg'],
                                        '');
                                $("#tr" + request_id).remove();
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



//        $scope.getCampaign();
    });</script>


<script>



</script>