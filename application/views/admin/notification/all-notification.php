<div class="row"  ng-controller="all_noti_controller">

    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading"><h3 class="panel-title">
                    <a href="<?php echo SITEURL . "admin/notification/CreateNoti" ?>" class=" btn btn-info waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-plus"></span> New </a>
                    All Notification</h3></div>
            <div class="panel-body">
                <div class="row">




                    <div class="col-md-12 col-sm-12 col-xs-12 ">



                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>

                                    <th>Title</th>
                                    <th style="width: 60%">Desc.</th>

                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="noti in all_noti" id="noti{{noti.noti_id}}"> 
                                    <td>{{noti.noti_id}}</td>


                                    <td>

                                        <a class="text-dark" href="{{noti.link}}" target="_blank">
                                            <span ng-if="noti.status == 1" class="fa fa-circle text-success"></span>
                                            <span ng-if="noti.status == 0" class="fa fa-circle text-danger"></span>
                                            {{noti.title}}</a></td>
                                    <td>
                                        <div  ng-bind-html="reder_html(noti.description)"> 
                                        </div>

                                    </td>
                                    <td>
<!--                                        <button  class=" btn btn-info waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-eye"></span></button>-->
                                        <a title="Edit Notification"  href="<?php echo SITEURL . "admin/notification/update_notification/" ?>{{noti.noti_id}}" class=" btn btn-purple waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span></a>
                                        <button title="Delete Notofication" ng-click="delete_noti(noti.noti_id)" class=" btn btn-danger waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-remove"></span></button>
                                    </td>

                                </tr>
                            </tbody>

                        </table>
                        
                        <div class="text-danger text-center ng-scope" ng-if="all_noti == ''">
                            <h3 class="text-danger">There is no data available ....</h3>
                        </div>







                        <!--                        <div ng-repeat="noti in all_noti" class="col-md-4 col-sm-4 col-xs-4" id="noti{{noti.noti_id}}">
                                                    <div class="noti" >
                                                        <div class="actionBts">
                                                            <span class="fa fa-circle text-success"></span>
                                                            <a  href="<?php echo SITEURL . "admin/noti/UpdatePost/" ?>{{noti.noti_id}}" class=" btn btn-purple waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-edit"></span></a>
                                                            <button ng-click="delete_noti(noti.noti_id)" class=" btn btn-danger waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-remove"></span></button>
                                                        </div>
                                                        <div class="adonData">
                                                            <div class="views"><span class="fa fa-eye"></span> 1.2k Views</div>
                                                        </div>
                                                        <a href="{{noti.url_slug}}" target="_blank"> 
                                                            
                                                            <img ng-src="{{noti.image}}"   ></a>
                                                        <h2 class="title">{{noti.title}}</h2>
                                                        <p class="description">{{noti.meta}}</p>
                        
                                                    </div>
                        
                                                </div>-->

                        <div></div>
                        <!--<div ng-init="search()"></div>-->
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-6">
                            <pagination 
                                ng-model="currentPage"
                                total-items="1000"
                                max-size="5"  
                                boundary-links="true">
                            </pagination>
                        </div>
                        <div class="col-md-3">

                        </div>



                    </div>
                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col -->
    </div>
</div>
<script>

    //var notiManager = angular.module("noti_app", ['ui.bootstrap']);
    //all_noti_controller
    var all_noti_controller = viral_pro.controller("all_noti_controller", function ($scope, $sce) {
        $scope.currentPage = 1;
        $scope.numPerPage = 10;
        $scope.all_noti = {};
        $scope.searchBtn = "SEARCH";
        $scope.FormAction = "<?php echo SITEURL . "admin/notification/allNotification" ?>";
        $scope.search = function () {
            $scope.searchBtn = "SEARCHING...";
            var form = $("#searchForm").serialize();
            $.ajax({
                url: $scope.FormAction+"?page="+ $scope.currentPage,
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_noti = data;
                    $scope.searchBtn = "SEARCH";
                    $scope.$apply();
                }
            });
        };
        $scope.$watch('currentPage + numPerPage', function () {

            $scope.search();
        });
        
        $scope.searchbyForm=function(){
            
            $scope.currentPage=1;
            $scope.search();
        };

        $scope.reder_html = function (html) {


            return $sce.trustAsHtml(html);

        };

        $scope.delete_noti = function (noti_id)
        {
            swal({
                title: "Are you sure?",
                text: "Your will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn btn-sm btn-danger waves-effect waves-light",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function (isconfirm) {
                if (isconfirm)
                {
                    $.ajax({
                        url: "<?php echo SITEURL . "admin/notification/delete_notification" ?>",
                        type: 'POST',
                        data: "noti_id=" + noti_id,
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            if (data['success'])
                            {
                                $.Notification.autoHideNotify('success',
                                        'botton right',
                                        data['msg'],
                                        '');
                                $("#noti" + noti_id).remove();
                                //$("#catForm")[0].reset();
                            } else {
                                $.Notification.autoHideNotify('error',
                                        'botton right',
                                        data['msg'],
                                        '');
                            }

                        }

                    });
                }
            });



        };
        $scope.getPost = function () {

            $.ajax({
                url: $scope.FormAction,
                type: 'POST',
                data: 'noti=1',
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_noti = data;
                    $scope.$apply();
                }
            });
        };
        $scope.getPost();
    });





</script>