<div class="row">
    <div class="col-sm-12">
        <!--        <h1 class="text-danger">Don't use this module.</h1>-->
        <div class="panel panel-default"  ng-controller="add_update_employee">
            <div class="panel-heading"><h3 class="panel-title">
                    <a href="<?php echo SITEURL . "admin/users/ShowUsers" ?>" class=" btn btn-purple waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-list"></span> All Users</a>
                    <?php echo $panel_title ?></h3></div>
            <div class="panel-body">

                <form class="form-horizontal" role="form" id="EmployeeForm" ng-submit="create_update_Employee()"> 


                    <div class="form-group">
                        <label class="col-sm-2 control-label">User Type</label>
                        <div class="col-sm-3">
                            <?php
                            echo form_dropdown("UTID", $userType, isset($user['UTID']) ? $user['UTID'] : '', "class='form-control'")
                            ?> 


                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Company</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="company" value="<?php echo isset($user['company']) ? $user['company'] : '' ?>" placeholder="Example : Moremint">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Name <span class='text-danger'>*</span></label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="name" value="<?php echo isset($user['name']) ? $user['name'] : '' ?>" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="">Email <span class='text-danger'>*</span></label>
                        <div class="col-md-4">
                            <?php
                            if (!isset($user['email'])) {
                                ?>
                                <input type="email" id="example-email" value="<?php echo isset($user['email']) ? $user['email'] : '' ?>"  name="email" class="form-control" placeholder="johan@email.com">
                                <?php
                            } else {
                                echo $user['email'];
                            }
                            ?>


                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="">User ID <span class='text-danger'>*</span></label>
                        <div class="col-md-4">
                            <?php
                            if (!isset($user['username'])) {
                                ?>
                                <input type="text" id="example-email" value="<?php echo isset($user['username']) ? $user['username'] : '' ?>"  name="username" class="form-control" placeholder="">
                                <?php
                            } else {
                                echo $user['username'];
                            }
                            ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Password <span class='text-danger'>*</span></label>
                        <div class="col-md-4">
                            <input type="password" class="form-control" value="<?php echo isset($user['password']) ? $user['password'] : '' ?>"  name="password" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Password R-Type <span class='text-danger'>*</span></label>
                        <div class="col-md-4">
                            <input type="password" class="form-control" value="<?php echo isset($user['re_password']) ? $user['re_password'] : '' ?>"  name="re_password" >
                        </div>
                    </div>




                    <div class="form-group">
                        <label class="col-md-2 control-label" for="">Contact <span class='text-danger'>*</span></label>
                        <div class="col-md-4">
                            <input type="text" id="example-email" value="<?php echo isset($user['contact']) ? $user['contact'] : '' ?>"  name="contact" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="">Skype</label>
                        <div class="col-md-4">
                            <input type="text" id="example-email" value="<?php echo isset($user['skype_id']) ? $user['skype_id'] : '' ?>" name="skype_id" class="form-control" placeholder="">
                        </div>
                    </div>









                    <div class="form-group">
                        <label class="col-md-2 control-label ">
                            Country <span class='text-danger'>*</span></label>
                        <div class="col-md-4">
                            <?php echo form_dropdown("country_id", $country, isset($user['country_id']) ? $user['country_id'] : '', "class='select2 form-control' ") ?>
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-md-2 control-label">Address</label>
                        <div class="col-md-6">
                            <textarea class="form-control" name="address" rows="5"><?php echo isset($user['address']) ? $user['address'] : '' ?></textarea>
                        </div>
                    </div>





                    <div class="form-group">
                        <label class="col-md-2 control-label">User Verification</label>
                        <div class="col-md-3">
                            <?php
                            echo form_dropdown("verified", array("1" => "Verified", "0" => "Not Verified"), isset($user['verified']) ? $user['verified'] : '', "class='form-control'")
                            ?> 

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">User status</label>
                        <div class="col-md-3">
                            <?php
                            echo form_dropdown("status", array("1" => "Active", "0" => "De-Active"), isset($user['u_status']) ? $user['u_status'] : '', "class='form-control'")
                            ?> 
<!--                            <select name="status" class="form-control">
        <option value="1">Active</option>
        <option value="0">De-Active</option>
    </select>-->
                        </div>
                    </div>








                    <div class="form-group"> 
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-10">

                            <button type="submit" class="btn btn-purple waves-effect waves-light">{{saveBtn}}</button>
                            <button type="Reset" class="btn btn-danger waves-effect waves-light">Cancel</button>
                        </div>
                    </div>

                </form>
            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col -->
