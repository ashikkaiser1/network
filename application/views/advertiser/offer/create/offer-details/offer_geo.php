
<div class="col-sm-12" ng-controller="targetingController">
    <div class="panel panel-default" >
        <div class="panel-heading">
            <h3 class="panel-title">
                Targeting 
                <div class="pull-right">
                    <ul class="bulkActions">
                       <li><a href="<?php echo SITEURL . "advertiser/offer/setGeoTargetting/" . $campaign_id ?>"  class=" btn btn-info waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-plus"></span> TARGETING</a></li>
                    </ul>
                </div>
                
            </h3></div>
        <div class="panel-body">
            <div class="row">

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="form-group m-b-10 m-b-10">
                            <label class="col-md-12 control-label">GEO</label>
                            <div class="col-md-9">

                                <?php
                                if (isset($offer_country) && !empty($offer_country)) {
                                    $country = implode(",", $offer_country);

                                    echo substr($country, 0, 100) . ".....";
                                    $country = implode("\n", $offer_country);
                                    echo "<span class='fa fa-info text-success' title ='$country'> More</span>";
                                } else {
                                    echo "Global Geo";
                                }

                                // print_r($campaign);
                                ?>
                            </div>
                        </div>

                    </div> <!-- col -->


                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-md-12 control-label text-left" style="">Devices</label>
                            <div class="col-md-12">
                                <ul>
                                    <li ng-repeat="device in devices">{{device}}</li>
                                    <li ng-if="devices==''">All</li>
                                </ul>
                            </div>


                        </div>
                        <div class="form-group">
                            <label class="col-md-12 control-label text-left" style="">Platforms</label>
                            <div class="col-md-12">
                                <ul>
                                    <li ng-repeat="platform in platforms">{{platform}}</li>
                                     <li ng-if="platforms==''">All</li>
                                </ul>


                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    viral_pro.controller("targetingController", function ($scope) {

        $scope.devices = {};
        $scope.platforms = {};
        $scope.getDevicePlatform = function (campaign_id) {


            $.ajax({
                url: "<?php echo SITEURL . "admin/offer_targeting/getTrageting" ?>",
                type: 'POST',
                data: "campaign_id=" + campaign_id,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {

                    $scope.devices = data['devices'];
                    $scope.platforms = data['platforms'];
                    $scope.$apply();
                }

            });

        };

        $scope.getDevicePlatform('<?php echo $campaign_id ?>');
    });

</script>



