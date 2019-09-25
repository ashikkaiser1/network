<div class="row" ng-controller="camp_post_cont">
    <div class="col-sm-12">

        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Campaign</h4>
                </div>
                <div class="panel-body">
                    <input type="text" placeholder="Search.." ng-model="campname" class="form-control"/>
                    <ul class="Campaign_list">
                        <li  class="waves-effect waves-light"  ng-repeat="camp in Campaign| filter: campname" ng-click="getPost(camp.campaign_id)" id="camp{{camp.campaign_id}}">

                            <h1>
                                <span ng-if="camp.c_status == 1" class="fa fa-circle text-success"></span>
                                <span ng-if="camp.c_status == 0" class="fa fa-circle text-danger"></span>
                                {{camp.campaign_name}} 


                            </h1>

                        </li>
                    </ul>  
                </div>
            </div>
        </div>





        <div class="col-md-9">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <!--                    <h4 class="panel-title col-md-2">Post</h4>-->
                    <div class="row">
                        <div class="col-md-11">
                            <ul class="nav nav-tabs tabs tabs-top ">
                                <li class="active tab" ng-click="refreshCampaingPost()">
                                    <a href="#home-21" id="campposts" data-toggle="tab" aria-expanded="false"> 
                                        <span class="visible-xs"><i class="fa fa-home"></i></span> 
                                        <span class="hidden-xs text-uppercase">Campaign Post</span> 
                                    </a> 
                                </li> 
                                <li class="tab"> 
                                    <a href="#profile-21" ng-click="getNonCampaign()" data-toggle="tab" aria-expanded="false"> 
                                        <span class="visible-xs"><i class="fa fa-user"></i></span> 
                                        <span class="hidden-xs text-uppercase">All Post</span> 
                                    </a> 
                                </li> 

                            </ul> 
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-pink waves-effect waves-light m-t-5" ng-click="show_hide_search()">
                                <span class="fa fa-2x  fa-search" id="iconID"></span>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12 m-t-10 m-b-10 searchCustom  {{ShowHide}}">
                        <!--                        search-->
                        <form id="searchForm" class="form-inline" role="form" ng-submit="searchByForm()">

                            <div class="form-group">
                                <label class="" for="exampleInputEmail2">Website</label>
                                <?php echo form_dropdown("web_id", array_replace(array("" => "All"), $website), '', "class='form-control'") ?>

                            </div>

                            <div class="form-group m-l-10">
                                <label class="" for="">Category</label>
                                <?php echo form_dropdown("category_id", array_replace(array("" => "All"), $category), '', "class='form-control'") ?>
                            </div>

                            <div class="form-group m-l-10">
                                <label class="" for="">Title</label>
                                <input type="text" name="title" class="form-control" id="" placeholder="">
                            </div>

                            <!--                            <div class="form-group m-l-10">
                                                            <label class="" for="">Status</label>
                            <?php //echo form_dropdown("status", array("" => "All", "1" => "Active", "0" => "De-Activated"), '', "class='form-control'") ?>
                                                        </div>-->

                            <button type="submit" class="btn btn-success waves-effect waves-light m-l-10"><span class="fa fa-search">   </span> {{searchBtn}}</button>
                        </form>
                        <!--end search-->
                    </div>

                </div>
                <div class="panel-body" style="max-height: 600px; overflow-x: hidden">


                    <!--                    //start-->
                    <!--                    Campaign Posts-->
                    <div class="col-md-12"> 

                        <div class="tab-content"> 
                            <div class="tab-pane active" id="home-21"> 
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="post in CampaignPost" id="post{{post.post_id}}">
                                            <td> {{post.post_id}}</td>
                                            <td>

                                                <img style="width: 40px"  src="{{post.image}}"/></td>
                                            <td><span ng-if="post.status == 1" class="fa fa-circle text-success"></span>
                                                <span ng-if="post.status == 0" class="fa fa-circle text-danger"></span>{{post.title}}</td>
                                            <td>

                                                <button ng-if="post.campaign_id == SelectedCampaign"  ng-click="removeToCampaign(post.post_id, post.campaign_id);" class="btn btn-danger waves-effect waves-light btn-xs btn-cust"><span class="fa fa-minus"></span></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> 
                            <div class="tab-pane" id="profile-21">

                                <!--                                all post-->
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="post in allPost" id="post{{post.post_id}}">
                                            <td>
                                                {{post.post_id}}</td>
                                            <td>
                                                <img style="width: 40px"  src="{{post.image}}"/></td>
                                            <td><span ng-if="post.status == 1" class="fa  fa-circle text-success"></span>
                                                <span ng-if="post.status == 0" class="fa fa-circle text-danger"></span>{{post.title}}</td>
                                            <td>
                                                <button  ng-click="addToCampaign(post.post_id);" class="btn btn-purple waves-effect waves-light btn-xs  btn-cust"><span class="fa fa-plus"></span></button>
