<div class="row"  ng-controller="OfferRequestController">
    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading"><h3 class="panel-title">
                    All Offer Request</h3></div>
            <div class="panel-body">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 m-t-10 m-b-10 searchCustom">
                        <!--                        search-->
                        <form id="searchForm" class="form-inline" role="form" ng-submit="searchByForm()" >

                            <div class="form-group m-l-10">
                                <label class="" for="exampleInputEmail2">Name</label>
                                <input type="text" name="campaign_name" class="form-control input-sm" id="campaign_name" ng-model="campaign_name" ng-model="searchText" placeholder="">

                            </div>

                            <!--                             <div class="form-group m-l-10">
                                                            <label class="" for="">Type</label>
                            <?php
                            echo form_dropdown('ctype', $ctype, NORMALCAMP, "class='form-control'");
                            ?>
                            
                                                        </div>
                                                        
                                                        <div class="form-group m-l-10">
                                                            <label class="" for="">Advertiser</label>
                            <?php
                            echo form_dropdown('uid', $advertiser, "", "class='form-control'");
                            ?>
                            
                                                        </div>-->



                            <div class="form-group m-l-10">
                                <label class="" for="">Status</label>
                                <?php echo form_dropdown("status", array("" => "All", "1" => "Accepted", "0" => "Pending"), '', "class='form-control'") ?>
                            </div>

                            <button type="submit" class="btn btn-success waves-effect waves-light m-l-10"><span class="fa fa-search">   </span> </button>

                        </form>
                        
                        
                           <script>
//    $(document).ready(function () {
//
//        $('input.ad_title').typeahead({
//            name: 'q',
//            remote: '?q=%QUERY'
//
//        });
//
//    });
//$(document).ready(function () {
                                    var options = {
                                        url: function (phrase) {
                                            return '<?php echo SITEURL . "admin/offer/campaign_name_suggetions" ?>';
                                        },
//        template: {
//            type: "custom",
//            method: function (value, item) {
//                if(item.category !==null)
//                {
//                    return  value +" in <span  class='in_category' >"+item.category+" <span> " ;
//                }
//                
//                return  value ;
//                
//            }
//            
//        },
                                        getValue: function (element) {
                                            return element.name;
                                        },
                                        list: {
                                            onSelectItemEvent: function () {
//			var value = $("#searchSugg").getSelectedItemData().category_id;
//
//			$("#category_id_sub").val(value).trigger("change");
                                            }
                                        },
                                        ajaxSettings: {
                                            dataType: "json",
                                            method: "POST",
                                            data: {
                                                dataType: "json"
                                            }
                                        },
                                        preparePostData: function (data) {
                                            data.phrase = $("#campaign_name").val();
                                           
                                            return data;
                                        },
                                        requestDelay: 400
                                    };


                                    $("#campaign_name").easyAutocomplete(options);

                        </script>
                        <!--end search-->
                    </div>





                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive table  table-hover">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th style="    width: 20%;">Name</th>
                                        <th>Publisher</th>
                                        <th>Offer Promotion</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr ng-repeat="offerReq in all_offerRequest| filter :campaign_name " id="tr{{offerReq.campaign_id}}">
                                        <td>{{offerReq.campaign_id}}</td>
                                        <td>
                                            <a target="_blank" href="<?php echo SITEURL . "admin/campaign/offerRequest/" ?>{{offerReq.campaign_id}}"> {{offerReq.campaign_name}} </a>
                                        </td>
                                        <td> {{offerReq.name}}</td>
                                        <td> {{offerReq.offerpro}}</td>
                                        <td>
                                            <span ng-if="offerReq.uora_id === null" class="fa fa-circle text-danger"></span>
                                            <span ng-if="offerReq.uora_id !== null" class="fa fa-circle text-success"></span>
                                        </td>    
                                        <td>
                                            <a  class="btn btn-primary waves-effect waves-light m-b-5 btn-xs" href="<?php echo SITEURL."admin/campaign/show_offer_request/" ?>{{offerReq.request_id}}"><span class="fa fa-eye"></span></a>
                                            <button type="button" ng-click="approve(offerReq.request_id, offerReq.uid, offerReq.campaign_id)"  class="btn btn-success waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-check"></span>Approve</button>
                                            <button type="button" ng-click="reject(offerReq.request_id, offerReq.uid, offerReq.campaign_id)"  class="btn btn-danger waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-close"></span>Reject</button>
<!--                                            <a title="View Details" type="button" href="{{offerReq.campaign_id}}" class="btn btn-primary waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-eye">View</span></a>-->
                                        </td>

                                    </tr>
                                    
                                    

                                </tbody>
                                
                            </table>
                            <div ng-if="all_offerRequest == ''"  style="text-align: center; font-size: x-large;" class="text-danger">
                                                    No Data Exist!!
                                                </div>
                        </div>
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
    //OfferRequestController
    var OfferRequestController = viral_pro.controller("OfferRequestController", function ($scope) {

        $scope.all_offerRequest = {};
        $scope.searchBtn = "";
        $scope.FormAction = "<?php echo SITEURL . "admin/campaign/show_request" ?>";

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
            var form = $("#searchForm").serialize();
            $.ajax({
                url: $scope.FormAction + "?page=" + $scope.currentPage,
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_offerRequest = data;
                    $scope.searchBtn = "";
                    $scope.$apply();
                }
            });
        };
        $scope.getCampaign = function () {

            $.ajax({
                url: $scope.FormAction,
                type: 'POST',
                data: 'user=1',
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_offerRequest = data;
                    $scope.$apply();
                }
            });
        };



        //delete campaing


        $scope.approve = function (request_id, uid, campaign_id)
        {
            swal({
                title: "Are you sure?",
                text: "Offer will be approved for Affiliate!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn btn-sm btn-danger waves-effect waves-light",
                confirmButtonText: "Yes, Approve it!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function (isConfirm) {
                if (isConfirm)
                {
                    $.ajax({
                        url: "<?php echo SITEURL . "admin/campaign/approve_offer_request" ?>",
                        type: 'POST',
                        data: "request_id=" + request_id + "&uid=" + uid + "&campaign_id=" + campaign_id,
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            if (data['success'])
                            {
                                $.Notification.autoHideNotify('success',
                                        'botton right',
                                        data['msg'],
                                        '');
                                $("#tr" + request_id).remove();
                                //$("#catForm")[0].reset();
                            } else {
                                $.Notification.autoHideNotify('error',
                                        'botton right',
                                        data['msg'],
                                        '');
                            }
                            
                            $scope.searchByForm();

                        }

                    });
                }


            });
        };

        $scope.reject = function (request_id, uid, campaign_id)
        {
            swal({
                title: "Are you sure?",
                text: "Offer will be rejected for Affiliate!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn btn-sm btn-danger waves-effect waves-light",
                confirmButtonText: "Yes, Reject it!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function (isConfirm) {
                if (isConfirm)
                {
                    $.ajax({
                        url: "<?php echo SITEURL . "admin/campaign/reject_offer_request" ?>",
                        type: 'POST',
                        data: "request_id=" + request_id + "&uid=" + uid + "&campaign_id=" + campaign_id,
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            if (data['success'])
                            {
                                $.Notification.autoHideNotify('success',
                                        'botton right',
                                        data['msg'],
                                        '');
                                $("#tr" + request_id).remove();
                                //$("#catForm")[0].reset();
                            } else {
                                $.Notification.autoHideNotify('error',
                                        'botton right',
                                        data['msg'],
                                        '');
                            }
                            
                            $scope.searchByForm();

                        }

                    });
                }


            });






        };



//        $scope.getCampaign();
    });</script>


<script>



</script>