<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
<link href="<?php echo ASSETS ?>plugins/jquery-multi-select/multi-select.css" rel="stylesheet" type="text/css">


<div class="row">
    <div class="col-sm-12">
        <!--        <h1 class="text-danger">Don't use this module.</h1>-->
        <div class="panel panel-default"  ng-controller="add_user_group">
            <div class="panel-heading"><h3 class="panel-title">
                    <?php echo $panel_title ?>
                    <div class="pull-right">
                        <ul class="bulkActions">
                            <li>
                                <a title="All Groups" href="<?php echo isset($allgroupLink) ? $allgroupLink : '#' ?> " class=" btn btn-info waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-group"></span> <?php echo isset($allgroupTitle) ? $allgroupTitle : '' ?></a>
                            </li>

                        </ul>
                    </div>
                </h3></div>
            <div class="panel-body">

                <form class="form-horizontal" role="form" id="usersGroupForm" ng-submit="createUserGroup_updateUserGroup()"> 


                    <div class="form-group">
                        <label class="col-md-2 control-label">Name</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="gname" value="<?php echo isset($group['gname']) ? $group['gname'] : '' ?>" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">Select Affiliates</label>
                        <div class="col-md-9">

                            <?php
                            echo form_multiselect("uid[]", $users, isset($group_members) ? $group_members : '', "class='multi-select'  id='my_multi_select3' ")
                            ?>

                        </div>

                    </div>


                    <div class="form-group">
                        <label class="col-md-2 control-label">User status</label>
                        <div class="col-md-3">
                            <?php
                            echo form_dropdown("gstatus", $status, isset($group['gstatus']) ? $group['gstatus'] : '', "class='form-control'")
                            ?> 

                        </div>
                    </div>
                    <div class="form-group"> 
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-10">

                            <button title="Create a new Group.." type="submit" class="btn btn-purple waves-effect waves-light">
                                <span class=" fa fa-save"></span>
                                {{saveBtn}}</button>
                            <button type="Reset" class="btn btn-danger waves-effect waves-light">
                                <span class=" fa fa-remove"></span>
                                Cancel</button>
                        </div>
                    </div>

                </form>
            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col -->
</div>
<script>
    $(function () {

        $('#usersGroupForm').bootstrapValidator({
            message: false,
//            container: 'tooltip',
            trigger: null,
            live: 'enabled',
//            
            feedbackIcons: {
                // valid: 'glyphicon glyphicon-ok',
                // invalid: 'glyphicon glyphicon-remove',
                // validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                gname: {// field name
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

    $(document).ready(function () {
        $('#my_multi_select3').multiSelect({
            selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
            selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
            afterInit: function (ms) {
                var that = this,
                        $selectableSearch = that.$selectableUl.prev(),
                        $selectionSearch = that.$selectionUl.prev(),
                        selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                        selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

                that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                        .on('keydown', function (e) {
                            if (e.which === 40) {
                                that.$selectableUl.focus();
                                return false;
                            }
                        });

                that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                        .on('keydown', function (e) {
                            if (e.which == 40) {
                                that.$selectionUl.focus();
                                return false;
                            }
                        });
            },
            afterSelect: function () {
                this.qs1.cache();
                this.qs2.cache();
            },
            afterDeselect: function () {
                this.qs1.cache();
                this.qs2.cache();
            }
        });

    });



</script>

<script>
    //var users = angular.module("users", []);
    viral_pro.controller("add_user_group", function ($scope) {

        $scope.message = "";
        $scope.saveBtn = "<?php echo $FormSubmitBtn ?>";


        $scope.action = "<?php echo $FormAction ?>";



        $scope.createUserGroup_updateUserGroup = function () {


            //if (!$("#postForm").data('bootstrapValidator').validate().isValid())
            if (!$("#usersGroupForm").data('bootstrapValidator').validate().isValid())
            {

                return  false;
            }
            var fom = $("#usersGroupForm")[0];
            $scope.saveBtn = "<?php echo $SubmitAction ?>";

            console.log(fom);

            var formData = new FormData(fom);
            console.log(formData);

            //var form = new FormData($("#usersGroupForm"));
            $.ajax({
                url: $scope.action,
                type: 'POST',
                dataType: 'json',
                data: $("#usersGroupForm").serialize(),
                success: function (data, textStatus, jqXHR) {
                    $scope.saveBtn = "<?php echo $FormSubmitBtn ?>";
                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
                        if ($scope.saveBtn !== "Update")
                            $("#usersGroupForm")[0].reset();
                    } else {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                    }

                    $scope.$apply();
                }

            });



        };

    });
</script>
