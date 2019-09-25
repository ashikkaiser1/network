<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default"  ng-controller="domainAdd">
            <div class="panel-heading"><h3 class="panel-title">Update Tracking Domain</h3></div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" id="domainForm" ng-submit="CreateDomain()">                                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Name</label>
                        <div class="col-md-4">
                            <input type="hidden" class="form-control" value="<?php echo isset($domain['domain_id']) ? $domain['domain_id'] : '' ?>" name="domain_id">
                            <input type="text" class="form-control" value="<?php echo isset($domain['domain_name']) ? $domain['domain_name'] : '' ?>" name="domain_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Url</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" value="<?php echo isset($domain['domain_url']) ? $domain['domain_url'] : '' ?>" name="domain_url">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Status</label>
                        <div class="col-md-4">
                            <select name="status" class="form-control">
                                <option <?php echo $domain['status'] == 1 ? "selected='true'" : '' ?> value="1">Active</option>
                                <option <?php echo $domain['status'] == 0 ? "selected='true'" : '' ?> value="0">De-Active</option>
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
  //  var domain = angular.module("domain", []);
    viral_pro.controller("domainAdd", function ($scope) {

        $scope.message = "";
        $scope.saveBtn = "Save";


        $scope.action = "<?php echo SITEURL . "admin/domain/UpdateDomain" ?>";



        $scope.CreateDomain = function () {
            $scope.saveBtn = "Updating..";
            //var form = new FormData($("#domainForm"));
            $.ajax({
                url: $scope.action,
                type: 'POST',
                dataType: 'json',
                data: $("#domainForm").serialize(),
                success: function (data, textStatus, jqXHR) {

                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
                        
                        window.location = "<?php echo SITEURL . "admin/domain/CreateDomain" ?>";
                        // $("#domainForm")[0].reset();
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
if (isset($allDomain))
    echo $allDomain;
?>