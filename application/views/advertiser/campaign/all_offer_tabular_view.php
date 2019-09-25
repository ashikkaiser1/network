
<link href="<?php echo ASSETS ?>css/offerlook.css" rel="stylesheet" type="text/css"/>
<div class="row" ng-controller="camp_cont">
    <nav class="top-nav">
        <h2 class="page-heading blue-bg">My Offer
        <a href="<?php echo SITEURL ."advertiser/offer/CreateOffers" ?>"  class="btn text-white pull-right waves-effect waves-light btn-warning" >
               <span class="fa fa-plus-circle"></span>New Offer
           </a>
        </h2>
    </nav>
    <?php $this->load->view("advertiser/campaign/search-panel"); ?>

    


    <div class="row">
        <div class="col-md-12">

            <div class="">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Offers</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="">
                                <div class="table-responsive">
                                    <table class="table " style="font-size: 12px">
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
                                                        href="<?php echo SITEURL . "advertiser/campaign/offerRequest/" ?>{{post.campaign_id}}">
                                                        {{post.campaign_id}}
                                                    </a> 
                                                </td>
                                                <td>
                                                    <img ng-if="post.image==''  || post.image=='0'" width="40" ng-src="http://www.freeiconspng.com/uploads/no-image-icon-6.png"/>
                                                    <img ng-if="post.image!=''  && post.image!='0'" width="40" ng-src="{{post.image}}"/>
                                                </td>
                                                <td>
                                                    <a 
                                                        title="{{post.title}}"
                                                        href="<?php echo SITEURL . "advertiser/campaign/offerRequest/" ?>{{post.campaign_id}}">
                                                        {{post.title|limitTo :50 }}{{post.title.length > 50 ? '....' : ''}}
                                                    </a>   
                                                </td>
                                                <td>
                                                    <span class="custom_option">{{post.paycost}} , {{post.payout_type}} </span>
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
                                                    <button ng-if="post.status==1" type="button" class="btn btn-sm btn-primary btn-rounded waves-effect waves-light m-b-5">
                                                        active
                                                    </button>
                                                    <button ng-if="post.status==2" type="button" class="btn btn-sm btn-warning btn-rounded waves-effect waves-light m-b-5">
                                                        pause
                                                    </button>
                                                    <button ng-if="post.status==3" type="button" class="btn btn-sm btn-info btn-rounded waves-effect waves-light m-b-5">
                                                        pending
                                                    </button>
                                                    <button ng-if="post.status==4" type="button" class="btn btn-sm btn-danger btn-rounded waves-effect waves-light m-b-5">
                                                        deleted
                                                    </button>
                                                    <button ng-if="post.status==0" type="button" class="btn btn-sm btn-default btn-rounded waves-effect waves-light m-b-5">
                                                        in-active
                                                    </button>
                                                </td>
                                            </tr>


                                        </tbody>
                                    </table>

                                    <div class="col-md-3">

                                    </div>
                                    <div class="col-md-6" >
                                        <pagination 
                                            ng-model="currentPage"
                                            total-items="1000"
                                            max-size="5"  
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
    viral_pro.controller("camp_cont", function ($scope) {
        $scope.currentPage = 1;
        $scope.numPerPage = 10;
        $scope.Campaign = {};
        $scope.SelectedCategory = 0;
        $scope.allPost = {};
        $scope.selectedDomain = "Set A Domain";
        $scope.SelectedDomain_id = '';
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
                url: "<?php echo SITEURL . "advertiser/campaign/checkApproved" ?>",
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
                url: "<?php echo SITEURL . "advertiser/campaign/getPost" ?>" + "?page=" + $scope.currentPage,
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
                url: "<?php echo SITEURL . "advertiser/campaign/generateLink" ?>",
                type: 'POST',
                data: 'post_id=' + post_id + '&domain_id=' + $scope.SelectedDomain_id + '&campaign_id=' + campaign_id,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $("#postcodep" + post_id).html(data['gen_link']);
                    } else
                    {
                        $("#postcodep" + post_id).html("<span class='text-danger'>" + data['msg'] + "</span> <a href='<?php echo SITEURL . "advertiser/campaign/offerRequest/" ?>" + campaign_id + "' class='btn waves-effect waves-light btn-success'>Apply</a>");
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