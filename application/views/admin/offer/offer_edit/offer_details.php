<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default"  ng-controller="UpdateOffer">
            <div class="panel-heading"><h3 class="panel-title">

                    <?php echo $title ?></h3></div>
            <div class="panel-body">
                <form class="form-horizontal" id="OfferUpdateForm" role="form" ng-submit="UpdateOffer()">                                    

                    <div class="form-group">
                        <label class="col-md-2 control-label">Advertiser</label>
                        <div class="col-md-6">
                            <?php
                            echo form_dropdown("advertiser_id", $affiliates, isset($campaign['advertiser_id']) ? $campaign['advertiser_id'] : '', "class='form-control' ");
                            ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Account Manager</label>
                        <div class="col-md-6">
                            <?php
                            echo form_dropdown("manager", $AccManager, isset($campaign['manager']) ? $campaign['manager'] : '', "class='form-control' ");
                            ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Private</label>
                        <div class="col-md-6">
                            <?php
                            echo form_dropdown("private", $private, isset($campaign['private']) ? $campaign['private'] : '', "class='form-control' ");
                            ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Preview Link</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" ng-blur="getHttpPost()" ng-model="preview_link" value="<?php echo isset($post['preview_link']) ? $post['preview_link'] : '' ?>" name="preview_link">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Offer Name</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" ng-model="title" value="<?php echo isset($campaign['campaign_name']) ? $campaign['campaign_name'] : '' ?>" name="campaign_name">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-2 control-label">Description</label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="metadata"  name="meta" rows="5"><?php echo isset($post['meta']) ? $post['meta'] : '' ?></textarea>

                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-2 control-label">Tracking Link</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="url_slug" ng-model="url_slug" value="<?php echo isset($post['url_slug']) ? $post['url_slug'] : '' ?>" name="url_slug">
                             <input type="hidden" name="baseUrl_slug" value="{{baseUrl_slug}}" />
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-2 control-label">Category</label>
                        <div class="col-md-10">
                            <?php
                            echo form_multiselect("category_id[]", $category, isset($post['category_id']) ? $post['category_id'] : '', "class='form-control select2'   ");
                            ?>

                        </div>
                    </div>






                    <div class="form-group">
                        <label class="col-md-2 control-label">Image</label>
                        <div class="col-md-4">
                            <?php
                            if (!empty($post)) {
                                ?>
                                <input type="hidden" name="post_id" value="<?php echo isset($post['post_id']) ? $post['post_id'] : '' ?>"/>
                                <img  id='postImage' ng-src='{{image}}' style='width:200px' />
                                <?php
                            } else {
                                echo "<img  id='postImage' ng-src='{{image}}' style='width:200px;display:block'/>";
                            }
                            ?>
                            <input type="hidden" name="image" value="{{image}}" />
                            <input type="file" class="form-control" value="" name="image">
                        </div>
                    </div>






                    <div class="form-group">
                        <label class="col-md-2 control-label">Start Date</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control datepicker" value="<?php echo @date(OFFER_DATE_FROMAT_SHOW, strtotime(@$campaign['start_date']))  ?>" name="start_date">
                        </div>
                        <label class="col-md-2 control-label">End Date</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control datepicker" value="<?php echo @date(OFFER_DATE_FROMAT_SHOW, strtotime(@$campaign['end_date']))?>" name="end_date">
                        </div>

                    </div>



                    <div class="form-group">
                        <label class="col-md-2 control-label">Cap</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" value="<?php echo isset($campaign['cap']) ? $campaign['cap'] : '' ?>" name="cap">
                            <span class="help-block"><small>Set cap 0 if there is no limit</small></span>
                        </div>
                    </div>

                    <!--                     <div class="form-group">
                                            <label class="col-md-2 control-label">Per Impression Revenue(Affiliate) <?php echo CURR ?></label>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" value="<?php echo isset($campaign['per_impression_revenue']) ? $campaign['per_impression_revenue'] : '' ?>" name="per_impression_revenue">
                                            </div>
                                        </div>-->
                    <div class="form-group">
                        <label class="col-md-2 control-label">Conversion Status Rule</label>
                        <div class="col-md-6">
                            <?php
                            echo form_dropdown("conv_status", $this->config->item("conv_status"), isset($campaign['conv_status']) ? $campaign['conv_status'] : '', "class='form-control' ");
                            ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Redirection</label>
                        <div class="col-md-4">
                            <?php
                            echo form_dropdown("redirection", array("0" => "Disable", "1" => "Enable"), isset($campaign['redirection']) ? $campaign['redirection'] : '', "class='form-control' ng-model='redirection' ' ");
                            ?>
                        </div>
                    </div>

                    <div class="form-group "  ng-show="redirection==1"  >
                        <label class="col-md-2 control-label">Redirection Url</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control " value="<?php echo isset($campaign['redirectUrl']) ? $campaign['redirectUrl'] : '' ?>" name="redirectUrl">

                            <span style="width: 100%;    text-align: center;    display: block;    padding: 11px;    font-weight: bold;">OR</span>
                            
                            <select name="r_campaign_id" class="form-control campaign_id_select2">
                                <?php
                                 if(isset($campaign['r_campaign']['r_campaign_id']) && $campaign['r_campaign']['r_campaign_id'] !=''){
                                     echo "<option value='{$campaign['r_campaign']['r_campaign_id']}' selected='selected'>{$campaign['r_campaign']['campaign_name']}</option>";
                                 }
                                ?>
                            </select>   
                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Click Life Span</label>
                        <div class="col-md-4">
                            <input type="text" name="click_span"class="form-control" value="<?php echo isset($campaign['click_span']) ? $campaign['click_span'] : '' ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Status</label>
                        <div class="col-md-4">
                            <?php
                            echo form_dropdown("status", $camapign_status, isset($campaign['c_status']) ? $campaign['c_status'] : '', "class='form-control' ");
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Required Approval</label>
                        <div class="col-md-4">
                            <?php
                            echo form_dropdown("req_approval", array("1" => "Enable", "0" => "Disable"), isset($campaign['req_approval']) ? $campaign['req_approval'] : '', "class='form-control' ");
                            ?>
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

        $('#OfferUpdateForm').bootstrapValidator({
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
    viral_pro.controller("UpdateOffer", function ($scope) {

        $scope.message = "";
        $scope.saveBtn = "<?php echo $SubmitBtn ?>";
        $scope.redirection = '<?php echo isset($campaign['redirection']) ? $campaign['redirection'] : '0' ?>';

        $scope.action = "<?php echo $FormAction ?>";

<?php
if (!empty($post)) {
    ?>
            $scope.image = "<?php echo $post['image'] ?>";
            $scope.title = "<?php echo $post['title'] ?>";
            //$scope.meta = new String("<?php //echo  $post['meta']                   ?>");
            $scope.url_slug = "<?php echo $post['url_slug'] ?>";
            $scope.preview_link = "<?php echo $post['preview_link'] ?>";
    <?php
}

if (!empty($campaign)) {
    ?>
            $scope.title = "<?php echo $campaign['campaign_name'] ?>";


    <?php
}
?>
        



        $scope.UpdateOffer = function () {

            if (!$("#OfferUpdateForm").data('bootstrapValidator').validate().isValid())
            {

                //alert("Form Not Valida");
                return  false;
            }

            var url_slug=btoa($scope.url_slug);
            $scope.baseUrl_slug = url_slug;
            var fom = $("#OfferUpdateForm")[0];

            console.log(fom);

            var formData = new FormData(fom);
            console.log(formData);

            $scope.saveBtn = "<?php echo $Submiting ?>";

            //var form = new FormData($("#OfferUpdateForm"));
            $.ajax({
                url: $scope.action,
                type: 'POST',
                dataType: 'json',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
//                data: $("#OfferUpdateForm").serialize()+"&baseUrl_slug="+url_slug,
                success: function (data, textStatus, jqXHR) {
                    $scope.saveBtn = "<?php echo $SubmitBtn ?>";
                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
                        if ($scope.saveBtn != 'Update')
                            $("#OfferUpdateForm")[0].reset();

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
                        $("#metadata").text(data['meta']);
                        $scope.image = data['image'];
                        $scope.$apply();
                    }

                }
            });
        };



    });
</script>
