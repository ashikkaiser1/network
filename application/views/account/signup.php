<style type="text/css">
    #select2Form .form-control-feedback {
        /* To make the feedback icon visible */
        z-index: 100;
    }
</style>
<div class="row" ng-app="setting_app" ng-controller="sett_con">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-8">
        <div class="col-lg-12" style="    margin: 6% auto;"> 
            <h3 class="text-center text-uppercase"><?php echo $title ?></h3>
            <p class="text-center text-default">Apply to our network by submitting your information below.</p>
            <form class="form-horizontal" role="form" id="usersForm" ng-submit="CreateUser()"> 
                <div class="panel-group panel-group-joined" id="accordion-test"> 
                    <div class="panel panel-default"> 
                        <div class="panel-heading">  
                            <h4 class="panel-title"> 
                                <a  href="#collapseOne" class="" aria-expanded="true">
                                    Basic Info
                                </a> 
                            </h4> 
                        </div> 
                        <div id="collapseOne" class="panel-collapse collapse in in" aria-expanded="true"> 


                            <div class="panel-body">
                                <input type="hidden" name="ref_by" value="<?php echo @$ref_by ?>"/>
                                <input type="hidden" name="in_code" value="<?php echo isset($in_code) ? $in_code : uniqid() ?>"/>
                                <input type="hidden" name="in_for" value="<?php echo isset($in_for) ? $in_for : ''; ?>"/>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Company</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="company" value="" placeholder="Moremint">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Name</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="name" value="" placeholder="Johan">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="">Email</label>

                                    <div class="col-md-10">
                                        <input type="text"   class="form-control" name="email" value="<?php echo isset($UserEmail) ? $UserEmail : '' ?>" placeholder="Johan@xyz.com">
                                    </div>
