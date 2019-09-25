<div class="left side-menu">
     <h1 class="topLogo hidden-sm hidden-sm hidden-xs"><?php echo SITENAME ?></h1>
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
                        <li><a href="<?php echo SITEURL . "advertiser/setting" ?>"><i class="md md-settings"></i> Settings</a></li>
                        <li><a href="javascript:void(0)"><i class="md md-lock"></i> Lock screen</a></li>
                        <li><a href="<?php echo SITEURL . "account/account/logout" ?>"><i class="md md-settings-power"></i> Logout</a></li>
                    </ul>
                </div>

                <p class="text-muted m-0 text-capitalize"><?php echo USERTYPE; ?></p>
            </div>
        </div>
        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>
                <li>
                    <a href="<?php echo SITEURL ?>advertiser/dashboard/dashboard" class="waves-effect">
                        <img class="aff_iocns" src="<?php echo ASSETS ?>affiliate/icons/301-computer-1.png" alt=""/>
                        <span>Dashboard </span></a>
                </li>


                <!--                <li class="">
                                    <a href="<?php echo SITEURL ?>advertiser/payment/payment" class="waves-effect"><i class="fa fa-usd"></i><span>Payment </span></a>
                
                                </li>-->
                <!--                <li class="">
                                    <a href="<?php echo SITEURL ?>advertiser/gencsv/gencsv" class="waves-effect"><i class="fa fa-file"></i><span> Gen csv</span></a>
                
                                </li>-->



                <li class="">
                    <a href="<?php echo SITEURL . "advertiser/campaign/showOffers" ?>" class="waves-effect">
                        <img class="aff_iocns" src="<?php echo ASSETS ?>affiliate/icons/301-list.png" alt=""/>MY Offer</a>
                    <!--                    <ul class="list-unstyled">
                    
                                            <li class="">
                                                <a href="<?php echo SITEURL ?>advertiser/mylink/show_my_offer" class="waves-effect"><i class="fa fa"></i><span>Live Offers </span></a>
                    
                                            </li>
                                            <li class="">
                                                <a href="<?php echo SITEURL ?>advertiser/campaign/showOffers" class="waves-effect"><i class="fa fa"></i><span>Browse Offers </span></a>
                    
                                            </li>
                    
                    
                    
                                        </ul>-->
                </li>
                
                <li class="">
                    <a href="<?php echo SITEURL . "advertiser/payment/my_payments" ?>" class="waves-effect">
                        <img class="aff_iocns" src="<?php echo ASSETS ?>affiliate/icons/301-money-1.png" alt=""/>Payments</a>
                  
                </li>
                <!--                <li class="">
                                    <a href="<?php echo SITEURL ?>advertiser/campaign/campaign" class="waves-effect"><i class="fa fa-adn"></i><span> Campaign </span></a>
                
                                </li>-->



                <!--                <li class="">
                                    <a href="<?php echo SITEURL ?>advertiser/report/report" class="waves-effect"><i class="fa fa-bar-chart"></i><span> Report </span></a>
                                </li> -->
                <li class="has_sub">
                    <a href="#" class="waves-effect">
                        <img class="aff_iocns" src="<?php echo ASSETS ?>affiliate/icons/301-browser-2.png" alt=""/>Report </span> <span class="pull-right"><i class="md md-add"></i></span>
                    </a>

                    <ul class="list-unstyled">

                        <li class="">
                            <a href="<?php echo SITEURL ?>advertiser/c_report/advance_report?repType=daily_report" class="waves-effect"><span>Performance</span></a>
                        </li>
                        <li class="">
                            <a href="<?php echo SITEURL ?>advertiser/c_report/advance_report?repType=offers_report" class="waves-effect"><span>Campaigns</span></a>
                        </li>
                        <li class="">
                            <a href="<?php echo SITEURL . "advertiser/c_report/advance_report?repType=conversion_report" ?>" class="waves-effect"><span>Conversion</span></a>
                        </li>
