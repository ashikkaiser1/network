<div class="row hidden"  id="IpWhiteListFormDiv" >


    <div class="col-sm-12">

        <div class="panel-heading"><h3 class="panel-title"><?php //echo $title                 ?></h3></div>
        <div class="panel-body">
            <form class="form-horizontal" id="IpWhiteListForm" role="form" ng-submit="SetIpWhiteList()"> 
                <div class="form-group"> 
                    <div class="col-sm-8">
                        <button type="button" class="btn btn-purple waves-effect waves-light" ng-click="setSystemDefaultIP()"> Use Default IPs</button> 
                    </div>
                </div>   


                <input type="hidden" name="campaign_id" id="ip_campaign_id" value="<?php echo $campaign_id ?>">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class=" control-label">Ip Address</label>
                        <input type="text" class="form-control" placeholder="ipaddress" name="ip_address">
                    </div>
                </div>


                <div class="form-group"> 
                    <div class="col-sm-8">
                        <button type="submit" class="btn btn-purple waves-effect waves-light">{{saveBtn}}</button>
                        <button type="Reset" id="CancelIPWhiteList" class="btn btn-danger waves-effect waves-light">Cancel</button>
                    </div>
                </div>

            </form>

        </div> <!-- panel -->
        <!-- col -->
    </div>

</div>


<script>

    $(document).ready(function () {
        $("#IpWhiteListFormBtn,#CancelIPWhiteList").click(function () {
            $("#IpWhiteListFormDiv").toggleClass("hidden");
        });
    });

</script>

<script>
    $(function () {

        $('#IpWhiteListForm').bootstrapValidator({
            message: false,
//            container: 'tooltip',
            trigger: null,
            live: 'enabled',
            feedbackIcons: {
                // valid: 'glyphicon glyphicon-ok',
                // invalid: 'glyphicon glyphicon-remove',
                // validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                  ip_address: {// field name
                    validators: {
                        notEmpty: {
                            message: 'IP field cannot be empty'
                        },
                        ip: {
                            message: 'Please enter a valid IP address'
                        },
                    },
                }

            }

        }).on('success.form.bv', function (e) {
            e.preventDefault();

        });
    });
</script>
<script>
    //var Category = angular.module("Category", []);
    viral_pro.controller("IpWhiteLisController", function ($scope) {

        $scope.message = "";
        $scope.saveBtn = "Save";
        $scope.all_ips = <?php echo json_encode($offer_goals) ?>;
        $scope.campaign_id = {value: "0", text: "None"};

        $scope.action = "<?php echo SITEURL . "admin/campaign_ip/SetIpWhiteList" ?>";



        $scope.SetIpWhiteList = function () {
            if (!$("#IpWhiteListForm").data('bootstrapValidator').validate().isValid())
            {
                return  false;
            }

            $scope.saveBtn = "Setting....";
            var fom = $("#IpWhiteListForm")[0];
            $scope.saveBtn = "<?php echo "Setting..." ?>";

            console.log(fom);

            var formData = new FormData(fom);
            console.log(formData);

            //var form = new FormData($("#IpWhiteListForm"));
            $.ajax({
                url: $scope.action,
                type: 'POST',
                dataType: 'json',
                data: $("#IpWhiteListForm").serialize(),
                success: function (data, textStatus, jqXHR) {

                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');

                        $("#IpWhiteListForm")[0].reset();
                        var campaign_id = $("#ip_campaign_id").val();
                        $scope.show_ips(campaign_id);
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

        $scope.show_ips = function (campaign_id)
        {
            $.ajax({
                url: "<?php echo SITEURL . "admin/campaign_ip/show_ips/" ?>" + campaign_id,
                type: 'POST',
                dataType: 'json',
//                data: $("#IpWhiteListForm").serialize(),
                success: function (data, textStatus, jqXHR) {
//                    if (data['success'])
//                    {
                    $scope.all_ips = data['all_ips'];
                    //}
                    $scope.$apply();
                }

            });
        };

        $scope.setSystemDefaultIP = function ()
        {
            $scope.saveBtn = "Setting....";
            var fom = $("#IpWhiteListForm")[0];
            $scope.saveBtn = "<?php echo "Setting..." ?>";

            console.log(fom);

            var formData = new FormData(fom);
            console.log(formData);

            //var form = new FormData($("#IpWhiteListForm"));
            $.ajax({
                url: "<?php echo SITEURL."admin/campaign_ip/setDefaultIps" ?>",
                type: 'POST',
                dataType: 'json',
                data: $("#IpWhiteListForm").serialize(),
                success: function (data, textStatus, jqXHR) {

                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');

                        $("#IpWhiteListForm")[0].reset();
                        var campaign_id = $("#ip_campaign_id").val();
                        $scope.show_ips(campaign_id);
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

        $scope.delete_offer_ip = function (camp_ip_id)
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
                        url: "<?php echo SITEURL . "admin/campaign_ip/deleteip" ?>",
                        type: 'POST',
                        data: "camp_ip_id=" + camp_ip_id,
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            if (data['success'])
                            {
                                $.Notification.autoHideNotify('success',
                                        'botton right',
                                        data['msg'],
                                        '');
                                $("#tr" + camp_ip_id).remove();
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

        $scope.show_offers_ips = function ()
        {
            var campaign_id = $("#ip_campaign_id").val();
            $scope.show_ips(campaign_id);
        };


        $scope.show_ips('<?php echo isset($campaign_id) ? $campaign_id : 0 ?>');

    });
</script>