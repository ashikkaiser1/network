<?php
if (isset($campaign['campaign_id'])) {
    ?>



    <link href="<?php echo ASSETS ?>vendor/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css"/>


    <div class="col-sm-12"  ng-controller="creative_controller" id="AllCreativerContainer">
        <div class="panel panel-default" >
            <div class="panel-heading">
                <h3 class="panel-title">
                    Offer Creative 
                    <div class="pull-right">
                        <ul class="bulkActions">
                            <li><a href="void:javascript" id="ShowDropZone" class=" btn btn-info waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-plus"></span> Add Creative</a></li>
                        </ul>
                    </div>
                </h3></div>
            <div class="panel-body">
                <div class="row">

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">

                            <div class="form-group m-b-10 m-b-10">
                                <div class="panel-body">
                                    <div class="col-md-12 hidden" id="dropZoneUploader">
                                        <form id="FileUploader" action="<?php echo SITEURL . "admin/creative/upload_creative" ?>" class="dropzone" >
                                            <div class="fallback">
                                                <input name="file" type="file" multiple='' />

                                            </div>
                                            <input type="hidden" name="campaign_id[]" value="<?php echo $campaign_id ?>"/>

                                        </form>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="table-responsive table  table-hover">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>File Name</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="creative  in all_creatives" id="tr{{creative.creative_id}}">
                                                        <td>{{creative.creative_id}}</td>
                                                        <td>
                                                            <a  href="{{creative.creative_link}}">
                                                                <span class="creativeName">{{creative.creative_name}}</span>
                                                                <span class="fa fa-2x text-success fa-download pull-right"></span>
                                                            </a>

                                                        </td>
                                                        <td><button class="btn btn-xs btn-danger" ng-click="delete_creative(creative.creative_id)"><span class="fa fa-remove"></span></button></td>
                                                    </tr>
                                                </tbody>

                                               
                                            </table>
                                             <div ng-if="all_creatives == ''" style="text-align: center; font-size: x-large;">
                                                    No Data Exist!!
                                                </div>

                                        </div>

                                    </div>

                                </div>

                            </div>


                        </div> <!-- col -->
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
    //    var myDropzone = new Dropzone(".dropzone", { url: ""});
        Dropzone.options.FileUploader = {
            init: function () {
                this.on("success", function (file) {

                    $.Notification.autoHideNotify('success',
                            'botton right',
                            "Creative Uploaded",
                            '');
                    angular.element(document.getElementById('AllCreativerContainer')).scope().getCreative();

                });
            }
        };

        $("#ShowDropZone").click(function () {

            $("#dropZoneUploader").toggleClass("hidden");

        });
    </script>

    <script>
        //var creativeaignManager = angular.module("creativeaign_app", ['ui.bootstrap']);
        //creative_controller
        var creative_controller = viral_pro.controller("creative_controller", function ($scope) {

            $scope.all_creatives = <?php echo json_encode($OfferCreative) ?>;
            $scope.FormAction = "<?php echo SITEURL . "admin/creative/getOfferCreative" ?>";
            $scope.currentPage = 1;

            $scope.getCreative = function () {

                $.ajax({
                    url: $scope.FormAction,
                    type: 'POST',
                    data: 'campaign_id=' +<?php echo $campaign_id ?>,
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

    <?php
}?>