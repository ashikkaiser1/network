

<div class="row"  ng-controller="campaign_controller">
    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading"><h3 class="panel-title">
<!--                    <a href="<?php echo SITEURL . "admin/campaign/CreateCampaign" ?>" class=" btn btn-purple waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-plus"></span> Campaign</a>-->


                    All Offers

                    <div class="pull-right">
                        <ul class="bulkActions">
                            <li>
                                <a title="Add a New Offer" href="<?php echo SITEURL . "admin/offer/CreateOffers" ?>" class=" btn btn-pink waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-plus"></span> Offer</a>
                            </li>

                            <li>
                                <a title="Send Bulk Email" ng-click="send_mail('<?php echo isset($email_link) ? $email_link : '#' ?>')" href="#" class=" btn btn-info waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-envelope"></span> Email </a>
                            </li>



                            <li>
                                <a title="Action Change Status" href="" class=" btn btn-success waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-anchor"></span> Actions </a>
                                <ul class="subOptions">

                                    <li><a href="#" ng-click="bulkAction(1)">Active</a></li>
                                    <li><a href="#" ng-click="bulkAction(0)">Inactive</a></li>
                                    <li><a href="#" ng-click="bulkAction(2)">Pause</a></li>
                                    <li><a href="#" ng-click="bulkAction(3)">Pending</a></li>
                                    <li><a href="#" ng-click="bulkAction(4)">Delete</a></li>
                                </ul>

                            </li>
                            <li>
                                <a href="<?php echo SITEURL . "import/offer_import/index" ?>" class=" btn btn-success waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-upload"></span> Import Offers </a>
                            </li>
                            
                            <li>
                                <a href="<?php echo SITEURL . "admin/offers_api_manager/index" ?>" class=" btn btn-pink waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-exchange"></span> Import Offers From Other Network </a>
                            </li>

                            <li>
                                <a title="Import Offer status" href="<?php echo SITEURL . "import/offer_import/change_offers" ?>" class=" btn btn-success waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-upload"></span> Import Offers Actions </a>
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
                                <label class="" for="exampleInputEmail2">Name</label>
                                <input type="text" name="campaign_name" class="form-control input-sm" id="campaign_name" ng-model="campaign_name" ng-model="searchText" placeholder="">
                                <input type="hidden" name="ctype" value="1"/>
                            </div>

                            <!--                            <div class="form-group m-l-10">
                                                            <label class="" for="">Type</label>
                            <?php
                            echo form_dropdown('ctype', $ctype, NORMALCAMP, "class='form-control'");
                            ?>
                            
                                                        </div>-->

                            <div class="form-group m-l-10">
                                <label class="" for="">Advertiser</label>
                                <?php
                                echo form_dropdown('uid', $advertiser, "", "class='form-control'");
                                ?>

                            </div>



                            <div class="form-group m-l-10">
                                <label class="" for="">Status</label>
                                <?php echo form_dropdown("status", $this->config->item("campaign_status"), '', "class='form-control'") ?>
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

                        <form id="OfferShowForm">
                            <div class="table-responsive table  table-hover">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" ng-model="selectAllOffers"/></th>
                                            <th>#</th>
                                            <th style="    width: 20%;">Name</th>
                                            <th>Advertiser</th>
    <!--                                        <th>Start Date</th>
                                            <th>End Date</th>-->
    <!--                                        <th>Cap</th>-->
                                            <th>Revenue</th>
                                            <th>Cost</th>
    <!--                                        <th>R.Type</th>
                                            <th>R.Cost<?php echo CURR ?> </th>
                                            <th>AC-PPI</th>
                                            <th>P.Type</th>
                                            <th>P.Cost<?php echo CURR ?> </th>-->
    <!--                                        <th>AFF-PPI</th>-->
                                            <th>Preview Url</th>
                                            <th>Category</th>
                                            <th>Geo</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr ng-repeat="camp in all_campaign| filter :campaign_name " id="tr{{camp.campaign_id}}">
                                            <td>
                                                <input class="campaign_ids" ng-checked="selectAllOffers" type="checkbox" name="campaign_id[]" value="{{camp.campaign_id}}"/>
                                            </td>

                                            <td>
                                                <a href="<?php echo SITEURL . "admin/campaign/offerRequest/" ?>{{camp.campaign_id}}">
                                                    {{camp.campaign_id}}
                                                </a>
                                            </td>
                                            <td>

                                                <a href="<?php echo SITEURL . "admin/campaign/offerRequest/" ?>{{camp.campaign_id}}">
                                                    {{camp.campaign_name}}
                                                </a> 


                                            </td>
                                            <td> 
                                                <a href="<?php echo SITEURL . "admin/users/ViewUser/" ?>{{camp.uid}}">
                                                    {{camp.name}}
                                                </a>
                                            </td>

                                            <td>
                                                {{camp.revenue_cost}}<?php echo CURR ?> {{camp.RevenueTypeName}}
                                            </td>
                                            <td>
                                                {{camp.payout_cost}}<?php echo CURR ?> {{camp.payOutTypeName}} 
                                            </td>
    <!--                                        <td> {{camp.start_date}}</td>
                                            <td> {{camp.end_date}}</td>
                                            <td> {{camp.cap}}</td>
                                            <td> {{camp.RevenueTypeName}}</td>
                                            <td> {{camp.revenue_cost}}</td>
                                                    <td> {{camp.act_ppi}}</td>
                                            <td> {{camp.payOutTypeName}}</td>
                                            <td> {{camp.payout_cost}}</td>-->
    <!--                                                <td> {{camp.per_impression_revenue}}</td>-->
                                            <td>
                                                <a target="_blank" href="{{camp.preview_link}}"><span class="fa fa-link"></span></a>
                                            </td>
                                            <td>{{camp.catName}}</td>

                                            <td ng-if="camp.geo == 0" title="{{camp.countryName}}">
                                                {{ camp.countryName | limitTo: 20 }}{{camp.countryName.length > 20 ? '...' : ''}}
                                            </td>
                                            <td ng-if="camp.geo == 1">Global</td>


                                            <td>
                                                <span titile='Active' ng-if="camp.c_status == 1" class=' text-success'> Active</span>
                                                <span titile='Inactivated' ng-if="camp.c_status == 0" class=' text-danger'> Inactive</span>
                                                <span titile='Paused' ng-if="camp.c_status == 2" class=' text-primary'> Paused</span>
                                                <span titile='Pending' ng-if="camp.c_status == 3" class=' text-warning'> Pending</span>
                                                <span titile='Deleted' ng-if="camp.c_status == 4" class=' text-danger'> Deleted</span>

                                            </td>
                                            <td>

