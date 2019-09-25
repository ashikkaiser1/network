<div class="row" id="OfferUrlController"  ng-controller="genUrlController">

    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading"><h3 class="panel-title">
                    Add Conversion Pixel / URLs for Affiliates 

                    <div class="pull-right">
                        <ul class="bulkActions">
                            <li>
                                <a title="Show All" href="<?php echo isset($add_link) ? $add_link : '#' ?> " class=" btn btn-info waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-list"></span> Show All </a>
                            </li>
                        </ul>
                    </div>
                </h3></div>
            <div class="panel-body">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 m-t-10 m-b-10 ">
                        <form id="GenerateOfferLink" class="form-horizontal"  role="form">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Offer</label>
                                <div class="col-md-10">
                                    <?php echo form_dropdown("post_id", $offers, isset($selected['post_id']) ? $selected['post_id'] : '', "class='form-control checkOfferLink post_id_select2' id='onPostId'") ?>   
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Publisher</label>
                                <div class="col-md-10">
                                    <?php echo form_dropdown("uid", $publisher, isset($selected['uid']) ? $selected['uid'] : '', "class='form-control checkOfferLink' id ='onUID'") ?>
                                </div>
                            </div>
                        </form>


                        <!--                        search-->
                        <form id="UpdateOfferLinkAndGoals" class="form-horizontal" role="form" ng-submit="AddConverPixeUrl()" >
                            <input type="hidden" name="post_id" id="Off_postid" value="">
                            <input type="hidden" name="uid" id="off_uid" value="">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Type</label>
                                <div class="col-md-10">
                                    <?php echo form_dropdown("p_type", $p_type, isset($link['p_type']) ? $link['p_type'] : '', "class='form-control'") ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Code/Url</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" rows="3" id="show_post_back" name="post_back"></textarea>
                                </div>
                            </div>
                            <div class="form-group" ng-if="linkEvent !=''">
                                <label class="col-md-2 control-label">Goals</label>
                                <div class="col-md-10">
                                    <div class="row form-group" ng-repeat="Levent in linkEvent">
                                        <div class="col-md-3">
                                            <input type="hidden" name="offer_goal_id[{{ $index}}]" value="{{Levent.offer_goal_id}}"/>
                                            <input type="text"  readonly=""class="form-control" value="{{Levent.eventName}}" placeholder="Event Name" name="eventName[{{ $index}}]">
                                        </div>
                                        <div class="col-md-3">

                                            <select name="gp_type[{{ $index}}]" class="form-control">
                                                <option ng-repeat="(key,p_type) in p_type_list"
                                                        value="{{key}}" ng-selected="Levent.p_type == key"   
                                                        >{{p_type}}</option>

                                            </select>


                                        </div>
                                        <div class="col-md-6">
                                            <textarea rows="4" class="form-control" placeholder="callback with macros" name="callback[{{ $index}}]">{{Levent.callback}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-2"></div>
                                <div class="col-md-5">
                                    <button type="submit" class="btn btn-success waves-effect waves-light m-l-10"><span class="fa fa-save">   </span> SAVE </button> 
                                    <button type="button" ng-click="approve_offer()" class="btn btn-pink waves-effect waves-light m-l-10"><span class="fa fa-check">   </span> Approve </button>
                                </div>

                            </div>
                        </form>
                        <!--end search-->
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>
<script>

    $(document).ready(function () {

        defaultLoad();
    });

    $(".checkOfferLink").change(function () {

        defaultLoad();

    });

    function defaultLoad()
    {
        angular.element(document.getElementById('OfferUrlController')).scope().searchByForm();
        $("#Off_postid").val($("#onPostId").val());
        $("#off_uid").val($("#onUID").val());
    }
    // var genUrlManager = angular.module("gen_url", ['ui.bootstrap']);
    //genUrlController
    var genUrlController = viral_pro.controller("genUrlController", function ($scope) {
        $scope.checkme = false;
        $scope.all_post = {};
        $scope.p_type_list =<?php echo json_encode($p_type) ?>;
        $scope.link_id = 0;
        $scope.title = '';
        $scope.tracking_link = '';
        $scope.post_back = '';
        $scope.extraParam = {};
        $scope.linkEvent = <?php echo isset($link_event) ? json_encode($link_event) : "''" ?>;

        $scope.searchBtn = "SEARCH";
        $scope.FormAction = "<?php echo SITEURL . "admin/offer_link_manager/setConversionPixelUrl" ?>";
        $scope.FormAction2 = "<?php echo SITEURL . "admin/offer_link_manager/offerApprove" ?>";
        $scope.AddConverPixeUrl = function () {
            $scope.search("UpdateOfferLinkAndGoals");
        };

        $scope.searchByForm = function () {
            //call for auto generating link and set data in link tab
            //
            $scope.search("GenerateOfferLink");
        };

        $scope.approve_offer = function ()
        {
            var form = $("#GenerateOfferLink").serialize();
            $.ajax({
                url: $scope.FormAction2,
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
                        $scope.searchByForm("GenerateOfferLink");

                    } else {


                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                    }

                }
            });
        };

        $scope.search = function (formName) {
            $scope.searchBtn = "SEARCHING...";
            var form = $("#" + formName).serialize();
            $.ajax({
                url: $scope.FormAction,
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_post = data;
                    $scope.searchBtn = "SEARCH";
                    if (data['success'])
                    {

                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
                        //     console.log(form); 
                        if (formName == "GenerateOfferLink")
                        {
                            $scope.link_id = data['link']['link_id'];
                            //  $scope.title = data['link']['title'];
                            $scope.tracking_link = data['link']['gen_link'];
                            $scope.post_back = data['link']['post_back'];
                            console.log(data['link']['post_back']);
                            $("#show_post_back").val(data['link']['post_back']);
                            $scope.pixel = data['pixel'];
                            $scope.conv_pixel = data['conversion_pixel'];
                            $scope.extraParam = data['link_extra'];
                            $scope.extraParamLength = $scope.extraParam.length;
                            $scope.linkEvent = data['link_event'];
                        }


                    }
                    else
                    {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');


                        $scope.title = data['msg'];

                        $scope.link_id = '';

                        $scope.tracking_link = '';
                        // $scope.post_back = ''

                        $scope.extraParam = {};
                        $scope.approve_offer();
                    }

                    $scope.$apply();
                    //                    $.each(data, function (index, item) {
                    //                        $scope.getCode(item.post_id, item.campaign_id);
                    //
                    //                    });
                }
            });
        };


        $scope.extraParamLength = 0;
        $scope.CheckFromServer = function (index)
        {

            if ($scope.extraParamLength <= index)
            {
                return index + 1;
            }
            return '';


        };
        $scope.addExtraPram = function ()
        {
            $scope.extraParam.push({"col_name": 'aff_sub', "col_value": ''});
            $scope.$apply();
        };



        $scope.addEventLink = function ()
        {
            $scope.linkEvent.push({"eventName": '', "callback": '', "offer_goal_id": ''});
            $scope.$apply();
        };

        //          $scope.RemoveExtraPram = function ()
//        {
        //            $scope.extraParam.pop();
//            $scope.$apply();
//        };
        $scope.getCode = function (post_id, campaign_id)
        {
            var domain = '';

            $.ajax({
                url: "<?php echo SITEURL . "admin/offer_link_manager/generateLink" ?>",
                type: 'POST',
                data: 'post_id=' + post_id + 'campaign_id=' + campaign_id,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $("#postcodep" + post_id).html(data['gen_link']);
                    }
                    else
                    {
                        $("#postcodep" + post_id).html(data['msg']);
                    }
                }

            });
        };

        $scope.save = function () {
            var form = $("#genMainLink").serialize();

            $.ajax({
                url: "<?php echo SITEURL . "admin/offer_link_manager/generatePublisherLink" ?>",
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.generatedLink = data['genurl'];
                    $scope.$apply();
                }
            });




        };
    });





</script>