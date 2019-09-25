<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default"  ng-controller="websiteAdd">
            <div class="panel-heading"><h3 class="panel-title">Update Website</h3></div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" id="websiteForm" ng-submit="CreateWebsite()">                                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Name</label>
                        <?php
//                        echo '<pre>';
//                        print_r($website);
                        ?>
                        <div class="col-md-10">
                            <input type="hidden" class="form-control" value="<?php echo isset($website['web_id']) ? $website['web_id'] :'' ?>" name="web_id">
                            <input type="text" class="form-control" value="<?php echo isset($website['domain_name']) ? $website['domain_name'] :'' ?>" name="domain_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Url</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" value="<?php echo isset($website['page_link']) ? $website['page_link'] :'' ?>" name="page_link">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Status</label>
                        
                        <div class="col-md-10">
                            <select name="status" class="form-control">
                                <option <?php echo $website['status']==1 ? "selected= 'true'" :'' ?> value="1">Active</option>
                                <option  <?php echo $website['status']==0 ? "selected= 'true'" :'' ?>  value="0">De-Active</option>
                            </select>
                        </div>
                       
                    </div>


                    <div class="form-group"> 
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-10">

                            <button type="submit" class="btn btn-purple waves-effect waves-light">{{saveBtn}}</button>
                            <!--<button type="Reset" class="btn btn-danger waves-effect waves-light">Cancel</button>-->
                        </div>
                    </div>

                </form>
            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col -->
</div>
<script>
  //  var website = angular.module("website", []);
    viral_pro.controller("websiteAdd", function ($scope) {

        $scope.message = "";
        $scope.saveBtn = "Save";


        $scope.action = "<?php echo SITEURL . "admin/website/UpdateWebsite" ?>";



        $scope.CreateWebsite = function () {
            $scope.saveBtn = "Updating..";
            //var form = new FormData($("#websiteForm"));
            $.ajax({
                url: $scope.action,
                type: 'POST',
                dataType: 'json',
                data: $("#websiteForm").serialize(),
                success: function (data, textStatus, jqXHR) {

                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');

                       // $("#websiteForm")[0].reset();
                    } else {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                    }
                    $scope.saveBtn = "Save";
                    $scope.$apply();
                }

            });



        };

    });
</script>
<?php
if (isset($allWebsite))
    echo $allWebsite;
?>