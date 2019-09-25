<div class="col-lg-12" ng-controller="affiliate_apply_for_offer">
                <form class="form-horizontal" id="OfferRequestForm" role="form" ng-submit="CreateRequest()">                                    
                    <div class="form-group">
                        <label class="col-md-12 control-label" style="text-align:  left">Where will you promote this offer?</label>
                        <div class="col-md-12">
                            <input type="hidden" name="campaign_id" value="<?php echo isset($campaign['campaign_id']) ? $campaign['campaign_id'] : '' ?> "/>
                            <input  type="text" class="form-control" value="" name="offerpro">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12 control-label"  style="text-align:  left"> 
                            <input name="terms_cond" value="1" type="checkbox"> Do you agree Terms and Condition?
                        </label>
                       
                    </div>


                    <div class="form-group"> 
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-10">

                            <button type="submit" class="btn btn-purple waves-effect waves-light">{{saveBtn}}</button>
                            <button type="Reset" class="btn btn-danger waves-effect waves-light">Cancel</button>
                        </div>
                    </div>

                </form>
            </div> <!-- panel-body -->

<script>
    //var Category = angular.module("Category", []);
    viral_pro.controller("affiliate_apply_for_offer", function ($scope) {

        $scope.message = "";
        $scope.saveBtn = "Apply";


        $scope.action = "<?php echo SITEURL . "advertiser/campaign/affiliate_apply_for_offer" ?>";



        $scope.CreateRequest = function () {
//
//
//            if (!$("#OfferRequestForm").data('bootstrapValidator').validate().isValid())
//            {
//
//                return  false;
//            }

            $scope.saveBtn = "Applying";
            var fom = $("#OfferRequestForm")[0];
           

            console.log(fom);

            var formData = new FormData(fom);
            console.log(formData);

            //var form = new FormData($("#OfferRequestForm"));
            $.ajax({
                url: $scope.action,
                type: 'POST',
                dataType: 'json',
                data: $("#OfferRequestForm").serialize(),
                success: function (data, textStatus, jqXHR) {

                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');

                        $("#OfferRequestForm")[0].reset();
                    } else {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                    }
                    $scope.saveBtn = "Apply";
                    $scope.$apply();
                }

            });



        };

    });
</script>
<?php
if (isset($allCategory))
    echo $allCategory;
?>