<!--                                                <button ng-if="post.campaign_id == SelectedCampaign"  ng-click="addToCampaign(post.post_id);" class="btn btn-danger waves-effect waves-light btn-xs btn-cust"><span class="fa fa-minus"></span></button>-->
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>



                                <!--                                <div class="col-md-4" ng-repeat="post in Post">
                                                                    <div class="post post_cust">
                                                                        <button ng-if="post.campaign_id == null"  ng-click="addToCampaign(post.post_id);" class="btn btn-purple waves-effect waves-light btn-xs  btn-cust"><span class="fa fa-plus"></span> To Campaign</button>
                                                                        <button ng-if="post.campaign_id == SelectedCampaign"  ng-click="addToCampaign(post.post_id);" class="btn btn-danger waves-effect waves-light btn-xs btn-cust"><span class="fa fa-minus"></span> To Campaign</button>
                                            ?                            <button  ng-click="addToCampaign(post.post_id);" class="btn btn-purple waves-effect waves-light btn-xs  btn-cust"><span class="fa fa-plus"></span> To Campaign</button>
                                
                                                                        <div class="adonData">
                                                                            <div class="views"><span class="fa fa-eye"></span> 1.2k Views</div>
                                                                        </div>
                                                                        <img  src="{{post.image}}"/>
                                                                        <div class="postData">
                                                                            <h2 class="title title_cust">{{post.title}}</h2>
                                                                            <p class="description description_custom">{{post.meta}}</p>
                                                                        </div>  
                                                                                                            <div class="AddToCampaing">
                                                                                                                
                                                                                                            </div>
                                                                    </div>
                                                                </div>-->
                            </div> 

                        </div> 
                    </div> 
                    <!--end-->












                </div>
            </div>

        </div>
    </div> <!-- col -->
</div>
<!--<script>
    $(function () {

        $('#postForm').bootstrapValidator({
            message: false,
//            container: 'tooltip',
            trigger: null,
            live: 'disabled',
         
            feedbackIcons: {
                // valid: 'glyphicon glyphicon-ok',
                // invalid: 'glyphicon glyphicon-remove',
                // validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                title: {// field name
                    validators: {
                        notEmpty: {
                            message: ''
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9\s]+$/,
                            message: ''
                        },
                        stringLength: {
                            min: 3,
                            max: 25,
                            message: ''
                        }
                    }
                },
                meta: {// field name
                    validators: {
                        notEmpty: {
                            message: ''
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9\s]+$/,
                            message: ''
                        },
                        stringLength: {
                            min: 3,
                            max: 50,
                            message: ''
                        }
                    }
                }, url_slug: {// field name
                    validators: {
                        notEmpty: {
                            message: ''
                        },
                        url: {
                            message: ''
                        }, stringLength: {
                            min: 3,
                            max: 30,
                            message: ''
                        }
                    }
                }
            }

        }).on('success.form.bv', function (e) {
            e.preventDefault();
//                                angular.element(document.getElementById('postDiv')).scope().add_post();
//                                var $form = $(e.target);
//                                $form.bootstrapValidator('resetForm', true);
            // $('#postDiv').scope().add_post();
            //  sweetAlert("Oops...", "Please Fill Form Correctly!", "error");
        });
    });
</script>-->



</div> <!-- panel -->
</div> <!-- col -->
</div>

