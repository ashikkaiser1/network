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


<div class="col-lg-6">
    <div class="panel panel-border panel-info" ng-controller="featuredOffers" >
        <div class="panel-heading"> 
            <h3 class="panel-title">Featured Offers</h3> 
        </div> 
        <div class="panel-body"> 
            <table class="table">

                <tbody>
                    <tr ng-repeat="offers in featuredOffers"> 
                        <td> <span>{{offers.campaign_name}}({{offers.campaign_id}})</span> </td>
                        <td>  <a href="<?php echo SITEURL."advertiser/campaign/offerRequest/" ?>{{offers.campaign_id}}" class=" btn btn-xs btn-primary pull-right"><span class="fa fa-eye  " title="Go to offer"></span></a></td>
                    </tr>
                </tbody>

            </table>
        </div> 
    </div>
</div>

<script>
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
                }

            });

        };
        $scope.getFeatureOffers();
    });
</script>