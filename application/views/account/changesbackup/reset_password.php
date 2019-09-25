
<div class="row" ng-app="setting_app" ng-controller="sett_con">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-8">
        <div class="col-lg-12" style="    margin: 6% auto;"> 
            <form class="form-horizontal" role="form" id="password_reset_from" ng-submit="reset_my_password()"> 
                <div class="panel-group panel-group-joined" id="accordion-test"> 
                    <div class="panel panel-default"> 
                        <div class="panel-heading"> 
                            <h4 class="panel-title"> 
                                <a data-toggle="collapse" data-parent="#accordion-test" href="#collapseOne" class="" aria-expanded="true">
                                    Security
                                </a> 
                            </h4> 
                        </div> 
                        <div id="collapseOne" class="panel-collapse collapse in" aria-expanded="true"> 

                            <div class="panel-body">



                                <div class="form-group">
                                    <label class="col-md-2 control-label">Password</label>
                                    <div class="col-md-10">
                                        <input type="hidden" name="in_code" autocomplete="off" value="<?php echo isset($in_code) ? $in_code : '' ?>"/>
                                        <input type="password" class="form-control" value=""  name="password" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Password R-Type</label>
                                    <div class="col-md-10">
                                        <input type="password" class="form-control" autocomplete="off"  value=""  name="re_password" value="">
                                    </div>
                                </div>
                                <div class="form-group"> 
                                    <div class="col-sm-2">
                                    </div>
                                    <div class="col-sm-10">

                                       
                                        <button type="submit" class="btn btn-purple waves-effect waves-light">{{saveBtn}}</button>


                                    </div>
                                </div>


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

        $('#password_reset_from').bootstrapValidator({
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
                
            }

        }).on('success.form.bv', function (e) {
            e.preventDefault();
        });
    });</script>

<script>
    var setting_app = angular.module("setting_app", ['ui.bootstrap']);
    setting_app.controller("sett_con", function ($scope) {

        $scope.FormAction = "<?php echo SITEURL . "account/account/reset_password" ?>";
        $scope.saveBtn = "Submit";
       
        $scope.reset_my_password = function ()
        {

            if (!$("#password_reset_from").data('bootstrapValidator').validate().isValid())
            {

                return  false;
            }

            var form = $("#password_reset_from").serialize();
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
                    } else
                    {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                    }
                }

            });
        };
    });</script>