<script>
    // var camp_post = angular.module("camp_post", []);
    viral_pro.controller("camp_post_cont", function ($scope) {


        $scope.Campaign = {};
        $scope.SelectedCampaign = 0;
        $scope.allPost = {};
        $scope.CampaignPost = {};
        $scope.FormData = '';
        $scope.ActiveTab = 1;
        $scope.ShowHide = "hidden";

        $scope.show_hide_search = function ()
        {
            if ($scope.ShowHide == "hidden")
            {
                $scope.ShowHide = "";

                $("#iconID").removeClass("fa-search");
                $("#iconID").addClass("fa-close");
            }
            else
            {
                $scope.ShowHide = "hidden";
                $("#iconID").removeClass("fa-close");
                $("#iconID").addClass("fa-search");
            }
        };

        $scope.searchByForm = function ()
        {
            var formData = $("#searchForm").serialize();
            $scope.FormData = "&" + formData;
            if ($scope.ActiveTab == 1)
            {
                $scope.getPost($scope.SelectedCampaign);
            }
            else
            {
                $scope.getNonCampaign();
            }
            $scope.FormData = "";
        };


        $scope.getCampaign = function () {

            //get the list of campaign on left side

            $.ajax({
                url: "<?php echo SITEURL . "admin/campaign/post_to_campaign" ?>",
                type: 'POST',
                data: "getCamp =1&ctype=<?php echo NORMALCAMP ?>",
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {

                    $scope.Campaign = data;
                    $scope.$apply();

                }

            });

        };


        //remove from campaign
        $scope.removeToCampaign = function (post_id, campaign_id)
        {
            $.ajax({
                url: "<?php echo SITEURL . "admin/campaign/delPostFromCamp" ?>",
                type: 'POST',
                data: "post_id=" + post_id + "&campaign_id=" + campaign_id,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {


                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');

                        $("#post" + data['data'].post_id).remove();
                    } else {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                    }


                }

            });
        };

        $scope.getNonCampaign = function () {

            //get non campaign posts that are not belong to any campaign
            $scope.ActiveTab = 2;
            $.ajax({
                url: "<?php echo SITEURL . "admin/campaign/getPost" ?>",
                type: 'POST',
                data: "getPostNonCampaign=1&ctype=<?php echo NORMALCAMP ?>" + $scope.FormData,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.allPost = data;
                    $scope.$apply();

                }

            });


            //end codeo

        };

        $scope.refreshCampaingPost = function ()
        {
            var campaign_id = $scope.SelectedCampaign;

            $scope.getPost(campaign_id);
        };

        $scope.getPost = function (campaign_id) {

            $scope.ActiveTab = 1;
            $scope.SelectedCampaign = campaign_id;
            $("ul.Campaign_list li").removeClass("active");
            $("#camp" + campaign_id).addClass("active");


            $("#campposts").trigger("click");
            //console.log($(this));
            console.log("campaign" + campaign_id);
            $.ajax({
                url: "<?php echo SITEURL . "admin/campaign/getPost" ?>",
                type: 'POST',
                data: "getPost =1&ctype=<?php echo NORMALCAMP ?>&campaign_id=" + campaign_id + $scope.FormData,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $("#camp" + campaign_id).addClass("active");
//                   $scope.Post= angular.extend($scope.Post, data);
//                   $scope.$apply();
//                   $scope.Post= angular.extend($scope.Post, data);
                    $scope.CampaignPost = data;
                    $scope.$apply();

                }

            });

        };

        $scope.addToCampaign = function (post_id)
        {

            $.ajax({
                url: "<?php echo SITEURL . "admin/campaign/addpostToCampaign" ?>",
                type: 'POST',
                data: 'post_id=' + post_id + "&campaign_id=" + $scope.SelectedCampaign,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');

                        $("#post" + data['data'].post_id).remove();
                    } else {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                    }
                }


            });

        };
        $scope.getNonCampaign();
        $scope.getCampaign();


<?php
if ($campaign_id) {
    ?>
            $scope.getPost(<?php echo $campaign_id ?>);
    <?php
}
?>
    });


</script>