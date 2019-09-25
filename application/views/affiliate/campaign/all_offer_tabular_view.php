<div class="page-wrapper" ng-controller="camp_cont">

            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                     <h3 class="text-themecolor">Offer Explorer</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active">Offer Explorer</li>
                       
                    </ol>
                </div>
            </div>
<div class="container-fluid">
<div class="row">

    <?php $this->load->view("affiliate/campaign/search-panel"); ?>



</div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Offers</h4>
                                <div class="table-responsive m-t-40">
                                    <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>#ID</th>
                                                <th>Image</th>
                                                <th style="width: 30%">Offer</th>
                                                <th>Payout(<?php echo @CURR ?>)</th>
                                                <th>Geo</th>
                                                <th>Category</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="post in allPost">
                                                <td>
                                                    <a 
                                                        title="{{post.campaign_id}}"
                                                        href="<?php echo SITEURL . "affiliate/campaign/offerRequest/" ?>{{post.campaign_id}}">
                                                        {{post.campaign_id}}
                                                    </a> 
                                                </td>
                                                <td>
                                                    <img ng-if="post.image == '' || post.image == '0'" width="40" ng-src="http://www.freeiconspng.com/uploads/no-image-icon-6.png"/>
                                                    <img ng-if="post.image != '' && post.image != '0'" width="40" ng-src="{{post.image}}"/>
                                                </td>
                                                <td>
                                                    <a 
                                                        title="{{post.title}}"
                                                        href="<?php echo SITEURL . "affiliate/campaign/offerRequest/" ?>{{post.campaign_id}}">
                                                        {{post.title|limitTo :50 }}{{post.title.length > 50 ? '....' : ''}}
                                                    </a>   
                                                </td>
                                                <td>
                                                    <span ng-if="post.custom_payout != null " class="custom_option">{{post.custom_payout | number: 2}} , {{post.payout_type}} </span>
                                                    <span ng-if="post.custom_payout ==null && post.group_payout != null " class="custom_option">{{post.group_payout | number: 2}} , {{post.payout_type}} </span>
                                                    <span ng-if="post.payout_cost !=null && post.custom_payout ==null && post.group_payout == null"class="custom_option">{{post.payout_cost | number: 2}} , {{post.payout_type}} </span>
                                                </td>
                                                <td>
                                                    <span ng-if="post.countries != null" title="{{post.countries}}" class="custom_option"> 

                                                        {{ post.countries | limitTo: 20 }}{{post.countries.length > 20 ? '...' : ''}}

                                                    </span>
                                                    <span ng-if="post.countries == null" class="custom_option">Global
                                                    </span>

                                                </td> 
                                                <td title="{{post.catName}}">
                                                    {{ post.catName | limitTo: 20 }}{{post.catName.length > 20 ? '...' : ''}}
                                                </td>
                                                <td>
                                                    <button ng-if="post.status == 1 && (post.approve_offer == 1)" type="button" class="btn btn-sm btn-info btn-rounded waves-effect waves-light m-b-5">
                                                        active 
                                                    </button>
                                                    <button ng-if="post.status == 1 && post.approve_offer == 0" type="button" class="btn btn-sm btn-danger btn-rounded waves-effect waves-light m-b-5">
                                                        Blocked
                                                    </button>
                                                    <button ng-if="post.status == 1 && post.approve_offer == 3" type="button" class="btn btn-sm btn-default btn-rounded waves-effect waves-light m-b-5">
                                                        Rejected
                                                    </button>

                                                    <a ng-if="post.status == 1 && (post.approve_offer == 2 || post.approve_offer == null )" 
                                                        title="Fill the Form for offer."
                                                        href="<?php echo SITEURL . "affiliate/campaign/offerRequest/" ?>{{post.campaign_id}}">
                                                        <button type="button" class="btn btn-sm btn-purple btn-rounded waves-effect waves-light m-b-5">
                                                            Apply Now
                                                        </button>
                                                    </a>
                                                    


                                                </td>
                                            </tr>


                                        </tbody>
                                    </table>

                                    <div class="col-md-6">

                                    </div>
                                    <div class="col-md-6 col-xs-12" >
                                        <pagination  class="pagination"
                                            ng-model="currentPage"
                                            total-items="totalItems"
                                            max-size="maxSize"  
                                            boundary-links="true">
                                        </pagination>
                                        
                                    </div>
                                    <div class="col-md-3">

                                    </div>


                                    <div class="col-md-12" ng-if="allPost == ''" style="text-align: center; font-size: x-large;">
                                        No Data Exist!!
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>


</div>
<script>

</script>



</div> <!-- panel -->
</div> <!-- col -->
</div>

