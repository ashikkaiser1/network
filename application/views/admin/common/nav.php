<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <div class="user-details">
            <div class="pull-left">
                <span style="    width: 45px;
                      background: #fdbf5e;
                      text-transform: capitalize;
                      color: white;
                      padding: 3px;
                      height: 45px;
                      display: block;
                      border-radius: 50%;
                      text-align: center;
                      font-size: 30px;"><?php echo substr(UserTitle, 0, 1) ?></span>

            </div>
            <div class="user-info">
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo UserTitle ?><span class="caret"></span></a>
                    <ul class="dropdown-menu">
<!--                        <li><a href="javascript:void(0)"><i class="md md-face-unlock"></i> Profile<div class="ripple-wrapper"></div></a></li>-->
                        <li><a href="<?php echo SITEURL . "admin/setting/index" ?>"><i class="md md-settings"></i> Settings</a></li>
                        <li><a href="javascript:void(0)"><i class="md md-lock"></i> Lock screen</a></li>
                        <li><a href="<?php echo SITEURL . "account/account/logout" ?>"><i class="md md-settings-power"></i> Logout</a></li>
                    </ul>
                </div>

                <p class="text-muted m-0 text-capitalize"><?php echo USERTYPE; ?></p>
            </div>
        </div>
        <!--- Divider -->
        <div id="sidebar-menu" ng-controller="sliderMenu">
            <ul>
                <li>
                    <a href="<?php echo SITEURL . "admin/dashboard" ?>" class="waves-effect"><i class="md md-home"></i><span> Dashboard </span></a>
                </li>
				<?php if (UID == 1) { ?>
                <li class="has_sub">
                    <a href="#" class="waves-effect"><i class="fa fa-adn"></i><span> Offers </span><span class="pull-right"><i class="md md-add"></i></span></a>
                    <ul class="list-unstyled">
						<li> <a href="<?php echo SITEURL . "admin/offer/offer_gen" ?>" class="waves-effect">Offer Management<span class="pull-right"></span></a></li>
                        <li> <a href="<?php echo SITEURL . "admin/offer/CreateOffers" ?>" class="waves-effect">Create Offer<span class="pull-right"></span></a></li>
                        <li><a href="<?php echo SITEURL . "admin/offer/show_campaign" ?>">Show Offers</a></li>
                        <li><a href="<?php echo SITEURL . "admin/campaign/show_request" ?>">Offer Applications</a></li>
                    </ul>
                </li>
				<?php } ;?>
                <li class="has_sub">
                    <a href="#" class="waves-effect"><i class="fa fa-users"></i><span> Affiliate </span><span class="pull-right"><i class="md md-add"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo SITEURL . "admin/users/CreateUser/" . AFFILIATE ?>">Create Affiliate</a></li>
                        <li><a href="<?php echo SITEURL . "admin/users/ShowUsers/" . AFFILIATE ?>">All Affiliate</a></li>
                        <li>
                            <a href="<?php echo SITEURL . "admin/users/show_user_request/" . AFFILIATE . "?status=2" ?>" class="waves-effect"><span class="newUsers" id="newUsersAffi">{{pendingUsers}}</span>Users Application</a>
                        </li>
                        
						
						<li>
                            <a href="<?php echo SITEURL . "admin/payments/sysinvoice" ?>" class="waves-effect">Invoice Management</a>
                        </li>
						
						<?php if (UID == 1) { ?>
<li>
                            <a href="<?php echo SITEURL . "admin/payments/aff_payments" ?>" class="waves-effect">Affiliate Payments</a>
                        </li>
						<li>
                            <a href="<?php echo SITEURL . "admin/refferal_program/" ?>" class="waves-effect">Referral Program</a>
                        </li>
						<li>
                            <a href="<?php echo SITEURL . "admin/api_token/showApiTokenRequest" ?>" class="waves-effect">API Token Request</a>
                        </li>
						<li>
                            <a href="<?php echo SITEURL . "admin/user_group/CreateGroup/" . AFFILIATE ?>" class="waves-effect">Users Group</a>
                        </li>
						<li>
                            <a href="<?php echo SITEURL . "admin/offer_postback/show_offer_postbacks" ?>" class="waves-effect">Pixel Manager</a>
                        </li>

                          <?php } ;?>

                        <!--                        <li><a href="email-read.html">Search User</a></li>-->
                    </ul>
                </li>
