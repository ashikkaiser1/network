
<link href="<?php echo ASSETS ?>css/offerlook.css" rel="stylesheet" type="text/css"/>
<div class="row" ng-controller="camp_cont">
    <nav class="top-nav">
        <h2 class="page-heading blue-bg">My Offers
            <a href="<?php echo SITEURL ."advertiser/offer/CreateOffers" ?>"  class="btn text-white pull-right waves-effect waves-light btn-warning" >
               <span class="fa fa-plus-circle"></span>New Offer
           </a> 
               
        </h2>
    </nav>
    <?php $this->load->view("advertiser/campaign/search-panel"); ?>

<!--    <div class="row">
        <?php
//        $data = array();
//        $data['class'] = 'col-md-12';
//        $this->load->view("advertiser/dashboard/featured_offer_silder", $data);
        ?>
    </div>-->


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-border panel-pink"  >
                <div class="panel-heading"> 
                    <h3 class="panel-title">All Offers
                  
                    </h3> 
                </div> 
                <div class="panel-body"> 
                    <div class="col-sm-12">
                        <div class="col-md-4" ng-repeat="post in allPost">
                            <div class="post offer_cust m-b-10 m-t-10">

                                <!--                <div class="adonData">
                                                    <div class="views"><span class="fa fa-eye"></span> 1.2k</div>
                                                </div>-->
                                <!--                <div class="backImg" style="background-image: url({{post.image}})">
                                                    
                                                </div>-->
                                <a href="<?php echo SITEURL . "advertiser/campaign/offerRequest/" ?>{{post.campaign_id}}">
                                    <div class="camp_name" style="background: {{getRandomColor()}}">
                                        {{getFirstLetter(post.title)}}
                                    </div>

<!--                                <img  src="{{check_image(post.image)}}"/>-->
                                </a>
                                <div class="postData ">
                                    <h2 class="title title_cust col-md-10">
                                        <a  title="{{post.title}}" target="_blank" href="<?php echo SITEURL . "advertiser/campaign/offerRequest/" ?>{{post.campaign_id}}">{{post.title|limitTo :50 }}{{post.title.length > 50 ? '....' : ''}}
                                        </a>
                                        
                                         <span title="{{post.catName}}" class="custom_option">Category : 
                                         {{ post.catName | limitTo: 20 }}{{post.catName.length > 20 ? '...' : ''}}
                                        </span>
                                        
                                        <span class="custom_option">Payout : {{post.payout_type}}, {{post.payout_cost}} </span>
                                        <span ng-if="post.countries != null" title="{{post.countries}}" class="custom_option">GEO : 
                                            
                                             {{ post.countries | limitTo: 20 }}{{post.countries.length > 20 ? '...' : ''}}
                                            
                                        </span>
                                         <span ng-if="post.countries ==null" class="custom_option">GEO : Global
                                            </span>
                                    </h2>
                                    <a class="customGetBtn btn btn-default m-l-2 col-md-10 btn  waves-effect waves-light" href="<?php echo SITEURL . "advertiser/campaign/offerRequest/" ?>{{post.campaign_id}}">Get</a>

<!--                    <button ng-click="getCode(post.post_id, post.campaign_id)" class="customGetBtn btn btn-default m-l-2 col-md-10 btn  waves-effect waves-light"><span class="fa "></span>GET</button>-->

                                </div> 
                                <div class="AddToCampaing" id="postcode{{post.post_id}}">

                                    <div  class="col-md-10" title="Copy Url">
                                        Share It :<p id="postcodep{{post.post_id}}" style="    word-wrap: break-word;"></p>
                                    </div>
                                    <button style="height: 64px;border-radius: 0px" ng-click="hideCode(post.post_id)" class="btn btn-icon waves-effect waves-light btn-danger col-md-2"> <i class="fa fa-remove"></i> </button>
                                </div>
                            </div>
                        </div>

                    </div> 

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