<div class="row" id="AllCreativerContainer" ng-controller="creative_controller">
    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading"><h3 class="panel-title">
                    All Creatives </h3></div>
            <div class="panel-body">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 m-t-10 m-b-10 searchCustom">
                        <!--                        search-->
                        <form id="searchForm" class="form-inline" role="form" ng-submit="searchByForm()" >

                            <div class="form-group m-l-10">
                                <label class="" for="exampleInputEmail2">Name</label>
                                <input type="text" name="creative_name" class="form-control input-sm" id="" ng-model="creativeaign_name" ng-model="searchText" placeholder="">

                            </div>


                            <button type="submit" class="btn btn-success waves-effect waves-light m-l-10"><span class="fa fa-search">   </span> </button>

                        </form>
                        <!--end search-->
                    </div>

                    <!-- sample modal content -->
                    <div id="LinkToOffer" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content col-md-12">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="myModalLabel">Select Offers</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="UpdateLinkTooffer">

                                        <div class="col-md-12">
                                            <div class="form-group ">
                                                <label class="col-md-4 control-label" style="font-weight: normal">Creative File Name</label>
                                                <div class="col-md-8">
                                                    <h4 id="creativeName"></h4>
                                                </div>
                                            </div>
                                        </div>   


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label" style="font-weight: normal">Offer</label>
                                                <div class="col-md-8">
                                                    <?php echo form_multiselect("campaign_id[]", $Camapign, '', "class='form-control campaign_id_select2 ' id='offerSelector'") ?>  
                                                    <input type="hidden" name="creative_id" id="creativeID"/> 
                                                </div>
                                            </div>
                                        </div>  

                                    </form>


                                </div>
                                <div class="modal-footer m-t-30 col-md-12">
                                    <button type="button" ng-click="LinkToOffer()" class="btn btn-primary waves-effect waves-light">Save changes</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive table  table-hover">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th >Name</th>
                                        <th >Link</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr ng-repeat="creative in all_creatives" id="tr{{creative.creative_id}}">
                                        <td>
                                            <span titile='Active' ng-if="creative.status == 1" class='fa fa-circle text-success'></span>
                                            <span titile='De-Activated' ng-if="creative.status == 0" class='fa fa-circle text-danger'></span>

                                            {{creative.creative_id}}</td>

                                        <td>   {{creative.creative_name}}</td>

                                        <td>

                                            <a href="{{creative.creative_link}}" target="_blank" ><span class="fa fa-download"></span></a>

                                        </td>
                                        <td>
                                            <button ng-click="select_offers(creative.creative_id, creative.creative_name)" class="btn m-b-5 btn-xs btn-primary waves-effect waves-light" data-toggle="modal" data-target="#LinkToOffer">Link To</button>

                                            <button type="button" ng-click="delete_creative(creative.creative_id)" class="btn btn-danger waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-trash"></span></button>

                                        </td>

                                    </tr>

                                </tbody>
                            </table>

                            <div class="text-danger text-center" ng-if="all_creatives == ''">
                                <h3 class='text-danger'>There is no data available ....</h3>
                            </div>
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
            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col -->
</div>

<!-- Modal-Effect -->
<script src="<?php echo ASSETS ?>plugins/modal-effect/js/classie.js"></script>
<script src="<?php echo ASSETS ?>plugins/modal-effect/js/modalEffects.js"></script>

<script>
                                    //var creativeaignManager = angular.module("creativeaign_app", ['ui.bootstrap']);
                                    //creative_controller
                                    var creative_controller = viral_pro.controller("creative_controller", function ($scope) {

                                        $scope.all_creatives = {};
                                        $scope.searchBtn = "";
                                        $scope.FormAction = "<?php echo SITEURL . "admin/creative/getCreative" ?>";

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

                                        $scope.select_offers = function (creative_id, name)
                                        {


                                            $.ajax({
                                                url: "<?php echo SITEURL . "admin/creative/getCreativeOffers" ?>",
                                                type: 'POST',
                                                data: "creative_id=" + creative_id,
                                                dataType: 'json',
                                                success: function (data, textStatus, jqXHR) {
                                                    if (data['success'])
                                                    {
                                                        $(".campaign_id_select2").val(null).trigger('change');
                                                        $.each(data['result'],function(index,item){
                                                            console.log(item);
                                                        var newOption = new Option(item.text, item.id, true, true);
                                                        $(".campaign_id_select2").append(newOption).trigger('change');
                                                        
                                                        });
                                                        
                                                        $("#creativeID").val(creative_id);
                                                        $("#creativeName").html(name);
                                                    }
                                                    //$scope.all_creatives = data['creative'];
                                                    //$scope.searchBtn = "";
                                                    //$scope.$apply();
                                                }
                                            });
                                        };


                                        $scope.LinkToOffer = function () {

                                            $scope.searchBtn = "";
                                            var form = $("#UpdateLinkTooffer").serialize();
                                            $.ajax({
                                                url: "<?php echo SITEURL . "admin/creative/updateLinkToOffer" ?>",
                                                type: 'POST',
                                                data: form,
                                                dataType: 'json',
                                                success: function (data, textStatus, jqXHR) {

                                                    if (data['success'])
                                                    {
                                                        $.Notification.autoHideNotify('success',
                                                                'botton right',
                                                                data['msg'],
                                                                '');

                                                        //$("#catForm")[0].reset();
                                                    } else {
                                                        $.Notification.autoHideNotify('error',
                                                                'botton right',
                                                                data['msg'],
                                                                '');
                                                    }
                                                }
                                            });
                                        };


                                        $scope.search = function () {
                                            $scope.searchBtn = "";
                                            var form = $("#searchForm").serialize();
                                            $.ajax({
                                                url: $scope.FormAction + "?page=" + $scope.currentPage,
                                                type: 'POST',
                                                data: form,
                                                dataType: 'json',
                                                success: function (data, textStatus, jqXHR) {
                                                    $scope.all_creatives = data['creative'];
                                                    $scope.searchBtn = "";
                                                    $scope.$apply();
                                                }
                                            });
                                        };
                                        $scope.getCreative = function () {

                                            $.ajax({
                                                url: $scope.FormAction,
                                                type: 'POST',
                                                data: 'user=1',
                                                dataType: 'json',
                                                success: function (data, textStatus, jqXHR) {
                                                    $scope.all_creatives = data['creative'];
                                                    $scope.$apply();
                                                }
                                            });
                                        };



                                        //delete creativeaing


                                        $scope.delete_creative = function (creative_id)
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
                                                                url: "<?php echo SITEURL . "admin/creative/deleteCreative" ?>",
                                                                type: 'POST',
                                                                data: "creative_id=" + creative_id,
                                                                dataType: 'json',
                                                                success: function (data, textStatus, jqXHR) {
                                                                    if (data['success'])
                                                                    {
                                                                        $.Notification.autoHideNotify('success',
                                                                                'botton right',
                                                                                data['msg'],
                                                                                '');
                                                                        $("#tr" + creative_id).remove();
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



//        $scope.getCreative();
                                    });</script>


<script>



</script>