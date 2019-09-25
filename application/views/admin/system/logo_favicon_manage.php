
<link href="<?php echo ASSETS ?>vendor/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css"/>
<style>
    .dropzone {
        min-height: 0;
        border: 1px solid rgba(0, 0, 0, 0.3);
        background: white;
        padding: 20px 20px;
    }

    .dropzone .dz-message
    {
        text-align: center;
        margin: 0em 0;
    }
    .dropzone .dz-message {
        font-size: 18px;
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default"  >
            <div class="panel-heading"><h3 class="panel-title">Upload Logo</h3></div>
            <div class="panel-body">
                <div class="col-md-12 form-group text-center" ng-if="'<?php echo @LOGO ?>' != 'LOGO'">
                    <img width="300" src="<?php echo @LOGO ?>"/>
                    <br>
                    <button style="width: 100px;
                            margin: 10px auto 0;" 
                            onclick="update_sys_option('LOGO')"
                            class="btn btn-danger btn-xs"><span class="fa fa-close"></span></button>
                </div>

                <div class="col-md-12 form-group">
                    <form  action="<?php echo SITEURL . "admin/system/setup_logo_favicon" ?>" class="dropzone">
                        <div class="fallback">
                            <input name="file" type="file" accept="image/x-png,image/gif,image/jpeg" multiple />
                        </div>
                        <input name="type" type="hidden" value="logo"/>
                    </form>
                </div>
            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col -->
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default"  >
            <div class="panel-heading"><h3 class="panel-title">Upload Favicon</h3></div>
            <div class="panel-body">
                <div class="col-md-12 form-group text-center" ng-if="'<?php echo @FAVICON ?>' != 'FAVICON'">
                    <img width="50" src="<?php echo @FAVICON ?>"/>  
                    <br>
                    <button style="width: 100px;
                            margin: 10px auto 0;" onclick="update_sys_option('FAVICON')" class="btn btn-danger btn-xs"><span class="fa fa-close"></span></button>
                </div>

                <div class="col-md-12 form-group">
                    <form action="<?php echo SITEURL . "admin/system/setup_logo_favicon" ?>" class="dropzone">
                        <div class="fallback">
                            <input name="file" type="file" accept="image/x-png,image/gif,image/jpeg" multiple />

                        </div>
                        <input name="type" type="hidden" value="favicon"/>
                    </form>
                </div>

            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col -->
</div>

<script>

    function update_sys_option(option_name) {

        $.ajax({
            url: "<?php echo SITEURL . "admin/system/remove_logo_favicon" ?>",
            type: 'POST',
            data: "option_name=" + option_name,
            dataType: 'json',
            success: function (data, textStatus, jqXHR) {
                if (data['success']) {
                    $.Notification.autoHideNotify('success',
                            'botton right',
                            data['msg'],
                            '');
                    location.reload();
                } else
                {
                    $.Notification.autoHideNotify('error',
                            'botton right',
                            data['msg'],
                            '');
                }
            }

        })

    }


//    var myDropzone = new Dropzone(".dropzone", { url: ""});
    Dropzone.options.FileUploader = {
        init: function () {
            this.on("success", function (file) {

                console.log(file);
                $.Notification.autoHideNotify('success',
                        'botton right',
                        "Uploaded",
                        '');
                        location.reload();
//                angular.element(document.getElementById('AllCreativerContainer')).scope().searchByForm();

            });


        },
        accept: function (file, done) {
            console.log(file);
            if (file.type != "image/jpeg" && file.type != "image/png") {
                done("Error! Files of this type are not accepted");
            } else {
                done();
            }
        }



    };
</script>
