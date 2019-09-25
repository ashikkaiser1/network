<div class="row"  ng-controller="post_controller">

    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading"><h3 class="panel-title">
                    <a href="<?php echo SITEURL . "admin/post/CreatePost" ?>" class=" btn btn-info waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-plus"></span> New </a>
                    All Post</h3></div>
            <div class="panel-body">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 m-t-10 m-b-10 searchCustom">
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

                            <div class="form-group m-l-10">
                                <label class="" for="">Status</label>
                                <?php echo form_dropdown("status", array("" => "All", "1" => "Active", "0" => "De-Activated"), '', "class='form-control'") ?>
                            </div>

                            <button type="submit" class="btn btn-success waves-effect waves-light m-l-10"><span class="fa fa-search">   </span> {{searchBtn}}</button>
                        </form>
                        <!--end search-->
                    </div>


                    <div class="col-md-12 col-sm-12 col-xs-12 ">



                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th style="width: 60%">Title</th>
<!--                                    <th>Views</th>-->
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="post in all_post" id="post{{post.post_id}}"> 
                                    <td>
                                        <span ng-if="post.status == 1" class="fa fa-circle text-success"></span>
                                        <span ng-if="post.status == 0" class="fa fa-circle text-danger"></span>
                                    </td>
                                    <td><a href="{{post.url_slug}}" target="_blank"> 
                                            <img style="width: 40px" ng-src="{{post.image}}"/>
                                        </a></td>
                                    <td><a class="text-dark" href="{{post.url_slug}}" target="_blank"> {{post.title}}</a></td>
<!--                                    <td>1.23k</td>-->
                                    <td>
<!--                                        <button  class=" btn btn-info waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-eye"></span></button>-->
                                        <a  href="<?php echo SITEURL . "admin/post/UpdatePost/" ?>{{post.post_id}}" class=" btn btn-purple waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span></a>
                                        <button ng-click="delete_post(post.post_id)" class=" btn btn-danger waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-remove"></span></button>
                                    </td>

                                </tr>
                            </tbody>

                        </table>







                        <!--                        <div ng-repeat="post in all_post" class="col-md-4 col-sm-4 col-xs-4" id="post{{post.post_id}}">
                                                    <div class="post" >
                                                        <div class="actionBts">
                                                            <span class="fa fa-circle text-success"></span>
                                                            <a  href="<?php echo SITEURL . "admin/post/UpdatePost/" ?>{{post.post_id}}" class=" btn btn-purple waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-edit"></span></a>
                                                            <button ng-click="delete_post(post.post_id)" class=" btn btn-danger waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-remove"></span></button>
                                                        </div>
                                                        <div class="adonData">
                                                            <div class="views"><span class="fa fa-eye"></span> 1.2k Views</div>
                                                        </div>
                                                        <a href="{{post.url_slug}}" target="_blank"> 
                                                            
                                                            <img ng-src="{{post.image}}"   ></a>
                                                        <h2 class="title">{{post.title}}</h2>
                                                        <p class="description">{{post.meta}}</p>
                        
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

    ///var postManager = angular.module("post_app", ['ui.bootstrap']);
    //post_controller
    var post_controller = viral_pro.controller("post_controller", function ($scope) {
        $scope.currentPage = 1;
        $scope.numPerPage = 10;
        $scope.all_post = {};
        $scope.searchBtn = "SEARCH";
        $scope.FormAction = "<?php echo SITEURL . "admin/post/show_post" ?>";

        $scope.searchByForm = function () {
            $scope.currentPage = 1;
            $scope.search();
        };

        $scope.search = function () {
            $scope.searchBtn = "SEARCHING...";
            var form = $("#searchForm").serialize();
            $.ajax({
                url: $scope.FormAction + "?page=" + $scope.currentPage,
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_post = data;
                    $scope.searchBtn = "SEARCH";
                    $scope.$apply();
                }
            });
        };
        $scope.$watch('currentPage + numPerPage', function () {
            console.log($scope.currentPage + $scope.numPerPage);
            $scope.search();
        });
        $scope.delete_post = function (post_id)
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
                        url: "<?php echo SITEURL . "admin/post/deletepost" ?>",
                        type: 'POST',
                        data: "post_id=" + post_id,
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            if (data['success'])
                            {
                                $.Notification.autoHideNotify('success',
                                        'botton right',
                                        data['msg'],
                                        '');
                                $("#post" + post_id).remove();
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
                data: 'post=1',
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_post = data;
                    $scope.$apply();
                }
            });
        };
        $scope.getPost();
    });





</script>