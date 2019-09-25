<div class="col-lg-12" ng-controller="trackingLink">

    <div class="col-lg-12" id="postcode<?php echo isset($campaign['post_id']) ? $campaign['post_id'] : 0 ?>">


        <div  class="col-md-12" title="Copy Url">

            <div class="form-group m-l-4">
                <label class="" for=""> Landing Page</label>
                <select class="form-control" id="LandingPages" ng-model="abc" ng-change="appendUrl()">
                    <option value="">Default</option>
                    <option ng-repeat="ourl in offerUrls" value="{{ourl.url_id}}">
                        {{ourl.name}}
                    </option>
                </select>
            </div>
            <div class="form-group m-l-4">
                <label class="" for="">Share It :</label>
                <p id="postcodep<?php echo isset($campaign['post_id']) ? $campaign['post_id'] : 0 ?>" style="    word-wrap: break-word;     margin: 0px;
                   border: 1px solid #1083d4;
                   padding: 5px;
                   }">Please Generate Link</p>
            </div>
            <button ng-click="getCode('<?php echo isset($campaign['post_id']) ? $campaign['post_id'] : 0 ?>', <?php echo isset($campaign['campaign_id']) ? $campaign['campaign_id'] : 0 ?>)" class="btn btn-default m-l-2   waves-effect waves-light"><span class="fa "></span>GET</button>
        </div>


    </div>


</div>


<script>
    //  var camp_post = angular.module("campaign", ['ui.bootstrap']);
    viral_pro.controller("trackingLink", function ($scope) {


        $scope.urlHolder = '';
        $scope.generatedTrakLink = '';



        $scope.getCode = function (post_id, campaign_id)
        {
            $scope.urlHolder = "#postcodep" + post_id;

            $("#postcodep" + post_id).html("Generating Link .....");
            $.ajax({
                url: "<?php echo SITEURL . "advertiser/campaign/generateLink" ?>",
                type: 'POST',
                data: 'post_id=' + post_id + '&domain_id=&campaign_id=' + campaign_id,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $("#postcodep" + post_id).html(data['gen_link']);

                        $scope.generatedTrakLink = data['gen_link'];
                        $scope.appendUrl();
                    }
                    else
                    {
                        $("#postcodep" + post_id).html("<span class='text-danger'>" + data['msg'] + "</span> <a href='<?php echo SITEURL . "advertiser/campaign/offerRequest/" ?>" + campaign_id + "' class='btn waves-effect waves-light btn-success'>Apply</a>");
                    }
                }

            });


        };

        $scope.appendUrl = function ()
        {
            var url_id = $("#LandingPages").val();
            if (url_id != '')
            {
                // $scope.generatedTrakLink+"&url="+url_id;
                $($scope.urlHolder).html($scope.generatedTrakLink + "&url=" + url_id);
            } else
            {
                $($scope.urlHolder).html($scope.generatedTrakLink);
            }
        };



        $scope.getLandingPages = function () {

            var form = "campaign_id=" +<?php echo $campaign_id ?>;
            $.ajax({
                url: "<?php echo SITEURL . "advertiser/offer_urls/showOfferUrls" ?>",
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $scope.offerUrls = data['offerUrls'];

                    }

                    $scope.$apply();
                }
            });
        };

        $scope.getLandingPages();





    });
//    angular.element(document).ready(function() {
//      angular.bootstrap(document, ['campaign']);
//    });

</script>