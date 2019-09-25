
<link href="<?php echo ASSETS ?>plugins/nestable/jquery.nestable.css" rel="stylesheet">

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading"><h3 class="panel-title">All Macros</h3></div>
            <div class="panel-body">


                <div class="row">
                    <div class="col-md-12">
                        <div class="dd" id="nestable_list_3">



                            <?php
//                                    echo '<pre>';
//                                    print_r($macro);
////                                    

                            if (isset($macro)) {
                                macro_list($macro, $cat_type);
                            }

                            function macro_list($macros, $cat_type) {
                                if (!empty($macros)) {
                                    ?>
                                    <ol class="dd-list">
                                        <?php
                                        foreach ($macros as $list) {
                                            ?>
                                            <li class="dd-item dd3-item" data-id="<?php echo $list['macro_id'] ?>">
                                                <div class="dd-handle dd3-handle"></div>
                                                <div class="dd3-content" id="cat<?php echo $list['macro_id'] ?>">
                                                    <?php echo $list['name'] ?>

                                                </div>
                                                <div class="editForm" id="formdiv<?php echo $list['macro_id'] ?>">


                                                    <form class="form-horizontal editFormData"  role="form" action="<?php echo SITEURL . "admin/macros/UpdateMacros" ?>">                                    
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Name</label>
                                                            <div class="col-md-10">
                                                                <input type="hidden" value="<?php echo $list['macro_id'] ?>" name="macro_id"/>
                                                                <input type="text" class="form-control" value="<?php echo $list['name'] ?>" name="name">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Description</label>
                                                            <div class="col-md-10">
                                                                <textarea name="description" class="form-control"><?php echo $list['description'] ?></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Status</label>
                                                            <div class="col-md-10">
                                                                <select name="status" class="form-control">
                                                                    <option <?php echo $list['status'] == 1 ? "selected='true'" : '' ?> value="1">Active</option>
                                                                    <option <?php echo $list['status'] == 0 ? "selected='true'" : '' ?> value="0">De-Active</option>
                                                                </select>
                                                            </div>
                                                        </div>



                                                        <div class="form-group"> 
                                                            <div class="col-sm-2">
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <button type="submit" class="btn btn-purple waves-effect waves-light">
                                                                    <span class="fa fa-save"></span>
                                                                    Save</button>
                                                                <button onclick="$('#formdiv<?php echo $list['macro_id'] ?>').hide()" type="button" class="btn btn-danger waves-effect waves-light">
                                                                    <span class="fa fa-remove"></span>
                                                                    Cancel</button>
                                                            </div>
                                                        </div>

                                                    </form>




                                                </div>
                                                <div class="editormenu">
                                                    <div disabled="" id="catStatus<?php echo $list['macro_id'] ?>" class=" btn-icon waves-effect btn-default m-b-5" >
                                                        <?php
                                                        if ($list['status'] == 1) {
                                                            echo "<span class='fa fa-check text-success'></sapn>";
                                                        } else {
                                                            echo "<span class='fa fa-remove text-danger'></sapn>";
                                                        }
                                                        ?>
                                                    </div>
                                                    <button onclick="$('#formdiv<?php echo $list['macro_id'] ?>').show()" href=""  type="button" class="btn btn-primary waves-effect btn-xs waves-light "><span class="fa fa-edit"></span></button>
                                                    <button type="button" onclick="delete_Macros('<?php echo $list['macro_id'] ?>')" class="btn btn-danger waves-effect btn-xs waves-light "><span class="fa fa-trash"></span></button>
                                                </div>




                                                <?php
                                                //macro_list($list['child'],$cat_type);
                                                ?>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ol>
                                    <?php
                                }
                            }
                            ?>        

                        </div>
                        <button class="btn btn-primary waves-effect waves-light m-b-5 btn-sm" onclick="saveSorting()">
                            <span class="fa fa-save"></span>    Save
                        </button>
                    </div>
                </div> <!-- End row -->
                <script>
                    $("form.editFormData").submit(function (e) {
                        e.preventDefault();
                        //var formEdit=$(this);
                        var form = $(this).serialize();
                        var url = $(this).attr("action");
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: form,
                            dataType: 'json',
                            success: function (data, textStatus, jqXHR) {
                                if (data['success'])
                                {
                                    $.Notification.autoHideNotify('success',
                                            'botton right',
                                            data['msg'],
                                            '');

                                    $("#cat" + data['data']['macro_id']).text(data['data']['name']);

                                    if (data['data']['status'] === "1")
                                    {
                                        $("#catStatus" + data['data']['macro_id']).html("<span class='fa fa-check text-success'></sapn>");
                                    } else
                                    {
                                        $("#catStatus" + data['data']['macro_id']).html("<span class='fa fa-remove text-danger'></sapn>");
                                    }

                                    $("#formdiv" + data['data']['macro_id']).hide();
                                    //$("#catForm")[0].reset();
                                } else {
                                    $.Notification.autoHideNotify('error',
                                            'botton right',
                                            data['msg'],
                                            '');
                                }

                            }

                        });

                    });

                    function delete_Macros(macro_id)
                    {
                        swal({
                            title: "Are you sure?",
                            text: "Your will not be able to recover this imaginary file!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonClass: "btn btn-sm btn-danger waves-effect waves-light",
                            confirmButtonText: "Yes, delete it!",
                            closeOnConfirm: true,
                            closeOnCancel: true
                        }, function (isconfirm) {
                            if (isconfirm)
                            {
                                $.ajax({
                                    url: "<?php echo SITEURL . "admin/macros/deleteMacros" ?>",
                                    type: 'POST',
                                    data: "macro_id=" + macro_id,
                                    dataType: 'json',
                                    success: function (data, textStatus, jqXHR) {
                                        if (data['success'])
                                        {
                                            $.Notification.autoHideNotify('success',
                                                    'botton right',
                                                    data['msg'],
                                                    '');

                                            $("li[data-id='" + macro_id + "']").remove();

                                            //$("#catForm")[0].reset();
                                        } else {
                                            $.Notification.autoHideNotify('error',
                                                    'botton right',
                                                    data['msg'],
                                                    '');
                                        }

                                    }

                                });
                            }
                        });



                    }



                    function saveSorting()
                    {
                        var list = $("#nestable_list_3"),
                                output = list.data('output');

                        console.log(list);
                        if (window.JSON) {
                            // var c = output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
                            var c = window.JSON.stringify(list.nestable('serialize'));

                            $.ajax({
                                url: "<?php echo SITEURL . "admin/macros/macro_sort" ?>",
                                type: 'POST',
                                data: 'data=' + c,
                                success: function (data, textStatus, jqXHR) {
                                    $.Notification.autoHideNotify('success',
                                            'botton right',
                                            "Categories Sorted",
                                            '');
                                }

                            });


                            console.log(c);
                        } else {
                            output.val('JSON browser support required for this demo.');
                        }
                    }
                </script>



            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col -->
</div>