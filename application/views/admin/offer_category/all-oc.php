<div class="row" id="OfferCatController" ng-controller="OfferCatController">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class=" panel-title">
                    All Offer Category / Verticals 
                </h3>
            </div>  
            <div class="panel-body">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 m-t-10 m-b-10 searchCustom">
                        <!--                        search-->
                        <form id="searchOffersCat" class="form-inline" role="form" ng-submit="searchByForm()" >

                            <div class="form-group m-l-10">
                                <label class="" for="exampleInputEmail2">Title</label>
                                <input type="text" name="title" class="form-control input-sm" id=""  placeholder="">
                            </div>
                            <div class="form-group m-l-10">
                                <label class="" for="">Status</label>
                                <?php echo form_dropdown("status", array("1" => "Active", "0" => "IN-Active"), '', "class='form-control'") ?>
                            </div>
                            <button type="submit" class="btn btn-success waves-effect waves-light m-l-10"><span class="fa fa-search"></span></button>
                        </form>
                        <!--end search-->
                    </div>


                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    ?>
                                    <tr ng-repeat="ip in all_offer_cat" id="tr{{ip.offer_cat_id}}"  >
                                        <td>{{ $index + 1}}</td>
                                        <td>
                                            {{ip.title}}
                                        </td>
                                        <td>
                                            <span ng-if="ip.status == 1" class="text-success" >Active</span>
                                            <span ng-if="ip.status == 0" class="text-success" >In-Active</span>
                                        </td>
                                        <td>
                                            <a href="<?php echo SITEURL . "admin/offer_category/Updateoffer_category/" ?>{{ip.offer_cat_id}}" type="button" class="btn btn-primary waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span></a>
                                            <button type="button" ng-click="delete_offer_category(ip.offer_cat_id)" class="btn btn-danger waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-trash"></span></button>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                         <div class="text-danger text-center" ng-if="all_offer_cat == ''">
                            <h3 class='text-danger'>There is no data available ....</h3>
                        </div>

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
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    //var ipManager = angular.module("ip_app", ['ui.bootstrap']);
    //OfferCatController
    var OfferCatController = viral_pro.controller("OfferCatController", function ($scope) {

        $scope.all_offer_cat = {};
        $scope.searchBtn = "";
        $scope.FormAction = "<?php echo SITEURL . "admin/offer_category/show_offer_cat" ?>";


        $scope.currentPage = 1;
        $scope.numPerPage = 10;

        $scope.searchByForm = function () {
            $scope.currentPage = 1;
            $scope.search();
        };

        $scope.$watch('currentPage + numPerPage', function () {

            console.log($scope.currentPage + $scope.numPerPage);


            $scope.search();

        });

        $scope.delete_offer_category = function (offer_cat_id)
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
            },
            function (isConfirm) {
                if (isConfirm)
                {
                    $.ajax({
                        url: "<?php echo SITEURL . "admin/offer_category/deleteoffer_category" ?>",
                        type: 'POST',
                        data: "offer_cat_id=" + offer_cat_id,
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            if (data['success'])
                            {
                                $.Notification.autoHideNotify('success',
                                        'botton right',
                                        data['msg'],
                                        '');
                                $("#tr" + offer_cat_id).remove();
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

        $scope.search = function () {
            $scope.searchBtn = "";
            var form = $("#searchOffersCat").serialize();
            $.ajax({
                url: $scope.FormAction + "?page=" + $scope.currentPage,
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_offer_cat = data['offer_category'];
                    if (data['success'])
                    {
//                        $scope.all_offer_cat = data['ip_pool'];
                        $scope.searchBtn = "";
                    }

                    $scope.$apply();
                }
            });
        };


    });
</script>