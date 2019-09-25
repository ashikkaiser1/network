<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default"  ng-controller="offerAPIController">
            <div class="panel-heading"><h3 class="panel-title"><?php echo $title ?>
                    <a href="<?php echo SITEURL."admin/offers_api_manager/other_network_settings" ?>" class=" pull-right btn btn-primary btn-sm"><span class="fa fa-plus"></span> New</a>
                </h3></div>
            <div class="panel-body">
                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>S.NO.</th>
                            <th>Network</th>
                            <th>Advertiser</th>
                            <th>Company</th>
                            <th>Offer Fetched</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr ng-repeat="allNet in allNetworkSetting">
                            <td>{{$index + 1}}</td>
                            <td>
                                <img width="100" src="<?php echo ASSETS . "images/" ?>{{allNet.logo}}"/>

                            </td>
                            <td>
                                {{allNet.advertiserName}}
                            </td>
                            <td>
                                {{allNet.companyName}}
                            </td>
                            <td>
                                {{allNet.offer_fetched}}
                            </td>
                            <td>
                                <button ng-if="allNet.btnText == null" 
                                        class="btn btn-purple waves-effect waves-light m-b-5" ng-click="getOffers(allNet,$index)">
                                    <span class="fa fa-play"></span>   Get Offers
                                </button>
                                <button ng-if="allNet.btnText != null" 
                                        class="btn btn-success waves-effect waves-light m-b-5" >
                                    <span class="fa fa-spin fa-refresh"></span>
                                    Processing
                                </button>

                            </td>
                        </tr>
                    </tbody>
                </table>


            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col -->
</div>
<!--<script>
    $(function () {

        $('#GoalForm').bootstrapValidator({
            message: false,
//            container: 'tooltip',
            trigger: null,
            live: 'enabled',
            feedbackIcons: {
                // valid: 'glyphicon glyphicon-ok',
                // invalid: 'glyphicon glyphicon-remove',
                // validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                goals_name: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Name field cannot be empty'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9\s]+$/,
                            message: 'Invalid Name'
                        },
                        stringLength: {
                            min: 3,
                            max: 25,
                            message: 'Name must be 3 to 25 characters long'
                        }
                    }
                }

            }

        }).on('success.form.bv', function (e) {
            e.preventDefault();

        });
    });
</script>-->
<script>
    //var Category = angular.module("Category", []);
    viral_pro.controller("offerAPIController", function ($scope,$interval) {

        $scope.message = "";
        $scope.saveBtn = "Save";
        $scope.all_goals = {};
        $scope.campaign_id = {value: "0", text: "None"};
        $scope.allNetworkSetting = {};
        
        $scope.getOffers = function(allNet,index){
            
            $scope.allNetworkSetting[index].btnText = 'pro';
            
            var url = "<?php echo SITEURL."offer_apis/";?>"+allNet.api_class;
            var data = "ons_id="+allNet.ons_id;
            
            
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                        if(data['success']){
                        $scope.allNetworkSetting[index].offer_fetched = data['offer_fetched'];
                        $scope.allNetworkSetting[index].btnText = null;
                        }
                        
                        $scope.$apply();
                    }
            });
        };
        
        
        
        
        
        $scope.checking_progress = function(){
          
          $.ajax({
             url: "<?php echo SITEURL."offer_apis/offer_counter/index";?>",
             type: 'POST',
             data: 'row=1',
             dataType: 'json',
             success: function (data, textStatus, jqXHR) {
                        
                    }
          });
            
        };
        $interval($scope.checking_progress, 10000);
        
        
        $scope.getNetworkSeting = function () {

            $.ajax({
                url: "<?php echo SITEURL . "admin/offers_api_manager/getNetworkSeting" ?>",
                type: 'POST',
                data: 'data=1',
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success']) {
                        $scope.allNetworkSetting = data['allNetworkSetting'];
                    }

                    $scope.$apply();
                }
            });

        };
 
        $scope.getNetworkSeting();
        $scope.checking_progress();  

    });
</script>
