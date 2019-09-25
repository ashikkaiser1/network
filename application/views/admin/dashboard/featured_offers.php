<style>
    ul.featuredOffers
    {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    ul.featuredOffers li
    {
        background: white;
        margin: 9px auto;
        padding: 5px; 
        border-bottom: 1px solid whitesmoke;
    }

    div.offerFeature
    {
        /*background: white;*/
    }

</style>


<div class="col-lg-4 offerFeature">
    <div class="panel panel-border panel-success" ng-controller="featuredOffers" >
        <div class="panel-heading"> 
            <h3 class="panel-title">Featured Offers</h3> 
        </div> 
        <div class="panel-body"> 
            
            <div  ng-if="featuredOffers == ''" style="text-align: center;font-size: larger" class="text-danger text-center">
                            Sorry, there is no data currently
           </div>
            
            <div class="form-group">
                <ul class="featuredOffers">
                    <li ng-repeat="offers in featuredOffers" id="li{{offers.campaign_id}}">
                        <span>{{offers.campaign_name}}({{offers.campaign_id}})</span> 

                        <button ng-click="removeFromFeatured(offers.campaign_id)" class=" btn btn-xs btn-danger pull-right"><span class="fa fa-remove  " title="Remove From Featured offer list"></span></button>
                    </li> 
                </ul>  
            </div>

            <form class="col-md-12" id="IamFeatured" ng-submit="addToFeatured()">
                <div class="form-group">
                    <?php echo form_dropdown('campaign_id', $offers, '', "class='form-control campaign_id_select2'") ?>
                </div>
                <div class="form-group">
                    <button title="Click to save the offer as featured offer"  type="submit" class="btn btn-success btn-sm ">
                        <span class="fa fa-save"></span>
                        {{saveBtn}}</button>
                </div>

            </form>
        </div> 
    </div>
</div>


<!--
<div class="col-md-4 offerFeature" ng-controller="featuredOffers">
    <h4>Featured Offers</h4>
   

</div>-->

<script>

    
    //var Category = angular.module("Category", []);
    viral_pro.controller("featuredOffers", function ($scope) {

        $scope.message = "";
        $scope.saveBtn = "Save";
        $scope.featuredOffers = {};

        $scope.action = "<?php echo SITEURL . "admin/offer/setFeatureOffer" ?>";



        $scope.addToFeatured = function () {
            $scope.saveBtn = "Creating";
            var fom = $("#IamFeatured")[0];
            $scope.saveBtn = "Saveing..";
            var formData = new FormData(fom);

            //var form = new FormData($("#IamFeatured"));
            $.ajax({
                url: $scope.action,
                type: 'POST',
                dataType: 'json',
                data: $("#IamFeatured").serialize(),
                success: function (data, textStatus, jqXHR) {

                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
                        $scope.getFeatureOffers();
                        $("#IamFeatured")[0].reset();
                    } else {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                    }
                    $scope.saveBtn = "Save";
                    $scope.$apply();
                }

            });



        };


        $scope.removeFromFeatured = function (campaign_id)
        {

            $.ajax({
                url: "<?php echo SITEURL . "admin/offer/featureofferRemove" ?>",
                type: 'POST',
                dataType: 'json',
                data: "campaign_id=" + campaign_id,
                success: function (data, textStatus, jqXHR) {

                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
                        $scope.getFeatureOffers();
                        $("#li" + campaign_id).remove();
                    } else {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                    }


                }

            });
        };

        $scope.getFeatureOffers = function ()
        {
            $.ajax({
                url: "<?php echo SITEURL . "admin/offer/featureoffer" ?>",
                type: 'POST',
                dataType: 'json',
                data: '',
                success: function (data, textStatus, jqXHR) {
                    $scope.featuredOffers = data.featureOffer;
//                    if (data['success'])
//                    {
//                        $.Notification.autoHideNotify('success',
//                                'botton right',
//                                data['msg'],
//                                '');
//
//                        $("#IamFeatured")[0].reset();
//                    } else {
//                        $.Notification.autoHideNotify('error',
//                                'botton right',
//                                data['msg'],
//                                '');
//                    }

                    $scope.$apply();
                }

            });

        };
        $scope.getFeatureOffers();
    });
</script>