<script>
    //  var camp_post = angular.module("campaign", ['ui.bootstrap']);
    viral_pro.controller("camp_cont", function ($scope,$window) {
        $scope.currentPage = 1;
        $scope.numPerPage = 10;
        $scope.totalItems = 1000;
        $scope.maxSize = 5;
        $scope.Campaign = {};
        $scope.SelectedCategory = 0;
        $scope.allPost = {};
        $scope.selectedDomain = "Set A Domain";
        $scope.SelectedDomain_id = '';
        
        
        $scope.windowWidth = '';
        
         // Window resize event
         var w = angular.element($window);
         var pagination_resize =function () {
             
             // Get window width
             $scope.windowWidth = "innerWidth" in window ? window.innerWidth : document.documentElement.offsetWidth;
             
             // Change maxSize based on window width
             if($scope.windowWidth > 1000) {
                 $scope.maxSize = 5;        
             } else if($scope.windowWidth > 800) {
                 $scope.maxSize = 4;
             } else if($scope.windowWidth > 600) {
                 $scope.maxSize = 3;
             } else if($scope.windowWidth > 400) {
                 $scope.maxSize = 2;
             } else {
                 $scope.maxSize = 0;
             }
             $scope.$apply();
         };
         w.bind('load',pagination_resize);
         w.bind('resize',pagination_resize);
         
//         w.resize())
        
        
        
        $scope.getFirstLetter = function (name) {

            return name.substr(0, 1);
        };
        $scope.getRandomColor = function () {
//            var letters = '0123456789ABCDEF';
//            var color = '#';
//            for (var i = 0; i < 6; i++) {
//                color += letters[Math.floor(Math.random() * 16)];
//            }
//            return color;
        };
        $scope.refreshCampaingPost = function ()
        {
            var category_id = $scope.SelectedCategory;
            $scope.getPost(category_id);
        };
        $scope.search = function ()
        {
            $scope.currentPage = 1;
            $scope.getPost(0);
        };
        $scope.check_image = function (img)
        {
            if (img != '0' && img != 0)
                return img;
            return '<?php echo OFFER_IMG ?>';
        };
        $scope.$watch('currentPage + numPerPage', function () {
            console.log($scope.currentPage + $scope.numPerPage);
            console.log("State 1");
            $scope.getPost($scope.SelectedCategory);
        });
//        $scope.getPostByCatClick = function (category_id)
//        {
//            $scope.currentPage = 1;
//            $scope.SelectedCategory = category_id;
//            $scope.getPost(category_id);
//        };

        $scope.already_approved = function (campaign_id)
        {
            $.ajax({
                url: "<?php echo SITEURL . "affiliate/campaign/checkApproved" ?>",
                type: 'POST',
                data: "campaign_id=" + campaign_id,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {

                }


            });
        };
        $scope.getPost = function (category_id) {
            var form = $("#searchFormOffer").serialize();
            $("div.loader").show();
//            $("ul.aff_category li div").removeClass("active");
//            $("#cat" + category_id).addClass("active");
            //$("#campposts").trigger("click");
            //console.log($(this));
            console.log("campaign" + category_id);
            $.ajax({
                url: "<?php echo SITEURL . "affiliate/campaign/getPost" ?>" + "?page=" + $scope.currentPage,
                type: 'POST',
                data: form + "&getPost=1&approvalReq=1&getPostNonCampaign=1&type=<?php echo OFFER ?>",
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $("#camp" + category_id).addClass("active");
//                   $scope.Post= angular.extend($scope.Post, data);
//                   $scope.$apply();
//                   $scope.Post= angular.extend($scope.Post, data);
                    $scope.allPost = data;
                    $scope.$apply();
                    $("div.loader").hide();
                }


            });
        };
        $scope.getCode = function (post_id, campaign_id)
        {
            $("#postcode" + post_id).show();
            $("#postcodep" + post_id).html("<img style='    width: 100px;    height: auto;    margin: 0 auto;    display: block;' src='<?php echo ASSETS . "images/30.gif" ?>' />");
            $.ajax({
                url: "<?php echo SITEURL . "affiliate/campaign/generateLink" ?>",
                type: 'POST',
                data: 'post_id=' + post_id + '&domain_id=' + $scope.SelectedDomain_id + '&campaign_id=' + campaign_id,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $("#postcodep" + post_id).html(data['gen_link']);
                    } else
                    {
                        $("#postcodep" + post_id).html("<span class='text-danger'>" + data['msg'] + "</span> <a href='<?php echo SITEURL . "affiliate/campaign/offerRequest/" ?>" + campaign_id + "' class='btn waves-effect waves-light btn-success'>Apply</a>");
                    }
                }

            });
        };
        $scope.selectDomain = function (domainName, domain_id)
        {
            $scope.selectedDomain = domainName;
            $scope.SelectedDomain_id = domain_id;
        };
        $scope.hideCode = function (post_id)
        {
            $("#postcode" + post_id).hide();
        };
        $scope.triggerBtn = function ()
        {
            //console.log($("ul.aff_category li").first().children("div").trigger("click"));
            $("ul.aff_category li").first().children("div").trigger("click");
            //  $scope.$apply();
        };
        $scope.triggerBtn();
    });
//    angular.element(document).ready(function() {
//      angular.bootstrap(document, ['campaign']);
//    });

</script>