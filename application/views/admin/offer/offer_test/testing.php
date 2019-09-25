<div class="row OfferTabs " id="TestingTab" ng-controller="TestingTab">

    <div class="col-md-12">
        <!--                        step 5-->
        <div class="panel panel-default">
            <div class="panel-heading"> 
                <h3 class="panel-title">Testing</h3> 
            </div> 
            <div class="panel-body"> 
                <form id="TestingForm">
                    <div class="form-group hidden">
                        <label class="col-md-2 control-label">Publisher</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control " id="post_idUrl" value="" name="post_id">
                        </div>
                    </div>

                    <div class="form-group hidden">
                        <label class="col-md-2 control-label">UID ID</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control " value="5" name="uid">
                        </div>
                    </div>


                    <!--                    <div class="form-group"> 
                                            <div class="col-sm-2">
                                            </div>
                                            <div class="col-sm-10">
                                                <button  type="button" ng-click="approve_offer()" class="btn btn-purple waves-effect waves-light">Generate</button>
                                            </div>
                                        </div>-->

                </form>

                <div class="form-group">
                    <div class="col-md-2">Step 1</div>
                    <div class="col-md-6">
                        <p id="TestLink" style="       word-wrap: break-word;
                           color: #1c1d1d;
                           font-weight: bold;
                           border: 1px solid #eeeeee;
                           padding: 5px;">Offer Tracking Link</p>   
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary  waves-effect waves-light" ng-click="open_link()"><span class="fa fa-link"></span> Open Link</button>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-2">Step 2</div>
                    <div class="col-md-6">
                        <a href="<?php echo @CONV_PIXEL ?>" target="_blank" class="btn btn-success  waves-effect waves-light"><span class="fa fa-link"></span> Test Conversion</a>
                    </div>
                </div>



            </div> 
        </div>



        <!-- step 5 end-->
    </div>
</div>

<script>
    //var Offer = angular.module("Offer", []);
    viral_pro.controller("TestingTab", function ($scope) {
        //code for testing and generateing links
        $scope.FormActionOfferUrl = "<?php echo SITEURL . "admin/offer_link_manager/get_offerUrl" ?>";
        $scope.FormActionOfferApproval = "<?php echo SITEURL . "admin/offer_link_manager/offerApprove" ?>";
        $scope.searchByForm = function () {
            $scope.search();
        };

        $scope.approve_offer = function ()
        {
            var form = $("#TestingForm").serialize();
            $.ajax({
                url: $scope.FormActionOfferApproval,
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
                        $scope.searchByForm();

                    } else {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                    }

                }
            });
        };

        $scope.search = function () {
            $scope.searchBtn = "SEARCHING...";
            var form = $("#TestingForm").serialize();
            $.ajax({
                url: $scope.FormActionOfferUrl,
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $("#TestLink").text(data['link']['gen_link']);
                    } else
                    {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');

                        // $scope.approve_offer();
                    }

                    $scope.$apply();
                    //                    $.each(data, function (index, item) {
                    //                        $scope.getCode(item.post_id, item.campaign_id);
                    //
                    //                    });
                }
            });
        };

        $scope.open_link = function ()
        {
            var Link = $("#TestLink").text();

            window.open(Link, '_blank');
        };

        //end of code
    });
</script>