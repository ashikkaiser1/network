
<div class="row">
    
    <nav class="top-nav m-b-10">
        <a class="text-white " href="<?php
        echo SITEURL . "advertiser/campaign/offerRequest/" . @$campaign['campaign_id'];
        ?>">
            <h2 class="page-heading blue-bg " style="    font-size: 16px;">
                <span class="fa fa-arrow-left"></span> <?php echo isset($campaign['campaign_name']) ? $campaign['campaign_name'] : '' ?>
            </h2>
        </a>
    </nav>
    
    <div class="col-sm-12">
        <div class="panel panel-default"  ng-controller="AddOfferGeoTarget">
            <div class="panel-heading"><h3 class="panel-title">
                    <?php echo $title ?>
                </h3></div>
            <div class="panel-body">
                <form class="form-horizontal" id="catForm" role="form" ng-submit="CreateUpdateOfferGeoTarget()">                                    

                    <div class="form-group">
                        <label class="col-md-2 control-label">Offer Name</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" ng-model="title" value="<?php echo isset($campaign['campaign_name']) ? $campaign['campaign_name'] : '' ?>" name="campaign_name">
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-md-2 control-label text-left" style="">GEO Target <span class='text-danger'>*</span></label>
                        <div class="col-md-8">

                            <?php echo form_multiselect("offer_country[]", $country, isset($offer_country) ? $offer_country : '', "id='offer_countries' class='select2 form-control' ") ?>

                        </div>

                        <label class="col-md-2 control-label text-left" style="text-align:left;font-weight:normal">
                            <input type="checkbox" ng-model="globalCountry" ng-click="onSelectGlobe()" name="geo"  value="1"/> Global</label>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label text-left" style="">Device (Recommended)</label>
                        <div class="col-md-6">

                            <?php echo form_multiselect("offer_devices[]", $this->config->item('deviceType'), $offer_devices, "id='offer_devices' class='select2 form-control' ") ?>

                        </div>

                        <label class="col-md-2 control-label text-left" style="text-align:left;font-weight:normal">
                            <input type="checkbox" ng-model="Alloffer_devices"   name="Alloffer_devices" value="1" ng-click="onSelectAlloffer_devices()" /> All</label>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label text-left" style="">Platform (Optional)</label>
                        <div class="col-md-6">

                            <?php echo form_multiselect("offer_OS[]", $this->config->item('PlatformType'), $offer_os, "id='offer_OS' class='select2 form-control' ") ?>

                        </div>

                        <label class="col-md-2 control-label text-left" style="text-align:left;font-weight:normal">
                            <input type="checkbox" ng-model="Alloffer_OS"   name="Alloffer_OS" value="1" ng-click="onSelectAlloffer_OS()" /> All</label>
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

        $('#catForm').bootstrapValidator({
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
    viral_pro.controller("AddOfferGeoTarget", function ($scope) {

        $scope.message = "";
        $scope.saveBtn = "<?php echo $SubmitBtn ?>";
        $scope.redirection = 0;

        $scope.action = "<?php echo $FormAction ?>";

<?php 
if (!empty($post)) { 
    ?>
            $scope.image = "<?php echo $post['image'] ?>";
            $scope.title = "<?php echo $post['title'] ?>";
            //$scope.meta = new String("<?php //echo  $post['meta']  ?>");
            $scope.url_slug = "<?php echo $post['url_slug'] ?>";
            $scope.preview_link = "<?php echo $post['preview_link'] ?>";
    <?php
}

if (!empty($campaign)) {
    ?>
            $scope.title = "<?php echo $campaign['campaign_name'] ?>";
            $scope.globalCountry = <?php echo isset($campaign['geo']) && $campaign['geo'] == 1 ? "true" : 'false' ?>;
            
            $scope.Alloffer_OS = <?php echo isset($campaign['all_os']) && $campaign['all_os'] == 1 ? "true" : 'false' ?>;
            $scope.Alloffer_devices = <?php echo isset($campaign['all_devices']) && $campaign['all_devices'] == 1 ? "true" : 'false' ?>;


    <?php
}
?>

        $scope.onSelectGlobe = function ()
        {
            if ($scope.globalCountry)
                $("#offer_countries").select2("enable", false);
            else
                $("#offer_countries").select2("enable", true);
            //$scope.globalCountry";
        };
        
         $scope.onSelectAlloffer_devices = function ()
        {
            if ($scope.Alloffer_devices)
                $("#offer_devices").select2("enable", false);
            else
                $("#offer_devices").select2("enable", true);
            //$scope.globalCountry";
        };
        $scope.onSelectAlloffer_devices();

        $scope.onSelectAlloffer_OS = function ()
        {
            if ($scope.Alloffer_OS)
                $("#offer_OS").select2("enable", false);
            else
                $("#offer_OS").select2("enable", true);
            //$scope.globalCountry";
        };
        $scope.onSelectAlloffer_OS();


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


<?php
if (isset($campaign['geo'])) {
    ?>
            $scope.onSelectGlobe();
    <?php
}
?>

        $scope.CreateUpdateOfferGeoTarget = function () {

            if (!$("#catForm").data('bootstrapValidator').validate().isValid())
            {

                //alert("Form Not Valida");
                return  false;
            }


            var fom = $("#catForm")[0];

            console.log(fom);

            var formData = new FormData(fom);
            console.log(formData);

            $scope.saveBtn = "<?php echo $Submiting ?>";

            //var form = new FormData($("#catForm"));
            $.ajax({
                url: $scope.action,
                type: 'POST',
                dataType: 'json',
                data: $("#catForm").serialize(),
                success: function (data, textStatus, jqXHR) {
                    $scope.saveBtn = "<?php echo $SubmitBtn ?>";
                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
                        if ($scope.saveBtn != 'Update')
                            $("#catForm")[0].reset();

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

        $scope.getHttpPost = function ()
        {
            var url = $scope.preview_link;
            $.ajax({
                url: "<?php echo SITEURL . "admin/post/getPostDataHttp" ?>",
                type: 'POST',
                data: 'url=' + url,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $scope.title = data['title'];
                        $scope.meta = data['meta'];
                        $scope.image = data['image'];
                        $scope.$apply();
                    }

                }
            });
        };

    });
</script>