</div>
<script>
    $(function () {

        $('#EmployeeForm').bootstrapValidator({
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
                },
                email: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Email cannot be empty'
                        },
                        emailAddress: {
                            message: 'Invalid Email'
                        },
                        remote: {
                            url: '<?php echo SITEURL . "account/account/getEmail" ?>',
                            type: 'POST',
                            message: 'Email is not available'
                        }
                    }
                },
                username: {// field name
                    validators: {
                        notEmpty: {
                            message: 'User ID cannot be empty'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9\s]+$/,
                            message: 'Invalid User ID'
                        },
                        stringLength: {
                            min: 3,
                            max: 25,
                            message: 'User ID must be 3 to 25 characters long'
                        },
                        remote: {
                            url: '<?php echo SITEURL . "account/account/getUser" ?>',
                            type: 'POST',
                            message: 'username is not available'
                        }


                    }
                },
                password: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Password cannot be empty'
                        },
                        stringLength: {
                            min: 6,
                            max: 10,
                            message: 'Password must be 6 to 10 characters long'
                        },
                    }
                },
                re_password: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Password cannot be empty'
                        },
                        identical: {
                            field: 'password',
                            message: 'The password and its confirm are not the same'
                        }



                    }
                },
                address: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Address cannot be empty'
                        },
                    }
                },
//                bank_name: {// field name
//                    validators: {
//                        notEmpty: {
//                            message: 'Bank Name cannot be empty'
//                        },
//                        regexp: {
//                            regexp: /^[a-zA-Z0-9\s]+$/,
//                            message: 'Invalid Bank Name'
//                        },
//                        stringLength: {
//                            min: 3,
//                            max: 25,
//                            message: 'Name must be 3 to 25 characters long'
//                        }
//                    }
//                },
//                bank_account: {// field name
//                    validators: {
//                        notEmpty: {
//                            message: 'Bank Account No. cannot be empty'
//                        },
//                        callback:
//                                {
//                                    message: '',
//                                    callback: function (value, validator, $field) {
//                                        // ... Do your logic checking
//                                        if (value == "123") {
//                                            return {
//                                                valid: true, // or false
//                                                message: 'The error message'
//                                            }
//                                        }
//
//                                        return {
//                                            valid: false, // or true
//                                            message: 'Other error message'
//                                        }
//                                    }
//                                }
//                    }
//                },
//                IFSC_code: {// field name
//                    validators: {
//                        notEmpty: {
//                            message: 'IFSC_code cannot be empty'
//                        },
//                        callback:
//                                {
//                                    message: '',
//                                    callback: function (value, validator, $field) {
//                                        // ... Do your logic checking
//                                        if (value == "123") {
//                                            return {
//                                                valid: true, // or false
//                                                message: 'The error message'
//                                            }
//                                        }
//
//                                        return {
//                                            valid: false, // or true
//                                            message: 'Other error message'
//                                        }
//                                    }
//                                }
//                    }
//                },
//                PAN: {// field name
//                    validators: {
//                        notEmpty: {
//                            message: 'PAN Number cannot be empty'
//                        },
//                        callback:
//                                {
//                                    message: '',
//                                    callback: function (value, validator, $field) {
//                                        // ... Do your logic checking
//                                        if (value == "123") {
//                                            return {
//                                                valid: true, // or false
//                                                message: 'The error message'
//                                            }
//                                        }
//
//                                        return {
//                                            valid: false, // or true
//                                            message: 'Other error message'
//                                        }
//                                    }
//                                }
//                    }
//                }
            }

        }).on('success.form.bv', function (e) {
            e.preventDefault();

        });
    });
</script>

<script>
    //var users = angular.module("users", []);
    viral_pro.controller("add_update_employee", function ($scope) {

        $scope.message = "";
        $scope.saveBtn = "<?php echo $FormSubmitBtn ?>";


        $scope.action = "<?php echo $FormAction ?>";



        $scope.create_update_Employee = function () {


            //if (!$("#postForm").data('bootstrapValidator').validate().isValid())
            if (!$("#EmployeeForm").data('bootstrapValidator').validate().isValid())
            {

                return  false;
            }
            var fom = $("#EmployeeForm")[0];
            $scope.saveBtn = "<?php echo $SubmitAction ?>";

            console.log(fom);

            var formData = new FormData(fom);
            console.log(formData);

            //var form = new FormData($("#EmployeeForm"));
            $.ajax({
                url: $scope.action,
                type: 'POST',
                dataType: 'json',
                data: $("#EmployeeForm").serialize(),
                success: function (data, textStatus, jqXHR) {
                    $scope.saveBtn = "<?php echo $FormSubmitBtn ?>";
                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
                        if ($scope.saveBtn !== "Update")
                            $("#EmployeeForm")[0].reset();
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