<!--                                            <a ng-if="camp.ctype ==<?php echo OFFER ?>" type="button" href="<?php echo SITEURL . "admin/campaign/offerRequest/" ?>{{camp.campaign_id}}" class="btn btn-primary waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-eye"></span></a>
                                            <a ng-if="camp.ctype !=<?php echo OFFER ?>" type="button" href="<?php echo SITEURL . "admin/campaign/UpdateCampaign/" ?>{{camp.campaign_id}}" class="btn btn-primary waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span></a>
                                            <a ng-if="camp.ctype ==<?php echo OFFER ?>" type="button" href="<?php echo SITEURL . "admin/offer/UpdateOffers/" ?>{{camp.campaign_id}}" class="btn btn-primary waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span></a>-->



<!--                                                <a title="Create Offer Goals" type="button" href="<?php echo SITEURL . "admin/goals/CreateGoal/" ?>{{camp.campaign_id}}" class="btn btn-warning waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-plus"></span> Goal</a>-->
    <!--                                            <button type="button" ng-click="delete_campaign(camp.campaign_id)" class="btn btn-danger waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-trash"></span></button>-->
                                                <a title="Send Email" href="<?php echo isset($email_link) ? $email_link . "?campaign_id={{camp.campaign_id}}" : '#' ?>" class="btn btn-success waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-envelope"></span> Email</a>
                                                <a title="Offer Report or Stats" href="<?php echo isset($stats_link) ? $stats_link . "&campaign_id={{camp.campaign_id}}" : '#' ?>" class="btn btn-primary waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-bar-chart"></span></a>
    <!--                                            <a title="Add new post to campaign." type="button" href="<?php echo SITEURL . "admin/campaign/post_to_campaign/" ?>{{camp.campaign_id}}" class="btn btn-success waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-plus"></span></a>-->


                                            </td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                        </form>

                        <div class="text-danger text-center" ng-if="all_campaign == ''">
                            <h3 class='text-danger'>There is no data available ....</h3>
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
    //campaign_controller
    var campaign_controller = viral_pro.controller("campaign_controller", function ($scope) {

        $scope.all_campaign = {};
        $scope.searchBtn = "";
        $scope.FormAction = "<?php echo SITEURL . "admin/campaign/show_campaign" ?>";

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
        $scope.send_mail = function (url)
        {

            var query_string = $("input.campaign_ids").serialize();
            url = url + "?" + query_string;
            window.location = url;

        };



        $scope.search = function () {
            $scope.searchBtn = "";
            var form = $("#searchForm").serialize();
            $.ajax({
                url: $scope.FormAction + "?page=" + $scope.currentPage,
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_campaign = data;
                    $scope.searchBtn = "";
                    $scope.$apply();
                }
            });
        };



        $scope.bulkAction = function (action_type)
        {

            var form = $("#OfferShowForm").serialize();
            $.ajax({
                url: "<?php echo SITEURL . "admin/offer/bulkupdate" ?>" + "?status=" + action_type,
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
                        $scope.search();
                    } else
                    {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                    }
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
                    $scope.all_campaign = data;
                    $scope.$apply();
                }
            });
        };



        //delete campaing


        $scope.delete_campaign = function (campaign_id)
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
                                url: "<?php echo SITEURL . "admin/campaign/deleteCampaign" ?>",
                                type: 'POST',
                                data: "campaign_id=" + campaign_id,
                                dataType: 'json',
                                success: function (data, textStatus, jqXHR) {
                                    if (data['success'])
                                    {
                                        $.Notification.autoHideNotify('success',
                                                'botton right',
                                                data['msg'],
                                                '');
                                        $("#tr" + campaign_id).remove();
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



//        $scope.getCampaign();
    });</script>


<script>



</script>