<?php if (UID == 1) { ?>
                <li class="has_sub">
                    <a href="#" class="waves-effect"><i class="fa fa-users"></i><span> Advertiser </span><span class="pull-right"><i class="md md-add"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo SITEURL . "admin/users/CreateUser/" . ADVERTISER ?>">Create Advertiser</a></li>
                        <li><a href="<?php echo SITEURL . "admin/users/ShowUsers/" . ADVERTISER ?>">All Advertisers</a></li>
                        <!--                        <li><a href="email-read.html">Search User</a></li>-->
                        <li>
                            <a href="<?php echo SITEURL . "admin/users/show_user_request/" . ADVERTISER . "?status=2" ?>" class="waves-effect"><span class="newUsers" id="newUsersAdver">{{pendingAdverUsers}}</span>Users Applications</a>
                        </li>
                        <li>
                            <a href="<?php echo SITEURL . "admin/payments/show_deposit_payment_request" ?>" class="waves-effect">Advertiser Payment</a>
                        </li>


                    </ul>
                </li>

                <li class="has_sub">
                    <a href="#" class="waves-effect"><i class="fa fa-users"></i><span> Account Manager </span><span class="pull-right"><i class="md md-add"></i></span></a>
                    <ul class="list-unstyled">
<!--                        <li><a href="<?php echo SITEURL . "admin/users/CreateUser" ?>"> <i class="fa fa-user-plus"></i> Create User</a></li>-->
                        <li><a href="<?php echo SITEURL . "admin/employee/CreateEmployee" ?>">Create Account Manager</a></li>
                        <li><a href="<?php echo SITEURL . "admin/users/ShowUsers/" . ACC_MANAGER ?>">All Account Manager</a></li>
                        <!--<li><a href="<?php echo SITEURL . "admin/users/ShowUsers/" . EMPLOYEE ?>">All Employee</a></li>-->
                        <!--                        <li><a href="email-read.html">Search User</a></li>-->
                    </ul>
                </li>

 <?php } ;?>

                <li class="has_sub">
                    <a href="#" title="Reports" class="waves-effect"><i class="fa fa-bar-chart"></i><span> All Reports </span><span class="pull-right"><i class="md md-add"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo SITEURL . "admin/report/advance_report" ?>" title="Adv. Reports" class="waves-effect">Advance Reports</a></li>

                        <li><a href="<?php echo SITEURL . "admin/report/advance_report?repType=daily_report" ?>" title="Adv. Reports" class="waves-effect">Daily Reports</a></li>
                        <li><a href="<?php echo SITEURL . "admin/report/advance_report?repType=offers_report" ?>" title="Adv. Reports" class="waves-effect">Offer Reports</a></li>
                        <li><a href="<?php echo SITEURL . "admin/report/advance_report?repType=aff_report" ?>" title="Adv. Reports" class="waves-effect">Affiliate Reports</a></li>
                        <li><a href="<?php echo SITEURL . "admin/conversion_report/conv_report?repType=offers_report" ?>" title="Adv. Reports" class="waves-effect">Conversion Reports</a></li>
<?php if (UID == 1) { ?>						
                        <li><a href="<?php echo SITEURL . "admin/report/advance_report?repType=hourly_report" ?>" title="Adv. Reports" class="waves-effect">Hourly Reports</a></li>
                        <li><a href="<?php echo SITEURL . "admin/report/advance_report?repType=adv_report" ?>" title="Adv. Reports" class="waves-effect">Advertiser Reports</a></li>
						
 <?php } ;?>						
						

                  


                    </ul>



                </li>
