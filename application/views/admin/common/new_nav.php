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
                    <a href="#"  class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo UserTitle ?><span class="caret"></span></a>
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
                <li ng-repeat="menu in all_menus"  ng-class="menu.child == '' ? '' : 'has_sub'" >
                    <a ng-if="menu.link != '#'" href="<?php echo SITEURL ?>{{menu.link}}" class="waves-effect">
                        <i class="{{menu.icon}}"></i>
                        <span> {{menu.title}} </span>
                        <span ng-if="menu.child != ''" class="pull-right"><i class="md md-add"></i></span>
                    </a>

                    <a ng-if="menu.link == '#'" onclick="show_sub_menu(this,event)" href="#" class="waves-effect">
                        <i class="{{menu.icon}}"></i>
                        <span> {{menu.title}} </span>
                        <span ng-if="menu.child != ''" class="pull-right"><i class="md md-add"></i></span>
                    </a>


                    <ul class="list-unstyled" ng-if="menu.child != ''">
                        <li ng-repeat="child in menu.child">
                            <a href="<?php echo SITEURL ?>{{child.link}}" class="waves-effect">{{child.title}}
                                <span class="pull-right"></span></a>
                        </li>

                    </ul>
                </li>

            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<script>
    var sliderMenu = viral_pro.controller("sliderMenu", function ($scope) {

        $scope.all_menus = {};
        $scope.get_menus = function () {

            $.ajax({
                url: "<?php echo SITEURL . "admin/system/get_menu_access" ?>",
                type: 'POST',
                data: "data=1",
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_menus = data['menus'];

                    $.Sidemenu.$menuItem.on('click', $.Sidemenu.menuItemClick);

                   

                    $scope.$apply();
                }
            });
        };
        $scope.get_menus();

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
    
    
    
    function show_sub_menu(that,event){
        
        console.log("Lcicked menus");
       if(!$("#wrapper").hasClass("enlarged")){
        if($(that).parent().hasClass("has_sub")) {
          event.preventDefault();
        }   
        if(!$(that).hasClass("subdrop")) {
          // hide any open menus and remove all other classes
          $("ul",$(that).parents("ul:first")).slideUp(350);
          $("a",$(that).parents("ul:first")).removeClass("subdrop");
          $("#sidebar-menu .pull-right i").removeClass("md-remove").addClass("md-add");
          
          // open our new menu and add the open class
          $(that).next("ul").slideDown(350);
          $(that).addClass("subdrop");
          $(".pull-right i",$(that).parents(".has_sub:last")).removeClass("md-add").addClass("md-remove");
          $(".pull-right i",$(that).siblings("ul")).removeClass("md-remove").addClass("md-add");
        }else if($(that).hasClass("subdrop")) {
          $(that).removeClass("subdrop");
          $(that).next("ul").slideUp(350);
          $(".pull-right i",$(that).parent()).removeClass("md-remove").addClass("md-add");
        }
      } 
        
    }
    
    
    
</script>