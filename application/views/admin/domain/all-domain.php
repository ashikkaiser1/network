<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading"><h3 class="panel-title">All Tracking Domain</h3></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Url</th>
                                        <th>Using</th>
                                        <th>Status</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($domain)) {
                                        $i = 1;
                                        foreach ($domain as $dom) {
                                            ?>
                                            <tr id="tr<?php echo $dom['domain_id'] ?>">
                                                <td><?php echo $dom['domain_id'] ?></td>
                                                <td><?php echo $dom['domain_name'] ?></td>
                                                <td><?php echo $dom['domain_url'] ?></td>
                                                <td>

                                                    <?php
                                                    if ($dom['default'] == 1) {
                                                        echo "<span class='fa fa-circle text-success'></sapn>";
                                                    } else {
                                                        echo "<span class='fa fa-circle text-danger'></sapn>";
                                                    }
                                                    ?>
                                                </td>
                                                <td>

                                                    <?php
                                                    if ($dom['status'] == 1) {
                                                        echo "<span class='fa fa-check text-success'></sapn>";
                                                    } else {
                                                        echo "<span class='fa fa-remove text-danger'></sapn>";
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <a type="button" href="<?php echo SITEURL . "admin/domain/UpdateDomain/" . $dom['domain_id'] ?>" class="btn btn-primary waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span></a>
                                                    <button type="button" onclick="delete_domain('<?php echo $dom['domain_id'] ?>')" class="btn btn-danger waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-trash"></span></button>
                                                    <a title="Set as tracking domain" type="button" href="<?php echo SITEURL . "admin/domain/setdefault/" . $dom['domain_id'] ?>" class="btn btn-pink waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-gear"></span></a>
                                                </td>

                                            </tr>


                                            <?php
                                        }
                                    }
                                    ?>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col -->
</div>

<script>
    function delete_domain(domain_id)
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
                    url: "<?php echo SITEURL . "admin/domain/deletedomain" ?>",
                    type: 'POST',
                    data: "domain_id=" + domain_id,
                    dataType: 'json',
                    success: function (data, textStatus, jqXHR) {
                        if (data['success'])
                        {
                            $.Notification.autoHideNotify('success',
                                    'botton right',
                                    data['msg'],
                                    '');

                            $("#tr" + domain_id).remove();

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
</script>