<!-- jQuery library (served from Google) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<link href="<?php echo ASSETS ?>advertiser/bxslider/jquery.bxslider.css" rel="stylesheet" type="text/css"/>


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
    }

    div.offerFeature
    {
        background: white;
    }

</style>


<div class="<?php echo $class ?>">
    <div class="panel panel-border panel-info" ng-controller="featuredOffers" >
        <div class="panel-heading"> 
            <h3 class="panel-title">Featured Offers</h3> 
        </div> 
        <div class="panel-body"> 
            <ul class="bxslider">
                <li ng-repeat="offers in featuredOffers">
                    <a class="fo-link" href="<?php echo SITEURL . "advertiser/campaign/offerRequest/" ?>{{offers.campaign_id}}">
                        <img src="<?php echo @PROTOCOL ?>://www.freeiconspng.com/uploads/no-image-icon-6.png" />
                        <span class="text-black fo-font-size">{{offers.campaign_name | limitTo : 40}}({{offers.campaign_id}})</span> 
                        <div class="fo-payout">Payout : <span><?php echo CURR ?> {{offers.payout_cost | number : 2}}</span></div>
                    </a>    

                </li>
            </ul>
        </div> 
    </div>
</div>

<script>

    $(document).ready(function () {


    });
    //var Category = angular.module("Category", []);
    viral_pro.controller("featuredOffers", function ($scope) {


        $scope.featuredOffers = {};



        $scope.getFeatureOffers = function ()
        {
            $.ajax({
                url: "<?php echo SITEURL . "advertiser/campaign/featureoffer" ?>",
                type: 'POST',
                dataType: 'json',
                data: '',
                success: function (data, textStatus, jqXHR) {
                    $scope.featuredOffers = data.featureOffer;
                    $scope.$apply();

                    $('.bxslider').bxSlider({
                        minSlides: 3,
                        maxSlides: 6,
                        slideWidth: 170,
                        slideMargin: 10,
                        pager:false
                    });
                }

            });

        };
        $scope.getFeatureOffers();
    });
</script>