<!--                                        <h6><?php echo isset($UserEmail) ? $UserEmail : '' ?></h6>-->


                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="">User ID</label>
                                    <div class="col-md-10">
                                        <input type="text"  value=""  name="username" class="form-control" placeholder="">
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label class="col-md-2 control-label ">
                                        Country <span class='text-danger'>*</span></label>
                                    <div class="col-md-10">

                                        <?php echo form_dropdown("country_id", $country, '', "class='select2 form-control' ") ?>
                                    </div>
                                </div>

                                <div class="form-group"> 
                                    <label class="col-md-2 control-label ">
                                        Timezone <span class='text-danger'>*</span></label>
                                    <div class="col-md-4">
                                        <?php echo form_dropdown("timeZone", $timeZone, '', "class='select2 form-control' ") ?>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label class="col-md-2 control-label">Address</label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" name="address" rows="5"></textarea>
                                    </div>
                                </div>                                  



                                <!--                                <div class="form-group"> 
                                                                    <div class="col-sm-2">
                                                                    </div>
                                                                    <div class="col-sm-10">
                                
                                                                        <button type="button"  href="#collapseTwo"  class="btn btn-purple waves-effect waves-light">{{saveBtn}}</button>
                                
                                
                                                                    </div>
                                                                </div>-->


                            </div> 
                        </div> 
                    </div> 


                    <div class="panel panel-default"> 
                        <div class="panel-heading"> 
                            <h4 class="panel-title"> 
                                <a  href="#collapseTwo" aria-expanded="true" class="">
                                    Traffic Info
                                </a> 
                            </h4> 
                        </div> 
                        <div id="collapseTwo" class="panel-collapse collapse in" aria-expanded="true" style=""> 
                            <div class="panel-body">




                                <div class="form-group">
                                    <label class="col-md-5 control-label " style="text-align:left;font-weight:normal">
                                        What are the verticals that you are currently running?<span class='text-danger'>*</span></label>
                                    <div class="col-md-6">
                                        <?php echo form_multiselect("trafic_info[offer_veticals][]", $offerCategory, '', "class='select2 form-control' id='offer_veticals_id' ") ?>

                                    </div>
                                
                                </div>
                                <div class="form-group">
                                 <label class="col-md-5 control-label text-left" style="text-align:left;font-weight:normal">
                                        What are the Verticals that you're interested in running/learning about more with us?<span class='text-danger'>*</span></label>
                                    <div class="col-md-6">
                                        <?php echo form_multiselect("trafic_info[offer_interest][]", $offerCategory, '', "class='select2 form-control' ") ?>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label class="col-md-5 control-label text-left" style="text-align:left;font-weight:normal">Are there specific offers you are looking to run with our network and how did you find out about them?<span class='text-danger'>*</span></label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" value=""  name="offer_specific" >
                                    </div>
                                </div>
                                  <div class="form-group">
                                    <label class="col-md-5 control-label text-left" style="text-align:left;font-weight:normal">What top 3 Regions do you mostly run in? <span class='text-danger'>*</span></label>
                                    <div class="col-md-4">

                                        <?php echo form_multiselect("trafic_info[offer_countries][]", $country, '', "id='offer_countries' class='select2 form-control' ") ?>

                                    </div>

                                    <label class="col-md-2 control-label text-left" style="text-align:left;font-weight:normal">
                                        <input type="checkbox" ng-model="globalCountry" ng-click="onSelectGlobe()" name="global" value="1"/> Global</label>

                                </div>

 
                                <div class="form-group">
                                    <label class="col-md-5 control-label text-left" style="text-align:left;font-weight:normal">What traffic types do you generally use for promotional purposes?<span class='text-danger'>*</span></label>
                                    <div class="col-md-6">
                                        <div  class="col-md-3" >
                                            <label style="font-weight:bold"> <input name="trafic_info[offer_promotional][]" type="checkbox"  ng-model="checkoffer_promotional" />Select All</label>
                                        </div>
                                        <?php foreach ($trafficType as $key => $val) {
                                            ?>
                                            <div  class="col-md-3" >
                                                <label style="font-weight:normal">
                                                    <input ng-checked="checkoffer_promotional" type="checkbox" name="trafic_info[offer_promotional][]"  value="<?php echo $key ?>" > <?php echo $val ?></label>
                                            </div>
                                        <?php }
                                        ?>
 
                                    </div>
                                </div>
 
                            </div> 
                        </div> 
                    </div> 

                    <div class="panel panel-default"> 
                        <div class="panel-heading"> 
                            <h4 class="panel-title"> 
                                <a  href="#collapseThree" aria-expanded="true" class="">
                                    Contact
                                </a> 
                            </h4> 
                        </div> 
                        <div id="collapseThree" class="panel-collapse collapse in" aria-expanded="true" style=""> 
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="">Contact</label>
                                    <div class="col-md-4">
                                        <input type="text"  value=""  name="contact" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="">Skype</label>
                                    <div class="col-md-4">
                                        <input type="text"  value=""  name="skype_id" class="form-control" placeholder="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="">Best Time to Reach You?</label>
                                    <div class="col-md-4">
                                        <input type="text"  value=""  name="contact_time" class="form-control" placeholder="9:00:00">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label ">
                                        Contact Time zone <span class='text-danger'>*</span></label>
                                    <div class="col-md-4">
                                        <?php echo form_dropdown("contact_timezone", $timeZone, '', "class='select2 form-control' ") ?>
                                    </div>
                                </div>

                                

                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="">Additional Notes</label>
                                    <div class="col-md-4">
                                        <textarea    name="contact_notes" class="form-control" placeholder=""></textarea>


                                    </div>
                                </div>


 

                            </div> 
                        </div> 
                    </div> 







                    <div class="panel panel-default"> 
                        <div class="panel-heading"> 
                            <h4 class="panel-title"> 
                                <a  href="#collapseFour" aria-expanded="true" class="">
                                    Security
                                </a> 
                            </h4> 
                        </div> 
                        <div id="collapseFour" class="panel-collapse collapse in" aria-expanded="true" style=""> 
                            <div class="panel-body">



                                <div class="form-group">
                                    <label class="col-md-2 control-label">Password</label>
                                    <div class="col-md-10">
                                        <input type="password" class="form-control" value=""  name="password" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Password R-Type</label>
                                    <div class="col-md-10">
                                        <input type="password" class="form-control" value=""  name="re_password" value="">
                                    </div>
                                </div>
 
                                        <button type="submit" class="btn btn-purple waves-effect waves-light center">{{saveBtn}}</button>


                            </div> 
                        </div> 
                    </div> 
                  
                </div> 

            </form>
        </div>
    </div>
</div>


