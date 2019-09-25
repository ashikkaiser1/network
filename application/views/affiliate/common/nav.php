<aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- User profile -->
                <div class="user-profile">
                    <!-- User profile image -->
                    <div class="profile-img"> <img src="<?php echo ASSETS; ?>images/users/avatar-1.jpg" alt="user" />
                        <!-- this is blinking heartbit-->
                        <div class="notify setpos"> <span class="heartbit Black">Online</span> <span class="point"></span> </div>
                    </div>
                    <!-- User profile text-->
                    <div class="profile-text">
                        <h5><?php echo UserTitle ?></h5>
                         <a href="javascript:void(0);" class="btn btn-rounded btn-info btn-sm"><?php echo USERTYPE; ?></a>
                        
                        
                    </div>
                </div>

 <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
<li><a class="has-arrow waves-effect waves" href="<?php echo SITEURL ?>affiliate/dashboard" ><i class="has-arrow waves-effect waves"></i><span class="hide-menu">Dashboard </span></a> </li>
<li><a class="has-arrow waves-effect waves-dark" href="<?php echo SITEURL ?>affiliate/campaign/offer_gen" ><i class="mdi mdi-gauge"></i><span class="hide-menu">Offers </span></a> </li>
<li><a class="has-arrow waves-effect waves-dark" href="<?php echo SITEURL ?>affiliate/payment/my_payments" ><i class="mdi mdi-gauge"></i><span class="hide-menu">Payment </span></a> </li>
<li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Report <span class="label label-rouded label-themecolor pull-right">4</span></span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo SITEURL ?>affiliate/c_report/advance_report?repType=daily_report">Performance </a></li>
                                <li><a href="<?php echo SITEURL ?>affiliate/c_report/advance_report?repType=offers_report">Campaigns</a></li>
                                <li><a href="<?php echo SITEURL . "affiliate/c_report/advance_report?repType=conversion_report" ?>">Conversion</a></li>
                                <li><a href="<?php echo SITEURL . "affiliate/c_report/advance_report?repType=detail_report" ?>">Advance Reporting</a></li>
                            </ul>
                        </li>
        
<li><a class="has-arrow waves-effect waves-dark" href="<?php echo SITEURL . "affiliate/dashboard/updates" ?>" ><i class="mdi mdi-gauge"></i><span class="hide-menu">Notification </span></a> </li>

<li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Account <span class="label label-rouded label-themecolor pull-right">4</span></span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo SITEURL ?>affiliate/setting/my_profile" ?>My Profile</a></li>
                                <li><a href="<?php echo SITEURL ?>affiliate/setting/my_payment" ?>My Payment Profile</a></li>
                                <li><a href="<?php echo SITEURL ?>affiliate/setting?section=1" ?>Setting</a></li>
                            </ul>
                        </li>          
               
         
       
             
                


</ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->


              
          

<script>

    viral_pro.controller("aff_manager", function ($scope) {

        $scope.aff_info = {};

        $scope.get_affmanager_info = function () {
            $.ajax({
                url: "<?php echo SITEURL ?>affiliate/aff_manager/my_aff_manager/",
                type: 'POST',
                data: "show=1",
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {

                    $scope.aff_info = data['acc_manager'];
                    $scope.$apply();
                }
            });
        };

        $scope.get_affmanager_info();


    });

</script>