<!--                        <li class="">
                            <a href="#" class="waves-effect"><span>Earnings</span></a>
                        </li>-->

                    </ul>
                </li>  


                <!--                advertiser/report/advance_report?-->
                <li class="">
                    <a href="<?php echo SITEURL . "advertiser/dashboard/updates" ?>" class="waves-effect">
                        <img class="aff_iocns" src="<?php echo ASSETS ?>affiliate/icons/megaphone.png" alt=""/>Notification </span></a>


                </li> 
                <!--                <li class="">
                                    <a href="<?php echo SITEURL ?>advertiser/offer_postback" class="waves-effect"><i class="fa fa-link"></i><span>Gen. Publisher Link </span></a>
                                </li>-->


                <li class="has_sub">
                    <a href="#" class="waves-effect">
                        <img class="aff_iocns" src="<?php echo ASSETS ?>affiliate/icons/301-think-1.png" alt=""/>Account </span><span class="pull-right"><i class="md md-add"></i></span></a>
                    <ul class="list-unstyled">

                        <li class="">
                            <a href="<?php echo SITEURL ?>advertiser/api_token/" class="waves-effect">Setup API</span></a>
                        </li>
<!--                        <li class="">
                            <a href="<?php echo SITEURL ?>advertiser/setting/setmy_globalpostback" class="waves-effect"><span>Setup Postback </span></a>
                        </li>-->
                                                <li class="">
                            <a href="<?php echo SITEURL ?>advertiser/faq/postbackinfo" class="waves-effect"><span>Postback Info </span></a>
                        </li>
                        <li class="">
                            <a href="<?php echo SITEURL ?>advertiser/setting/my_profile" class="waves-effect"><span>My Profile</span></a>
                        </li>
                        <li class="">
                            <a href="<?php echo SITEURL ?>advertiser/setting/my_payment" class="waves-effect"><span>My Payment Profile</span></a>
                        </li>
                        <li class="">
                            <a href="<?php echo SITEURL ?>advertiser/setting?section=1" class="waves-effect"><span>Setting</span></a>
                        </li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="#" class="waves-effect">
                        <img class="aff_iocns" src="<?php echo ASSETS ?>affiliate/icons/301-contract.png" alt=""/>Resources </span><span class="pull-right"><i class="md md-add"></i></span></a>
                    <ul class="list-unstyled">

                        <li class="">
                            <a href="<?php echo SITEURL ?>advertiser/api_kit" class="waves-effect">API Kit</span></a>
                        </li>
                        <li class="">
                            <a href="<?php echo SITEURL ?>advertiser/faq" class="waves-effect"><span>FAQ</span></a>
                        </li>



                    </ul>
                </li>




                <!--
                                            <li>
                                                <a href="calendar.html" class="waves-effect"><i class="md md-event"></i><span> Calendar </span></a>
                                            </li>
                
                                            <li class="">
                                                <a href="#" class="waves-effect active"><i class="md md-palette"></i> <span> Elements </span> </a>
                                                <ul class="list-unstyled">
                                                    <li><a href="typography.html">Typography</a></li>
                                                    <li class="active"><a href="buttons.html">Buttons</a></li>
                                                    <li><a href="panels.html">Panels</a></li>
                                                    <li><a href="checkbox-radio.html">Checkboxs-Radios</a></li>
                                                    <li><a href="tabs-accordions.html">Tabs &amp; Accordions</a></li>
                                                    <li><a href="modals.html">Modals</a></li>
                                                    <li><a href="bootstrap-ui.html">BS Elements</a></li>
                                                    <li><a href="progressbars.html">Progress Bars</a></li>
                                                    <li><a href="notification.html">Notification</a></li>
                                                    <li><a href="sweet-alert.html">Sweet-Alert</a></li>
                                                </ul>
                                            </li>
                
                                            <li class="">
                                                <a href="#" class="waves-effect"><i class="md md-invert-colors-on"></i><span> Components </span></a>
                                                <ul class="list-unstyled">
                                                    <li><a href="grid.html">Grid</a></li>
                                                    <li><a href="portlets.html">Portlets</a></li>
                                                    <li><a href="widgets.html">Widgets</a></li>
                                                    <li><a href="nestable-list.html">Nesteble</a></li>
                                                    <li><a href="ui-sliders.html">Sliders </a></li>
                                                    <li><a href="gallery.html">Gallery </a></li>
                                                    <li><a href="pricing.html">Pricing Table </a></li>
                                                </ul>
                                            </li>
                
                                            <li class="">
                                                <a href="#" class="waves-effect"><i class="md md-redeem"></i> <span> Icons </span> </a>
                                                <ul class="list-unstyled">
                                                    <li><a href="material-icon.html">Material Design</a></li>
                                                    <li><a href="ion-icons.html">Ion Icons</a></li>
                                                    <li><a href="font-awesome.html">Font awesome</a></li>
                                                </ul>
                                            </li>
                                            
                                            <li class="">
                                                <a href="#" class="waves-effect"><i class="md md-now-widgets"></i><span> Forms </span></a>
                                                <ul class="list-unstyled">
                                                    <li><a href="form-elements.html">General Elements</a></li>
                                                    <li><a href="form-validation.html">Form Validation</a></li>
                                                    <li><a href="form-advanced.html">Advanced Form</a></li>
                                                    <li><a href="form-wizard.html">Form Wizard</a></li>
                                                    <li><a href="form-editor.html">WYSIWYG Editor</a></li>
                                                    <li><a href="code-editor.html">Code Editors</a></li>
                                                    <li><a href="form-uploads.html">Multiple File Upload</a></li>
                                                    <li><a href="form-xeditable.html">X-editable</a></li>
                                                </ul>
                                            </li>
                
                                            <li class="">
                                                <a href="#" class="waves-effect"><i class="md md-view-list"></i><span> Data Tables </span></a>
                                                <ul class="list-unstyled">
                                                    <li><a href="tables.html">Basic Tables</a></li>
                                                    <li><a href="table-datatable.html">Data Table</a></li>
                                                    <li><a href="tables-editable.html">Editable Table</a></li>
                                                    <li><a href="responsive-table.html">Responsive Table</a></li>
                                                </ul>
                                            </li>
                
                                            <li class="">
                                                <a href="#" class="waves-effect"><i class="md md-poll"></i><span> Charts </span></a>
                                                <ul class="list-unstyled">
                                                    <li><a href="morris-chart.html">Morris Chart</a></li>
                                                    <li><a href="chartjs.html">Chartjs</a></li>
                                                    <li><a href="flot-chart.html">Flot Chart</a></li>
                                                    <li><a href="peity-chart.html">Peity Charts</a></li>
                                                    <li><a href="charts-sparkline.html">Sparkline Charts</a></li>
                                                    <li><a href="chart-radial.html">Radial charts</a></li>
                                                    <li><a href="other-chart.html">Other Chart</a></li>
                                                </ul>
                                            </li>
                
                                            <li class="">
                                                <a href="#" class="waves-effect"><i class="md md-place"></i><span> Maps </span></a>
                                                <ul class="list-unstyled">
                                                    <li><a href="gmap.html"> Google Map</a></li>
                                                    <li><a href="vector-map.html"> Vector Map</a></li>
                                                </ul>
                                            </li>
                
                                            <li class="">
                                                <a href="#" class="waves-effect"><i class="md md-pages"></i><span> Pages </span></a>
                                                <ul class="list-unstyled">
                                                    <li><a href="profile.html">Profile</a></li>
                                                    <li><a href="timeline.html">Timeline</a></li>
                                                    <li><a href="invoice.html">Invoice</a></li>
                                                    <li><a href="email-template.html">Email template</a></li>
                                                    <li><a href="contact.html">Contact-list</a></li>
                                                    <li><a href="login.html">Login</a></li>
                                                    <li><a href="register.html">Register</a></li>
                                                    <li><a href="recoverpw.html">Recover Password</a></li>
                                                    <li><a href="lock-screen.html">Lock Screen</a></li>
                                                    <li><a href="blank.html">Blank Page</a></li>
                                                    <li><a href="maintenance.html">Maintenance</a></li>
                                                    <li><a href="coming-soon.html">Coming-soon</a></li>
                                                    <li><a href="404.html">404 Error</a></li>
                                                    <li><a href="404_alt.html">404 alt</a></li>
                                                    <li><a href="500.html">500 Error</a></li>
                                                </ul>
                                            </li>
                
                                            <li class="">
                                                <a href="javascript:void(0);" class="waves-effect"><i class="md md-share"></i><span>Multi Level </span></a>
                                                <ul>
                                                    <li class="">
                                                        <a href="javascript:void(0);" class="waves-effect"><span>Menu Level 1.1</span> </a>
                                                        <ul style="">
                                                            <li><a href="javascript:void(0);"><span>Menu Level 2.1</span></a></li>
                                                            <li><a href="javascript:void(0);"><span>Menu Level 2.2</span></a></li>
                                                            <li><a href="javascript:void(0);"><span>Menu Level 2.3</span></a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);"><span>Menu Level 1.2</span></a>
                                                    </li>
                                                </ul>
                                            </li>-->
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>