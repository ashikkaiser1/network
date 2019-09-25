
<link href="<?php echo ASSETS ?>vendor/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css"/>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default"  >
            <div class="panel-heading"><h3 class="panel-title">Upload Conversion List File
                     <div class="pull-right">
                        <a href="<?php echo UPLOAD . "offers/conversion_template.csv" ?>" class=" btn btn-pink waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-download"></span> Template</a>

                    </div>
                
                </h3></div>
            <div class="panel-body">
                <form id="FileUploader" action="<?php echo SITEURL . "admin/conversion_report/chang_conversion" ?>" class="dropzone">
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
                        "Conversion Uploaded",
                        '');


            });
        }
    };
</script>

