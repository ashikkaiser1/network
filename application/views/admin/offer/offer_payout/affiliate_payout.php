<div class="row" ng-controller="AddAffiliatePayout">
    <div class="col-md-6">
        <div class="panel panel-default" >
            <div class="panel-heading">
                <h3 class="panel-title">
                    Payout Setting
                </h3></div>
            <div class="panel-body">
                <div class="row">
                    <?php
                    if (!empty($campaign)) {
                        ?>   
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">


                                <form id="AffiliatePayoutForm" ng-submit="SetAffPayout()">     
                                    <div class="row">
                                        <div class="col-md-12 " id="ShowAddPayoutFrom">
                                            <div class="form-group">
                                                <label class="col-md-12 control-label">Payout Type</label>
                                                <div class="col-md-12">
                                                    <?php
                                                    echo form_dropdown("payout_type", $payoutList, isset($campaign['payout_type']) ? $campaign['payout_type'] : '', "class='form-control' readonly=''");
                                                    ?>

                                                    <input type="hidden" name="campaign_id" value="<?php echo isset($campaign['campaign_id']) ? $campaign['campaign_id'] : 0 ?>"
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-12 control-label">Payout Cost <?php echo CURR ?></label>
                                                <div class="col-md-12">
                                                    <input type="text"  class="form-control " value="<?php echo isset($campaign['payout_cost']) ? $campaign['payout_cost'] : '' ?>" name="payout_cost">
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-md-12 control-label">Select</label>
                                                <div class="col-md-4">
                                                    <label class="col-md-12 control-label">
                                                        <input type="checkbox" name="pub_select" value="pub_select" id="pub_select"/> Publisher
                                                    </label>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="col-md-12 control-label">
                                                        <input type="checkbox" name="group_select" value="group_select" id="group_select"/> Group
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group" >
                                                <label class="col-md-12 control-label">Publisher</label>
                                                <div class="col-md-12">
                                                    <?php
                                                    echo form_multiselect("uid[]", $publisher, '', "class='form-control select2' ");
                                                    ?>

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-12 control-label">Group</label>
                                                <div class="col-md-12">
                                                    <?php
                                                    echo form_multiselect("group_id[]", $usr_group, '', "class='form-control select2' ");
                                                    ?>

                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-md-12 control-label"></label>
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-purple waves-effect waves-light" ><span class="fa fa-save"></span> {{saveBtn}}</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                            </div> <!-- col -->
                            </form>
                        </div>

                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>




<div class="col-md-6">
    <div class="panel panel-default" >
        <div class="panel-heading">
            <h3 class="panel-title">
                Payout Details
            </h3></div>
        <div class="panel-body">
            <div class="row">

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="table-responsive table  table-hover">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Company</th>
                                        <th>Payout</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr ng-repeat="list in allAffPayout" id="tr{{list.pay_group_id}}">
                                        <td>
                                            <a ng-if="list.UTID == <?php echo AFFILIATE ?>" title="View"  href="<?php echo SITEURL . "admin/users/ViewUser/" ?>{{list.uid}}" > {{list.uid}}</a>
                                        </td>
                                        <td>
                                            <a ng-if="list.UTID == <?php echo AFFILIATE ?>" title="View"  href="<?php echo SITEURL . "admin/users/ViewUser/" ?>{{list.uid}}" > {{list.company}}</a>  
                                        </td>
                                        <td>{{list.payout_cost + " " + list.payoutName}}</td>

                                        <td> <button type="button" ng-click="delete_this(list.pay_group_id)" class="btn btn-danger waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-trash"></span></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                        <div class="table-responsive table  table-hover">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Group Name</th>
                                        <th>Payout</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr ng-repeat="list in allGroupPayout" id="tr{{list.pay_group_id}}">
                                        <td>{{list.group_id}}</td>
                                        <td>{{list.gname}}</td>
                                        <td>{{list.payout_cost + " " + list.payoutName}}</td>
                                        <td> <button type="button" ng-click="delete_this(list.pay_group_id)" class="btn btn-danger waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-trash"></span></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>


<script>
    $(function () {

        $('#AffiliatePayoutForm').bootstrapValidator({
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
                name: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Name field cannot be empty'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9\s]+$/,
                            message: 'Invalid Name'
                        },
                        stringLength: {
                            min: 3,
                            max: 25,
                            message: 'Name must be 3 to 25 characters long'
                        }
                    }
                }

            }

        }).on('success.form.bv', function (e) {
            e.preventDefault();

        });
    });
</script>
<script>
    //var Category = angular.module("Category", []);
    viral_pro.controller("AddAffiliatePayout", function ($scope) {

        $scope.message = "";
        $scope.saveBtn = "Save";


        $scope.action = "<?php echo SITEURL . "admin/offer_payout/setOfferPayout" ?>";



        $scope.SetAffPayout = function () {


            if (!$("#AffiliatePayoutForm").data('bootstrapValidator').validate().isValid())
            {

                return  false;
            }

            $scope.saveBtn = "Saving...";
            var fom = $("#AffiliatePayoutForm")[0];


            console.log(fom);

            var formData = new FormData(fom);
            console.log(formData);

            //var form = new FormData($("#AffiliatePayoutForm"));
            $.ajax({
                url: $scope.action,
                type: 'POST',
                dataType: 'json',
                data: $("#AffiliatePayoutForm").serialize(),
                success: function (data, textStatus, jqXHR) {

                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');

                        $(".select2").select2('val', '');

                        $("#AffiliatePayoutForm")[0].reset();

                        $scope.GetAffPayout();
                        $scope.GetGroupPayout();

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


        $scope.GetAffPayout = function () {

            //var form = new FormData($("#AffiliatePayoutForm"));
            $.ajax({
                url: "<?php echo SITEURL . "admin/offer_payout/show_payouts_aff" ?>",
                type: 'POST',
                dataType: 'json',
                data: "campaign_id=<?php echo isset($campaign['campaign_id']) ? $campaign['campaign_id'] : 0 ?>",
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $scope.allAffPayout = data['payoutsAff'];
                    }
                    $scope.$apply();
                }

            });



        };


        $scope.GetGroupPayout = function () {

            //var form = new FormData($("#AffiliatePayoutForm"));
            $.ajax({
                url: "<?php echo SITEURL . "admin/offer_payout/show_payouts_group" ?>",
                type: 'POST',
                dataType: 'json',
                data: "campaign_id=<?php echo isset($campaign['campaign_id']) ? $campaign['campaign_id'] : 0 ?>",
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $scope.allGroupPayout = data['payoutsGroup'];
                    }
                    $scope.$apply();
                }

            });



        };



        $scope.delete_this = function (pay_group_id)
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
                        url: "<?php echo SITEURL . "admin/offer_payout/deletePayout" ?>",
                        type: 'POST',
                        data: "pay_group_id=" + pay_group_id,
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            if (data['success'])
                            {
                                $.Notification.autoHideNotify('success',
                                        'botton right',
                                        data['msg'],
                                        '');
                                $("#tr" + pay_group_id).remove();

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

        $scope.GetAffPayout();
        $scope.GetGroupPayout();

    });
</script>