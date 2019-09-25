<div class="row" id="OfferUrlController" ng-controller="OfferUrlController">
 
    <div class="col-md-12">
          <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class=" panel-title">
                    All Landing Pages  <div class="pull-right">
                        <ul class="bulkActions">
                            <li><a href="<?php echo SITEURL . "admin/offer_urls/AddOfferLandingUrl/" . $campaign_id ?>" id="ShowGoalForm" class=" btn btn-info waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-plus"></span> LANDING PAGE</a></li>
                        </ul>
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
                                            <a href="<?php echo SITEURL . "admin/offer_urls/UpdateOfferUrl/" ?>{{ourl.url_id}}" type="button" class="btn btn-primary waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span></a>
                                            <button type="button" ng-click="delete_ourl(ourl.url_id)" class="btn btn-danger waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-trash"></span></button>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                            
                            <div ng-if="offerUrls == ''" style="text-align: center; font-size: x-large;">
                                                    No Data Exist!!
                                                </div>
                        </div>


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
        $scope.FormAction = "<?php echo SITEURL . "admin/offer_urls/showOfferUrls" ?>";


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

        $scope.delete_ourl = function (url_id)
        {
            swal({
                title: "Are you sure?",
                text: "Your will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn btn-sm btn-danger waves-effect waves-light",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function (isConfirm) {
                if (isConfirm)
                {
                    $.ajax({
                        url: "<?php echo SITEURL . "admin/offer_urls/deleteOfferUrl" ?>",
                        type: 'POST',
                        data: "url_id=" + url_id,
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            if (data['success'])
                            {
                                $.Notification.autoHideNotify('success',
                                        'botton right',
                                        data['msg'],
                                        '');
                                $("#tr" + url_id).remove();
                                //$("#catForm")[0].reset();
                            } else {
                                $.Notification.autoHideNotify('error',
                                        'botton right',
                                        data['msg'],
                                        '');
                            }

                        }

                    });
                }


            });

        };

        $scope.search = function () {
            $scope.searchBtn = "";
            var form = $("#OfferUrlSearch").serialize();
            $.ajax({
                url: $scope.FormAction + "?page=" + $scope.currentPage,
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                     $scope.offerUrls = data['offerUrls'];
                    if (data['success'])
                    {
//                        $scope.offerUrls = data['offerUrls'];
                        $scope.searchBtn = "";
                    }

                    $scope.$apply();
                }
            });
        };


    });
</script>