<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default"  ng-controller="offerEmail">
            <div class="panel-heading"><h3 class="panel-title">
<!--                    <a href="<?php echo SITEURL . "admin/offer/show_campaign" ?>" class=" btn btn-purple waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-list"></span> All Offers</a>-->
                    <?php echo $title ?></h3></div>
            <div class="panel-body">
                <form class="form-horizontal" id="EmailForm" role="form" ng-submit="sendEmail()">                                    

                    <div class="form-group">
                        <label class="col-md-2 control-label">Offer</label>
                        <div class="col-md-10">
                            <?php
                            echo form_multiselect("campaign_id[]", $offers, $autoOfferSelected, "class='form-control campaign_id_select2' ");
                            ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Affiliates</label>
                        <div class="col-md-10">
                            <?php
                            echo form_multiselect("uid[]", $affiliates, isset($autoUidSelected) ? $autoUidSelected : '', "class='form-control select2' ");
                            ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Email Template</label>
                        <div class="col-md-10">
                            <textarea class="form-control" rows="8" name="emailMsg"></textarea>
                        </div>
                    </div>



                    <div class="form-group"> 
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-10">

                            <button  type="submit" class="btn btn-purple waves-effect waves-light">{{saveBtn}}</button>
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

        $('#EmailForm').bootstrapValidator({
            message: false,
//            container: 'tooltip',
            trigger: null,
            live: 'disabled',
            feedbackIcons: {
                // valid: 'glyphicon glyphicon-ok',
                // invalid: 'glyphicon glyphicon-remove',
                // validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                campaign_name: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Offer Name cannot be empty'
                        },
                        stringLength: {
                            min: 3,
                            max: 2500,
                            message: 'Offer Name must be 3 to 25 characters long'
                        }
                    }
                },
                title: {// field name
                    validators: {
                        notEmpty: {
                            message: ''
                        },
//                                            regexp: {
//                                                regexp: /^[a-zA-Z0-9\s]+$/,
//                                                message: ''
//                                            },
                        stringLength: {
                            min: 3,
                            max: 2500,
                            message: ''
                        }
                    }
                },
                meta: {// field name
                    validators: {
                        notEmpty: {
                            message: ''
                        },
//                                            regexp: {
//                                                regexp: /^[a-zA-Z0-9\s]+$/,
//                                                message: ''
//                                            },
                        stringLength: {
                            min: 3,
                            max: 1000,
                            message: ''
                        }
                    }
                }, url_slug: {// field name
                    validators: {
                        notEmpty: {
                            message: ''
                        },
                        url: {
                            message: ''
                        }, stringLength: {
                            min: 3,
                            max: 2500,
                            message: ''
                        }
                    }
                }
                ,
                'category_id[]': {
                    validators: {
                        notEmpty: {
                            message: 'Please select a category'
                        }
                    }
                }


                /* start_date: {// field name
                 validators: {
                 date: {
                 format: 'MM/DD/YYYY',
                 message: 'Start Date is not valid',
                 //max: 'end_date'
                 
                 
                 }
                 }
                 },
                 end_date: {// field name
                 validators: {
                 date: {
                 format: 'MM/DD/YYYY',
                 message: 'End Date is not valid',
                 min: 'start_date'
                 
                 
                 }
                 }*/



            }

        }).on('success.form.bv', function (e) {
            e.preventDefault();

        });
    });
</script>
<script>
    //var Offer = angular.module("Offer", []);
    viral_pro.controller("offerEmail", function ($scope) {

        $scope.message = "";
        $scope.saveBtn = "<?php echo $SubmitBtn ?>";
        $scope.redirection = 0;

        $scope.action = "<?php echo $FormAction ?>";

        $scope.onSelectGlobe = function ()
        {
            if ($scope.globalCountry)
                $("#offer_countries").select2("enable", false);
            else
                $("#offer_countries").select2("enable", true);
            //$scope.globalCountry";
        };


        $scope.onchnageRedirection = function ()
        {
            // console.log($scope.redirection);
            if ($scope.redirection == 1)
            {
                $("#redirectOptio").show();
            }
            else
            {
                $("#redirectOptio").hide();
            }

        };


        $scope.sendEmail = function () {

            if (!$("#EmailForm").data('bootstrapValidator').validate().isValid())
            {

                //alert("Form Not Valida");
                return  false;
            }


            var fom = $("#EmailForm")[0];

            console.log(fom);

            var formData = new FormData(fom);
            console.log(formData);

            $scope.saveBtn = "<?php echo $Submiting ?>";

            //var form = new FormData($("#EmailForm"));
            $.ajax({
                url: $scope.action,
                type: 'POST',
                dataType: 'json',
                data: $("#EmailForm").serialize(),
                success: function (data, textStatus, jqXHR) {
                    $scope.saveBtn = "<?php echo $SubmitBtn ?>";
                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
                        if ($scope.saveBtn != 'Update')
                            $("#EmailForm")[0].reset();

                        window.location = data['redirect'];

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
