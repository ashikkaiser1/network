
<link href="<?php echo ASSETS ?>vendor/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css"/>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default"  >
            <div class="panel-heading"><h3 class="panel-title">Upload Creative</h3></div>
            <div class="panel-body">
                <form id="FileUploader" action="<?php echo SITEURL . "admin/creative/upload_creative" ?>" class="dropzone">
                    <div class="fallback">
                        <input name="file" type="file" multiple />
                    </div>
                    
                </form>
            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col -->
</div>

<script>
//    var myDropzone = new Dropzone(".dropzone", { url: ""});
    Dropzone.options.FileUploader = {
        init: function () {
            this.on("success", function (file) {

                $.Notification.autoHideNotify('success',
                        'botton right',
                        "Creative Uploaded",
                        '');
                angular.element(document.getElementById('AllCreativerContainer')).scope().searchByForm();

            });
        }
    };
</script>

<?php
if (isset($allCreative))
    echo $allCreative;
?>