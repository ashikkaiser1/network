<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default"  ng-controller="AddMacro">
            <div class="panel-heading"><h3 class="panel-title">Create new macros</h3></div>
            <div class="panel-body">
                <form class="form-horizontal" id="MacroForm" role="form" ng-submit="CreateMacros()">                                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Name</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" value="" name="name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Description</label>
                        <div class="col-md-10">
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Status</label>
                        <div class="col-md-4">
                            <select name="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">De-Active</option>
                            </select>
                        </div>
                    </div>



                    <div class="form-group"> 
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-10">

                            <button type="submit" class="btn btn-purple waves-effect waves-light">
                                <span class="fa fa-save"></span>
                                {{saveBtn}}</button>
                            <button type="Reset" class="btn btn-danger waves-effect waves-light">
                                <span class="fa fa-remove"></span>Cancel</button>
                        </div>
                    </div>

                </form>
            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col -->
</div>
<script>
    $(function () {

        $('#MacroForm').bootstrapValidator({
            message: false,
//            container: 'tooltip',
            trigger: null,
            live: 'enabled',
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
                            regexp: /^[a-zA-Z0-9_\s]+$/,
                            message: 'Invalid Name'
                        },
                        stringLength: {
                            min: 3,
                            max: 25,
                            message: 'Name must be 3 to 25 characters long'
                        }
                    }
                }

            }

        }).on('success.form.bv', function (e) {
            e.preventDefault();

        });
    });
</script>
<script>
    //var Category = angular.module("Category", []);
    viral_pro.controller("AddMacro", function ($scope) {

        $scope.message = "";
        $scope.saveBtn = "Save";


        $scope.action = "<?php echo SITEURL . "admin/macros/CreateMacro" ?>";



        $scope.CreateMacros = function () {


            if (!$("#MacroForm").data('bootstrapValidator').validate().isValid())
            {

                return  false;
            }

            $scope.saveBtn = "Creating";
            var fom = $("#MacroForm")[0];
            $scope.saveBtn = "<?php echo $Submiting ?>";

            console.log(fom);

            var formData = new FormData(fom);
            console.log(formData);

            //var form = new FormData($("#MacroForm"));
            $.ajax({
                url: $scope.action,
                type: 'POST',
                dataType: 'json',
                data: $("#MacroForm").serialize(),
                success: function (data, textStatus, jqXHR) {

                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');

                        $("#MacroForm")[0].reset();
                        window.location.reload();
                    } else {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                    }
                    $scope.saveBtn = "Save";
                    $scope.$apply();
                }

            });



        };

    });
</script>
<?php
if (isset($allMacros))
    echo $allMacros;
?>