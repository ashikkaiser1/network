

<div class="row"  ng-controller="pixel_controller">
    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading"><h3 class="panel-title">
                    All Conversion Pixel
                    <div class="pull-right">
                        <ul class="bulkActions">
                            <li>
                                <a title="Add New" href="<?php echo isset($add_link) ? $add_link : '#' ?> " class=" btn btn-info waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-plus"></span> Add New </a>
                            </li>

                            <!--                            <li>
                                                            <a title="Exit" href="javascript:void()" ng-click="edit_postBack()" class=" btn btn-success waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-edit"></span> Edit </a>
                                                        </li>-->
                            <li>
                                <a title="Exit" href="javascript:void(0)" ng-click="delete_postBack()" class=" btn btn-danger waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-remove"></span> Delete </a>
                            </li>
                        </ul>
                    </div>
                </h3></div>
            <div class="panel-body">
                <div class="row">


                    <div class="col-md-12 col-sm-12 col-xs-12 m-t-10 m-b-10 searchCustom">
                        <!--                        search-->
                        <form id="searchForm" class="form-inline" role="form" ng-submit="searchByForm()" >

                            <div class="form-group m-l-10">
                                <label class="" for="exampleInputEmail2">Search</label>
                                <input type="text" name="search" class="form-control input-sm" id=""  placeholder="Company, Offer ID ,postback">
                            </div>
                            <button type="submit" class="btn btn-success waves-effect waves-light m-l-10"><span class="fa fa-search">   </span> </button>
                        </form>
                        <!--end search-->
                    </div>



                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <form id="OfferShowForm">

                            <div class="table-responsive table  table-hover">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" ng-model="selectAllOffers"/></th>
                                            <th style="width: 20%">Company</th>
                                            <th style="width: 10%">Offer</th>
                                            <th style="width: 30%">Post back Url/Pixel</th>
                                            <th style="width: 10%">Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr ng-repeat="pixel in all_pixel" id="tr{{pixel.campaign_id}}">
                                            <td>
                                                <input class="campaign_ids" ng-checked="selectAllOffers" type="checkbox" name="link_id[]" value="{{pixel.link_id}}"/>
                                            </td>

                                            <td >
                                                <a href="<?php echo SITEURL . "admin/users/ViewUser/" ?>{{pixel.uid}}">
                                                    {{pixel.company}}
                                                </a> 
                                            </td>
                                            <td>
                                                <a href="<?php echo SITEURL . "admin/campaign/offerRequest/" ?>{{pixel.campaign_id}}"> 
                                                    {{pixel.campaign_id}}
                                                </a>
                                            </td>
                                            <td >
                                                <p class="postBackLink">{{pixel.post_back}}</p>
                                            </td>
                                            <td >
                                                <span ng-if="pixel.p_type == 0">Post Back</span>
                                                <span ng-if="pixel.p_type == 1">Image Pixel</span>
                                                <span ng-if="pixel.p_type == 2">iFrame Pixel</span>
                                            </td>

                                            <td> 
                                                <a type="button" href="<?php echo SITEURL . "admin/offer_postback/AddConvsrionUrlPixel/?post_id=" ?>{{pixel.post_id}}&uid={{pixel.uid}}"  class="btn btn-primary waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span></a>
<!--                                                <button type="button" ng-click="show_postabck(pixel.link_id)" class="btn btn-pink waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-eye"></span></button>-->
<!--                                                <button type="button" ng-click="delete_postabck(pixel.link_id)" class="btn btn-danger waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-trash"></span></button>-->

                                            </td>

                                        </tr> 

                                    </tbody>
                                </table>
                            </div>

                        </form>

                        <div class="col-md-3">

                        </div>
                        <div class="col-md-6">
                            <pagination 
                                ng-model="currentPage"
                                total-items="1000"
                                max-size="5"  
                                boundary-links="true">
                            </pagination>
                        </div>
                        <div class="col-md-3">

                        </div>
                    </div>
                </div>
            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col -->
</div>

<script>
    //var campaignManager = angular.module("campaign_app", ['ui.bootstrap']);
    //pixel_controller
    var pixel_controller = viral_pro.controller("pixel_controller", function ($scope) {

        $scope.all_pixel = {};
        $scope.searchBtn = "";
        $scope.FormAction = "<?php echo SITEURL . "admin/offer_postback/show_offer_postbacks" ?>";

        $scope.currentPage = 1;
        $scope.numPerPage = 10;

        $scope.searchByForm = function () {
            $scope.currentPage = 1;
            $scope.getConversionPixelUrl();
        };

        $scope.$watch('currentPage + numPerPage', function () {

            console.log($scope.currentPage + $scope.numPerPage);


            $scope.getConversionPixelUrl();

        });
//        $scope.send_mail = function (url)
//        {
//
//            var query_string = $("input.campaign_ids").serialize();
//            url = url + "?" + query_string;
//            window.location = url;
//
//        };



        $scope.getConversionPixelUrl = function () {
            $scope.searchBtn = "";
            var form = $("#searchForm").serialize();
            $.ajax({
                url: $scope.FormAction + "?page=" + $scope.currentPage,
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_pixel = data;
                    $scope.searchBtn = "";
                    $scope.$apply();
                }
            });
        };

        $scope.delete_postBack = function ()
        {

            var form = $("#OfferShowForm").serialize();


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
                        url: "<?php echo SITEURL . "admin/offer_postback/delete_postback" ?>",
                        type: 'POST',
                        data: form,
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {

                            if (data['success'])
                            {
                                $.Notification.autoHideNotify('success',
                                        'botton right',
                                        data['msg'],
                                        '');
                            }
                            else
                            {
                                $.Notification.autoHideNotify('error',
                                        'botton right',
                                        data['msg'],
                                        '');

                            }
                            $scope.getConversionPixelUrl();
                            $scope.$apply();
                        }
                    });
                }
            });


        };



//        $scope.bulkAction = function (action_type)
//        {
//
//            var form = $("#searchForm").serialize();
//            $.ajax({
//                url: "<?php echo SITEURL . "admin/offer/bulkupdate" ?>" + "?status=" + action_type,
//                type: 'POST',
//                data: form,
//                dataType: 'json',
//                success: function (data, textStatus, jqXHR) {
//
//                    if (data['success'])
//                    {
//                        $.Notification.autoHideNotify('success',
//                                'botton right',
//                                data['msg'],
//                                '');
//                        $scope.search();
//                    }
//                    else
//                    {
//                        $.Notification.autoHideNotify('error',
//                                'botton right',
//                                data['msg'],
//                                '');
//                    }
//                }
//            });
//        };

        //  $scope.getConversionPixelUrl();
    });</script>


<script>



</script>