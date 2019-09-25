<!-- jQuery library (served from Google) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<link href="<?php echo ASSETS ?>affiliate/bxslider/jquery.bxslider.css" rel="stylesheet" type="text/css"/>


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
    <div class="card" ng-controller="featuredOffers" >
         <div class="card-body">
            <h4 class="card-title">Featured Offers</h4>

            <ul class="bxslider" ng-if="featuredOffers != ''">
                <li ng-repeat="offers in featuredOffers">
                    <a class="fo-link" href="<?php echo SITEURL . "affiliate/campaign/offerRequest/" ?>{{offers.campaign_id}}">

                        <img ng-if="offers.image != ''" src="{{offers.image}}" />
                        <img ng-if="offers.image == ''" src="<?php echo @PROTOCOL ?>://www.freeiconspng.com/uploads/no-image-icon-6.png" />
                        <span class="text-black fo-font-size">{{offers.campaign_name| limitTo : 40}}({{offers.campaign_id}})</span> 
                        <div class="fo-payout">Payout : <span><?php echo CURR ?> {{offers.payout_cost| number : 2}}</span></div>
                    </a>    

                </li>
            </ul>


            <div  ng-if="featuredOffers == ''" style="text-align: center;font-size: larger" class="text-danger text-center">
                There is no feature offer..!!!
            </div>
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
                url: "<?php echo SITEURL . "affiliate/campaign/featureoffer" ?>",
                type: 'POST',
                dataType: 'json',
                data: '',
                success: function (data, textStatus, jqXHR) {
                    $scope.featuredOffers = data.featureOffer;
                    $scope.$apply();


                    var windowsize = $(window).width();

                    if (windowsize < 630) {
                        $('.bxslider').bxSlider({
                            minSlides: 1,
                            maxSlides: 1,
                            moveSlides: 1,
                            pager: false
                        });

                    } else {
                        $('.bxslider').bxSlider({
                            minSlides: 3,
                            maxSlides: 6,
                            moveSlides: 1,
                            mode: 'horizontal',
                            slideWidth: 170,
                            slideMargin: 10,
                            pager: false

                        });
                    }


//                    $('.bxslider').bxSlider({
//                        minSlides: 3,
//                        maxSlides: 6,
//                        slideWidth: 170,
//                        slideMargin: 10,
//                        pager: false
//                    });



//                    var slider = $('.bxslider').bxSlider();
//                    var widthMatch = matchMedia("all and (max-width: 767px)");
//                    var widthHandler = function (matchList) {
//                        if (matchList.matches) {
//                            
//                            
//                            slider.reloadSlider({
//                                minSlides: 3,
//                                maxSlides: 6,
//                                slideWidth: 170,
//                                slideMargin: 10,
//                                pager: false,
//                                
//                            })
//                        } else {
//                            slider.reloadSlider({
//                                minSlides: 1,
//                                maxSlides: 1,
//                                slideWidth: 500,
//                                slideMargin: 10,
//                                moveSlides: 1,
//                                pager: false,
//                                
//                            })
//                        }
//                    };








                }

            });

        };
        $scope.getFeatureOffers();
    });
</script>
