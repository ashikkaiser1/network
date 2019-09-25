<div class="col-sm-12">
  <div class="row"  ng-controller="genUrlController">

    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading"><h3 class="panel-title">
                    Add Conversion Pixel / URLs 

                </h3></div>
            <div class="panel-body">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 m-t-10 m-b-10 ">
                        <!--                        search-->
                        <form id="SetPixelForm" class="form-horizontal" role="form" ng-submit="AddConverPixeUrl()" >
                            <input type="hidden" name="post_id" value="<?php echo isset($campaign['post_id']) ? $campaign['post_id'] : 0 ?>"/>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Type</label>
                                <div class="col-md-10">
                                    <?php echo form_dropdown("p_type", $p_type, isset($link['p_type']) ? $link['p_type'] : '', "class='form-control'") ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Code/Url</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" rows="3" name="post_back"><?php echo isset($link['post_back']) ? $link['post_back'] : '' ?></textarea>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-2"></div>
                                <div class="col-md-5">
                                    <button type="submit" class="btn btn-success waves-effect waves-light m-l-10"><span class="fa fa-save">   </span> SAVE </button> 
                                   
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

    // var genUrlManager = angular.module("gen_url", ['ui.bootstrap']);
    //genUrlController
    var genUrlController = viral_pro.controller("genUrlController", function ($scope) {
        $scope.checkme = false;
        

        $scope.searchBtn = "SEARCH";
        $scope.FormAction = "<?php echo SITEURL . "advertiser/campaign/setConversionPixelUrl" ?>";

        $scope.AddConverPixeUrl = function () {
            $scope.search();
        };


        $scope.search = function () {
            $scope.searchBtn = "SEARCHING...";
            var form = $("#SetPixelForm").serialize();
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
//                        $scope.link_id = data['link']['link_id'];
//                        $scope.title = data['link']['title'];
//                        $scope.tracking_link = data['link']['gen_link'];
//                        $scope.post_back = data['link']['post_back'];
//                        $scope.pixel = data['pixel'];
//                        $scope.conv_pixel = data['conversion_pixel'];
//                        $scope.extraParam = data['link_extra'];
//                        $scope.extraParamLength = $scope.extraParam.length;
//                        $scope.linkEvent = data['link_event'];

                    }
                    else
                    {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');


                    }

                    $scope.$apply();
                    //                    $.each(data, function (index, item) {
                    //                        $scope.getCode(item.post_id, item.campaign_id);
                    //
                    //                    });
                }
            });
        };



    });





</script>  
    
</div>

