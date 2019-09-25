<div class="col-md-12">
    <div class="row" id="OfferUrlController" ng-controller="OfferUrlController">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class=" panel-title">
                        All Landing Pages  <div class="pull-right">

                        </div>
                    </h3>
                </div>  
                <div class="panel-body">
                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12 m-t-10 m-b-10 searchCustom hidden">
                            <!--                        search-->
                            <form id="OfferUrlSearch"  class="form-inline " role="form" ng-submit="searchByForm()" >

                                <div class="form-group m-l-10">
                                    <label class="" for="exampleInputEmail2"></label>
                                    <input type="text" name="campaign_id" class="form-control input-sm" value="<?php echo $campaign_id ?>" id=""  placeholder="">
                                </div>

                                <button type="submit" class="btn btn-success waves-effect waves-light m-l-10"><span class="fa fa-search"></span></button>
                            </form>
                            <!--end search-->
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        ?>
                                        <tr ng-repeat="ourl in offerUrls" id="tr{{ourl.url_id}}"  >
                                            <td>{{ ourl.url_id}}</td>
                                            <td>
                                                {{ourl.name}}
                                            </td>
                                            <td>
                                                <span ng-if="ourl.status == 1" class="text-success" >Active</span>
                                                <span ng-if="ourl.status == 0" class="text-success" >In-Active</span>
                                            </td>
                                            <td>


                                                <a href="{{ourl.previewUrl}}" type="button" class="btn btn-pink waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-link"></span> Preview Url</a>
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="no_data" style="text-align: center; font-size: x-large;"></div>


                            <!--                        <div class="col-md-12">
                                                        <pagination 
                                                            ng-model="currentPage"
                                                            total-items="1000"
                                                            max-size="5"  
                                                            boundary-links="true">
                                                        </pagination>
                                                    </div>-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //var ourlManager = angular.module("ourl_app", ['ui.bootstrap']);
    //OfferUrlController
    var OfferUrlController = viral_pro.controller("OfferUrlController", function ($scope) {

        $scope.offerUrls = {};
        $scope.searchBtn = "";
        $scope.FormAction = "<?php echo SITEURL . "advertiser/offer_urls/showOfferUrls" ?>";


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
            var form = $("#OfferUrlSearch").serialize();
            $.ajax({
                url: $scope.FormAction + "?page=" + $scope.currentPage,
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $('#no_data').hide();
                        $scope.offerUrls = data['offerUrls'];
                        $scope.searchBtn = "";
                    }
                    else
                    {
                        $('#no_data').show();
                        $('#no_data').html("No Data Exist!!");
                    }
                    $scope.$apply();
                }
            });
        };


    });
</script>