<div class="row"  ng-controller="genUrlController">

    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading"><h3 class="panel-title">
                    Post Back url Setting </h3></div>
            <div class="panel-body">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 m-t-10 m-b-10 searchCustom">
                        <!--                        search-->
                        <form id="searchForm" class="form-inline" role="form" ng-submit="searchByForm()" >

                            <div class="form-group m-l-4 " style="width: 53%">
                                <label class="" for="">Select Offer</label>
                                <?php echo form_dropdown("post_id", $offers, '', "class='form-control ' style='width:82%'") ?>
                            </div>
                            <div class="form-group m-l-4">
                                <label class="" for=""> Publisher</label>
                                <?php echo form_dropdown("uid", $publisher, '', "class='form-control'") ?>
                            </div>
                            <button type="submit" class="btn btn-success waves-effect waves-light m-l-10"><span class="fa fa-download">   </span> GET URL </button>
                            <button type="button" ng-click="approve_offer()" class="btn btn-pink waves-effect waves-light m-l-10"><span class="fa fa-check">   </span> Approve </button>

                        </form>
                        <!--end search-->
                    </div>


                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <form id="genMainLink"  class="form-horizontal"  ng-submit="save()">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Name</label>
                                <div class="col-md-10">
                                    <input type="hidden" name="link_id" value="{{link_id}}" ng-model="link_id"/>
                                    <input type="text" class="form-control" value="" ng-model="title" placeholder="Offer Name" name="title">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Tracking Link</label>
                                <div class="col-md-8">
                                    <input type="text" readonly="" class="form-control" value="" ng-model="tracking_link"placeholder="Tracking Link" name="link">
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#custom-width-modal">Macros</button>
                                </div>
                                <?php $this->load->view("admin/offer/macros") ?>
                            </div>


                            <div class="form-group">
                                <label class="col-md-2 control-label">Extra Param</label>
                                <div class="col-md-10">
                                    <div class="row form-group" ng-repeat="extra in extraParam">
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" readonly="" value="{{extra.col_name}}{{CheckFromServer($index)}}" placeholder="paramName" name="col_name[{{ $index}}]">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" value="{{extra.col_value}}" placeholder="Param Value Or Macro" name="col_value[{{ $index}}]">
                                        </div>
                                    </div>



                                </div>

                                <div class="col-md-2"></div>
                                <div class="col-md-10">
                                    <div class="row form-group">

                                        <div class="col-md-10">  
                                            <button type="button" ng-click="addExtraPram()" class="btn btn-primary waves-effect waves-light m-b-5"><span class="fa fa-plus"></span> Parameter</button>
<!--                                             <button type="button" ng-click="RemoveExtraPram()" class="btn btn-danger waves-effect waves-light m-b-5"><span class="fa fa-minus"></span> Parameter</button>-->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Post Back Link</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="" ng-model="post_back" name="post_back">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Event</label>
                                <div class="col-md-10">
                                    <div class="row form-group" ng-repeat="Levent in linkEvent">
                                        <div class="col-md-3">
                                            <input type="hidden" name="offer_goal_id[{{ $index}}]" value="{{Levent.offer_goal_id}}"/>
                                            <input type="text"  readonly=""class="form-control" value="{{Levent.eventName}}" placeholder="Event Name" name="eventName[{{ $index}}]">
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" value="{{Levent.callback}}" placeholder="callback with macros" name="callback[{{ $index}}]">
                                        </div>
                                    </div>



                                </div>

                                <!--                                <div class="col-md-2"></div>
                                                                <div class="col-md-10">
                                                                    <div class="row form-group">
                                
                                                                        <div class="col-md-10">  
                                                                            <button type="button" ng-click="addEventLink()" class="btn btn-primary waves-effect waves-light m-b-5"><span class="fa fa-plus"></span> Event</button>
                                                                             <button type="button" ng-click="RemoveExtraPram()" class="btn btn-danger waves-effect waves-light m-b-5"><span class="fa fa-minus"></span> Parameter</button>
                                                                        </div>
                                                                    </div>
                                                                </div>-->
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Impression Pixel</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" readonly=""  rows="2">{{pixel}}</textarea>
                                    <span class="help-block"><small>Use image pixel for impression tracking.</small></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Conversion Pixel</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" readonly=""  rows="2">{{conv_pixel}}</textarea>
                                    <span class="help-block"><small>Use Conversion pixel for Conversion (by cookies) tracking.</small></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Generated Link</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" readonly=""  rows="4">{{generatedLink}}</textarea>
                                </div>
                            </div>



                            <div class="">
                                <button type="submit" class="btn btn-pink waves-effect waves-light m-b-5">Generate URL</button>
                            </div>
                        </form>
                        <!--

         
        </div> <!-- panel -->
                    </div> <!-- col -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    // var genUrlManager = angular.module("gen_url", ['ui.bootstrap']);
    //genUrlController
    var genUrlController = viral_pro.controller("genUrlController", function ($scope) {
        $scope.checkme = false;
        $scope.all_post = {};
        $scope.link_id = 0;
        $scope.title = '';
        $scope.tracking_link = '';
        $scope.post_back = '';
        $scope.extraParam = {};
        $scope.linkEvent = {"eventName": '', "callback": '', "offer_goal_id": ''};

        $scope.searchBtn = "SEARCH";
        $scope.FormAction = "<?php echo SITEURL . "admin/offer_link_manager/get_offerUrl" ?>";
        $scope.FormAction2 = "<?php echo SITEURL . "admin/offer_link_manager/offerApprove" ?>";
        $scope.searchByForm = function () {
            $scope.search();
        };

        $scope.approve_offer = function ()
        {
            var form = $("#searchForm").serialize();
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
                        $scope.searchByForm();

                    } else {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                    }

                }
            });
        };

        $scope.search = function () {
            $scope.searchBtn = "SEARCHING...";
            var form = $("#searchForm").serialize();
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
                        $scope.link_id = data['link']['link_id'];
                        $scope.title = data['link']['title'];
                        $scope.tracking_link = data['link']['gen_link'];
                        $scope.post_back = data['link']['post_back'];
                        $scope.pixel = data['pixel'];
                        $scope.conv_pixel = data['conversion_pixel'];
                        $scope.extraParam = data['link_extra'];
                        $scope.extraParamLength = $scope.extraParam.length;
                        $scope.linkEvent = data['link_event'];

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
                        $scope.post_back = ''

                        $scope.extraParam = {};
                        // $scope.approve_offer();
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
                data: 'post_id=' + post_id + '&domain_id=' + domain + '&campaign_id=' + campaign_id,
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