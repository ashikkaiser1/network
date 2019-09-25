<div class="col-sm-12" id="trackingGenerate" ng-controller="trackingLink">
    <div class="panel panel-default" >
        <div class="panel-heading">
            <h3 class="panel-title">
                Tracking Link   
                <div class="pull-right">
                    <ul class="bulkActions">
                        <li>
                            <a href="<?php
                            $campaign_id = isset($campaign['campaign_id']) ? $campaign['campaign_id'] : 0;
                            echo SITEURL . "admin/offer_postback/AddUserOfferPostbacks/" . $campaign_id
                            ?>" id="ShowGoalForm" class=" btn btn-info waves-effect waves-light m-b-5 btn-xs">
                                <span class="fa fa-plus"></span> Post Back Setting</a></li>
                    </ul>
                </div>

            </h3></div>
        <div class="panel-body">
            <div class="row">

                <div class="col-lg-12" >

                    <div class="col-lg-12" id="postcode<?php echo isset($campaign['post_id']) ? $campaign['post_id'] : 0 ?>">

                        <div class="form-group m-l-4">
                            <label class="" for=""> Publisher</label>
                            <select class="form-control" id="uid" name="uid[]" ng-model='approvedPub'>

                            </select>
<?php //echo form_dropdown("uid", array("" => "Select Publisher") + $publisher, '', "class='form-control' id='uid'")  ?>
                        </div>

                        <div class="form-group m-l-4">
                            <label class="" for=""> Landing Page</label>
                            <select class="form-control" id="LandingPages" ng-model="abc" ng-change="appendUrl()">
                                <option value="">Default</option>
                                <option ng-repeat="ourl in offerUrls" value="{{ourl.url_id}}">
                                    {{ourl.name}}
                                </option>
                            </select>
                        </div>

                        <div  class="form-group" title="Copy Url">

                            <p id="postcodep<?php echo isset($campaign['post_id']) ? $campaign['post_id'] : 0 ?>" style="       word-wrap: break-word;
                               color: #1c1d1d;
                               font-weight: bold;
                               border: 1px solid #eeeeee;
                               padding: 5px;">Please Generate Link</p>
                        </div>

<!--        <button ng-click="getCode('<?php echo isset($campaign['post_id']) ? $campaign['post_id'] : 0 ?>', <?php echo isset($campaign['campaign_id']) ? $campaign['campaign_id'] : 0 ?>)" class="btn btn-default m-l-2   waves-effect waves-light"><span class="fa "></span>GET</button>-->
                    </div>


                </div> 


            </div>
        </div>
    </div>
</div>




<script>


    $("#uid").change(function () {
        if ($(this).val() != '')
        {
            angular.element(document.getElementById('trackingGenerate')).scope().getCode('<?php echo isset($campaign['post_id']) ? $campaign['post_id'] : 0 ?>', <?php echo isset($campaign['campaign_id']) ? $campaign['campaign_id'] : 0 ?>);
        }
        else
        {
            $("#postcodep" + <?php echo isset($campaign['post_id']) ? $campaign['post_id'] : 0 ?>).html("<span class='text-danger'>Please Select a Publisher</span>");
        }
    });
    //  var camp_post = angular.module("campaign", ['ui.bootstrap']);
    viral_pro.controller("trackingLink", function ($scope) {

        $scope.urlHolder = '';
        $scope.generatedTrakLink='';

        $scope.getCode = function (post_id, campaign_id)
        {

            var uid = $("#uid").val();
            $scope.urlHolder = "#postcodep" + post_id; 
//            $("#postcodep" + post_id).html("<img style='    width: 100px;    height: auto;    margin: 0 auto;    display: block;' src='<?php echo ASSETS . "images/30.gif" ?>' />");
            $("#postcodep" + post_id).html("Generating Link..");
            $.ajax({
                url: "<?php echo SITEURL . "admin/usr_offer_link_postback/generate_tracking_link" ?>",
                type: 'POST',
                data: 'domain_id=&campaign_id=' + campaign_id + "&uid=" + uid,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $("#postcodep" + post_id).html(data['gen_link']);
                        $scope.generatedTrakLink=data['gen_link'];
                    }
                    else
                    {
//                        $scope.approve_offer(post_id, campaign_id, uid);
                        // $("#postcodep" + post_id).html("<span class='text-danger'>" + data['msg'] + "</span> <a href='<?php echo SITEURL . "admin/offer_link_manager/offerRequest/" ?>" + campaign_id + "' class='btn waves-effect waves-light btn-success'>Apply</a>");
                    }
                }

            });


        };
        
        $scope.appendUrl = function()
        {
             var url_id = $("#LandingPages").val();
             if(url_id!='')
             {
                // $scope.generatedTrakLink+"&url="+url_id;
                 $( $scope.urlHolder).html($scope.generatedTrakLink+"&url="+url_id);
             }else
             {
                 $( $scope.urlHolder).html($scope.generatedTrakLink);
             }
        };

//        $scope.approve_offer = function (post_id, campaign_id, uid)
//        {
//
//            $.ajax({
//                url: "<?php echo SITEURL . "admin/offer_link_manager/offerApprove" ?>",
//                type: 'POST',
//                data: 'post_id=' + post_id + "&uid=" + uid,
//                dataType: 'json',
//                success: function (data, textStatus, jqXHR) {
//                    if (data['success'])
//                    {
//                        $scope.getCode(post_id, campaign_id);
//                        $.Notification.autoHideNotify('success',
//                                'botton right',
//                                data['msg'],
//                                '');
//
//                    } else {
//                        $.Notification.autoHideNotify('error',
//                                'botton right',
//                                data['msg'],
//                                '');
//                    }
//
//                }
//            });
//        };



        $scope.getLandingPages = function () {

            var form = "campaign_id=" +<?php echo $campaign_id ?>;
            $.ajax({
                url: "<?php echo SITEURL . "admin/offer_urls/showOfferUrls" ?>",
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $scope.offerUrls = data['offerUrls'];

                    }

                    $scope.$apply();
                }
            });
        };

        $scope.getLandingPages();

        angular.element(document.getElementById('OfferApproval')).scope().getpublishers('<?php echo $campaign_id ?>', 1, 'uid', 'getOfferPublisher');




    });
//    angular.element(document).ready(function() {
//      angular.bootstrap(document, ['campaign']);
//    });

</script>