<?php if (UID == 1) { ?>	
<li class="has_sub">
                    <a href="#" title="News & Announcements" class="waves-effect"><i class="fa fa-volume-up"></i><span> Notifications </span><span class="pull-right"><i class="md md-add"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo SITEURL . "admin/notification/CreateNoti" ?>">Add News</a></li>
                        <li><a href="<?php echo SITEURL . "admin/notification/allNotification" ?>">All News</a></li>


                    </ul>
                </li>



                <li class="has_sub">
                    <a href="#" class="waves-effect"><i class="fa fa-list"></i><span> Category </span><span class="pull-right"><i class="md md-add"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo SITEURL . "admin/category/CreateCategory" ?>">Create Category</a></li>


                    </ul>
                </li>

                <!--                <li class="has_sub">
                                    <a href="#" class="waves-effect"><i class="fa fa-globe"></i><span> Domain </span><span class="pull-right"><i class="md md-add"></i></span></a>
                                    <ul class="list-unstyled">
                                        <li><a href="<?php echo SITEURL . "admin/domain/CreateDomain" ?>">Create Domain</a></li>
                
                
                                    </ul>
                                </li>
                                <li class="has_sub">
                                    <a href="#" class="waves-effect"><i class="fa fa-link"></i><span> Website </span><span class="pull-right"><i class="md md-add"></i></span></a>
                                    <ul class="list-unstyled">
                                        <li><a href="<?php echo SITEURL . "admin/website/CreateWebsite" ?>">Create/Show Website</a></li>
                
                
                
                                    </ul>
                                </li>-->
                <li class="has_sub">
                    <a href="#" class="waves-effect"><i class="fa fa-square-o"></i><span> Macros </span><span class="pull-right"><i class="md md-add"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo SITEURL . "admin/macros/CreateMacro" ?>">Create/Show Macro</a></li>
                    </ul>
                </li>

                <li class="">
                    <a href="<?php echo SITEURL . "admin/creative" ?>" title="Upload Creativies" class="waves-effect"><i class="fa fa-files-o"></i><span> Creative</span></a>

                </li>
                <li class="has_sub">
                    <a href="#" class="waves-effect"><i class="fa fa-gears"></i><span> Preferences </span><span class="pull-right"><i class="md md-add"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo SITEURL . "admin/domain/CreateDomain" ?>">Manage tracking domain</a></li>
                        <li><a href="<?php echo SITEURL . "admin/ip_pool/CreateIp" ?>">IP Settings</a></li>
                        <li><a href="<?php echo SITEURL . "admin/offer_category" ?>">Offer Category/ Verticals</a></li>
                        <!--<li><a href="<?php echo SITEURL . "admin/job_schedule/allJobs" ?>">Job Scheduler</a></li>-->
                        <li><a href="<?php echo SITEURL . "admin/faq" ?>">FAQs</a></li>
                        <li><a href="<?php echo SITEURL . "admin/system" ?>">System Settings</a></li>

                    </ul>
                </li>


 <?php } ;?>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<script>
    var sliderMenu = viral_pro.controller("sliderMenu", function ($scope) {


        $scope.getuserCount = function (status, divid, variable, UTID) {

            $.ajax({
                url: "<?php echo SITEURL . "admin/users/userCount" ?>",
                type: 'POST',
                data: 'status=' + status + "&UTID=" + UTID,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $("#" + divid).show();

                        switch (variable)
                        {
                            case "pendingUsers" :

                                $scope.pendingUsers = data['totalUser'];
                                break;
                            case "pendingAdverUsers" :

                                $scope.pendingAdverUsers = data['totalUser'];
                                break;
                            default :
                                break;
                        }

                    } else
                        $("#" + divid).hide();

                }
            });
        };


        $scope.getuserCount(2, "newUsersAffi", "pendingUsers", "<?php echo AFFILIATE ?>");
        $scope.getuserCount(2, "newUsersAdver", "pendingAdverUsers", "<?php echo ADVERTISER ?>");
    });
</script>