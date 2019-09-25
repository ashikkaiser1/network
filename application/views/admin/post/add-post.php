<div class="row">
    <div class="col-sm-12">
        <div id="postDiv" class="panel panel-default"  ng-controller="AddUpdatePost">
            <div class="panel-heading"><h3 class="panel-title">
                    <a href="<?php echo SITEURL . "admin/post/show_post" ?>" class=" btn btn-info waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-list"></span> All Post </a>
                    <?php echo $title ?></h3></div>
            <div class="panel-body">
                <form class="form-horizontal" id="postForm" role="form" > 


                    <div class="form-group">
                        <label class="col-md-2 control-label">Website</label>
                        <div class="col-md-4">
                            <?php
                            echo form_dropdown("web_id", $website, isset($post['web_id']) ? $post['web_id'] : '', "class='form-control'");
                            ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Url</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" ng-blur="getHttpPost()" ng-model="url_slug" value="<?php echo isset($post['url_slug']) ? $post['url_slug'] : '' ?>" name="url_slug">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-2 control-label">Category</label>
                        <div class="col-md-8">
                            <?php
                            echo form_multiselect("category_id[]", $category, isset($post['category_id']) ? $post['category_id'] : '', "class='form-control select2'   ");
                            ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Campaign</label>
                        <div class="col-md-4">
                            <?php
                            echo form_dropdown("campaign_id", $campaign, isset($post['campaign_id']) ? $post['campaign_id'] : '', "class='form-control select2'   ");
                            ?>

                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-2 control-label">Title</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" ng-model="title" value="<?php echo isset($post['title']) ? $post['title'] : '' ?>" name="title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Description</label>
                        <div class="col-md-8">
                            <textarea class="form-control" name="meta" rows="5"><?php echo isset($post['meta']) ? $post['meta'] : '' ?></textarea>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Image</label>
                        <div class="col-md-4">
                            <?php
                            if (!empty($post)) {
                                ?>

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
                        <label class="col-md-2 control-label">Status</label>
                        <div class="col-md-4">


                            <?php
                            echo form_dropdown("status", array("1" => "Active", "0" => "De-Active"), isset($post['status']) ? $post['status'] : '', "class='form-control' ");
                            ?>


                        </div>
                    </div>


                    <div class="form-group"> 
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-10">

                            <button type="button" class="btn btn-purple waves-effect waves-light" ng-click="add_post()">{{saveBtn}}</button>
                            <button type="Reset" class="btn btn-danger waves-effect waves-light">Cancel</button>
                        </div>
                    </div>

                </form>
            </div> <!-- panel-body -->
            <script>
                        $(function () {

                            $('#postForm').bootstrapValidator({
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
                                }

                            }).on('data-bv-onsuccess',function(e){
                                e.preventDefault();
                            });


//                                angular.element(document.getElementById('postDiv')).scope().add_post();
//                                var $form = $(e.target);
//                                $form.bootstrapValidator('resetForm', true);
                            // $('#postDiv').scope().add_post();
                            //  sweetAlert("Oops...", "Please Fill Form Correctly!", "error");
                        });
            </script>



        </div> <!-- panel -->
    </div> <!-- col -->
</div>
<script>


  //  var post = angular.module("post", []);
    viral_pro.controller("AddUpdatePost", function ($scope) {

        $scope.message = "";
        $scope.saveBtn = "<?php echo $SubmitBtn; ?>";
        $scope.action = "<?php echo $FormAction; ?>";



<?php
if (!empty($post)) {
    ?>
            $scope.image = "<?php echo $post['image'] ?>";
            $scope.title = "<?php echo $post['title'] ?>";
       
            $scope.url_slug = "<?php echo $post['url_slug'] ?>";

    <?php
}
?>


        $scope.getHttpPost = function ()
        {
            var url = $scope.url_slug;
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

        $scope.add_post = function () {

            var fom = $("#postForm")[0];
           // $("#postForm").data('bootstrapValidator').validate();

            //;
            if (!$("#postForm").data('bootstrapValidator').validate().isValid())
            {

                //alert("Form Not Valida");
                return  false;
            }

            $scope.saveBtn = "<?php echo $Submiting ?>";

            console.log(fom);

            var formData = new FormData(fom);
            console.log(formData);

            $.ajax({
                url: $scope.action,
                type: 'POST',
                data: formData,
                dataType: 'json',
//                async: false,
                success: function (data) {

                    console.log(data);

                    if (data['success'])
                    {

                        if ($scope.saveBtn !== 'Update')
                            $('#postForm')[0].reset();
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');

                        $("#postForm")[0].reset();
                    } else {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                    }
                    $scope.saveBtn = "<?php echo $SubmitBtn; ?>";


                    $scope.$apply();
                },
                cache: false,
                contentType: false,
                processData: false
            });

        };

    });
</script>