<script>
    $(function () {


        $("#offer_veticals_id").select2({
            // your options here
        }).on('change', function () {
            console.log("chnages");
            $("#usersForm").bootstrapValidator('revalidateField', $(this).prop('name'));
        });



//        
//        
//        
//        $('[name="timeZone"]')
//            .select2()
//            // Revalidate the color when it is changed
//            .change(function(e) {
//                $('[name="timeZone"]').formValidation('revalidateField', 'timeZone');
//            });

        $('#usersForm')
                .bootstrapValidator({
                    message: false,
//            container: 'tooltip',
                    trigger: 'blur',
                    live: 'enabled',
//            submitButtons: null,
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
                                    regexp: /^[a-zA-Z\s]+$/,
                                    message: 'Invalid Name'
                                },
                                stringLength: {
                                    min: 3,
                                    max: 25,
                                    message: 'Name must be 3 to 25 characters long'
                                }
                            }
                        },
                        timeZone: {// field name
//                    live: 'enabled',
                            trigger: 'blur',
                            validators: {
                                notEmpty: {
                                    message: 'Please select a time zone'
                                },
                                callback: {
                                    message: 'Please select a time zone..',
                                    callback: function (value, validator, $field) {
                                        // Get the selected options
                                        var options = validator.getFieldElements('timeZone').val();
                                        console.log("Options " + options + " value" + value);
                                        return (options != null && options.length > 0);
                                    }
                                }
                            }
                        },
                        'trafic_info[offer_veticals][]': {
//                    trigger: 'blur',
                            validators: {
                                choice: {
                                    min: 1,
                                    max: 4,
                                    message: 'Please choose options'
                                }
                            }
                        }

                        ,
                        'trafic_info[offer_promotional][]': {
                            validators: {
                                choice: {
                                    min: 1,
//                                    max: 4,
                                    message: 'Please choose options'
                                }
//                                ,
//                                callback: function (value, validator, $field) {
//                                    // Get the selected options
//                                    var options = validator.getFieldElements($field).val();
//                                    return (options != null && options.length >= 2 && options.length <= 4);
//                                }
                            }
                        }


                        ,
                        'trafic_info[offer_type][]': {
                            validators: {
                                choice: {
                                    min: 1,
                                    message: 'Please choose options'
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
                        }
//                        ,
//                        otherNetworkphone: {// field name
//
//                            validators: {
//                                regexp: {
//                                    regexp: /^[0-9]*$/,
//                                    message: 'Numeric Only'
//                                },
//                                stringLength: {
//                                    min: 6,
//                                    max: 14,
//                                    message: 'Invalid Contact No must be 6 to 14 characters long'
//                                }
//                            }
//
//
//                        }
                        ,
//                        otherNetworkemail: {// field name
//                            validators: {
//                                notEmpty: {
//                                    message: 'Email cannot be empty'
//                                },
//                                emailAddress: {
//                                    message: 'Invalid Email'
//                                }
//                            }
//                        },
//                contact_notes: {// field name
//
//                    validators:
//                            {
//                                regexp: {
//                                    regexp: /^\s*$/,
//                                    message: 'Space not allow'
//                                }
//
//                            }
//                },
//                        bank_name: {// field name
//
//                            validators:
////                                    {
//                                        regexp: {
//                                            regexp: /^[a-zA-Z\s]+$/,
//                                            message: 'Only alphabet'
//
// /                                       }
//
//
//                                    }
//                        },
//                        bank_account: {// field name
//
 //                           validators:
 //                                   {
 //                                       regexp: {
  //                                          regexp: /^[0-9\s]+$/,
  //                                          message: 'Only numeric'
//
//                                        }
//
//
//                                    }
//                        },
//                        PAN: {// field name
//                            validators:
//                                    {
//                                        regexp: {
//                                            regexp: /^\S*$/,
//                                            message: 'Space not allow'
//                                        }
//
//                                    }
//

                        }
//                ,
//                contact_time: {// field name
//        
//
//                    validators:
//                            {
//                                regexp: {
//                                    regexp: /^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$/,
//                                    message: 'Wrong format'
//                                }
//
//                            }
//                }
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
//                    }

                }).on('success.form.bv', function (e) {
            e.preventDefault();
        });
    });</script>

<script>
    var setting_app = angular.module("setting_app", ['ui.bootstrap']);
    setting_app.controller("sett_con", function ($scope) {
        $scope.checkoffer_promotional = false;
        $scope.checkoffer_type = false;
        $scope.FormAction = "<?php echo SITEURL . "account/account/signup" ?>";
        $scope.saveBtn = "SIGN UP";
        $scope.PreBtn = "Previous";


        $scope.onSelectGlobe = function ()
        {
            if ($scope.globalCountry)
                $("#offer_countries").select2("enable", false)
            else
                $("#offer_countries").select2("enable", true)
            //$scope.globalCountry";
        };


        $scope.CreateUser = function ()
        {

            if (!$("#usersForm").data('bootstrapValidator').validate().isValid())
            {

                return  false;
            }
            $scope.saveBtn = "Account Creating......";
            var form = $("#usersForm").serialize();
            $.ajax({
                url: $scope.FormAction,
                data: form,
                type: 'POST',
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
                        $scope.saveBtn = "COMPLETED";

                        window.location = data['redirect'] + "?username=" + data['user']['username'];
                    } else
                    {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                        $scope.saveBtn = "SIGN UP";
                    }
                }

            });
        };





    });</script>
