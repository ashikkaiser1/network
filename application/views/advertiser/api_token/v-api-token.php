<div class="row"  ng-controller="genapitoken">

    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading"><h3 class="panel-title">
                    API TOKEN </h3></div>
            <div class="panel-body">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 ">

                        <form id="genMainLink"  class="form-horizontal"  ng-submit="save()">
                            <div class="form-group">
                                <?php
                                if (isset($tokenInfo) && !empty($tokenInfo)) {
                                    ?>
                                    <label class="col-md-2 control-label">Token Status : </label>

                                    <div class="col-md-7">
                                        <h5> <?php
                                            if ($tokenInfo['status'] == 1) {
                                                echo "<span class='text text-success'>Active</span>";
                                            }
                                            if ($tokenInfo['status'] == 0) {
                                                echo "<span class='text text-danger'>In-Active</span>";
                                            }
                                            if ($tokenInfo['status'] == 2) {
                                                echo "<span class='text text-danger'>Pending</span>";
                                            }
                                            if ($tokenInfo['status'] == 3) {
                                                echo "<span class='text text-danger'>Rejected</span>";
                                            }
                                            ?></h5>
                                    </div>
                                    <?php
                                }
                                ?>

                            </div>
                            <div class="form-group">



                                <label class="col-md-2 control-label">Token : </label>
                                <div class="col-md-7">
                                    <h5>{{token}}</h5>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-pink waves-effect waves-light m-b-5">Generate Token</button>
                                </div>
                            </div>

                        </form>
                        <!--

         
        </div> <!-- panel -->
                    </div> <!-- col -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    // var genUrlManager = angular.module("gen_url", ['ui.bootstrap']);
    //genapitoken
    var genapitoken = viral_pro.controller("genapitoken", function ($scope) {

        $scope.token = "<?php echo $token ?>";

        $scope.save = function () {
            $.ajax({
                url: "<?php echo SITEURL . "advertiser/api_token/generateToken" ?>",
                type: 'POST',
                data: "tokengen=1",
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.token = data['token'];
                    $scope.$apply();
                }
            });




        };
    });





</script>