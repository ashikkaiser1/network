<div class="col-sm-12">
    <div class="panel panel-default" >
        <div class="panel-heading">
            <h3 class="panel-title">
                Group Payout  


            </h3></div>
        <div class="panel-body">
            <div class="row">
                <?php
                if (!empty($campaign)) {
                    ?>   
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">

                           

                            <div class="row">
                                <div class="col-md-12" id="ShowAddPayoutFrom">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Payout Type</label>
                                        <div class="col-md-12">
                                            <?php
                                            echo form_dropdown("payout_type", $payoutList, isset($campaign['payout_type']) ? $campaign['payout_type'] : '', "class='form-control'");
                                            ?>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Payout Cost <?php echo CURR ?></label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control " value="<?php echo isset($campaign['payout_cost']) ? $campaign['payout_cost'] : '' ?>" name="payout_cost">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Group</label>
                                        <div class="col-md-12">
                                            <?php
                                            echo form_multiselect("group_id", $usr_group, '', "class='form-control select2' ");
                                            ?>

                                        </div>
                                    </div>
                                    
                                     <div class="form-group">
                                        <label class="col-md-12 control-label"></label>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-purple waves-effect waves-light" ><span class="fa fa-save"></span> Save</button>
                                        </div>
                                    </div>



                                </div>

                            </div>

                        </div> 
                    </div>

                <?php } ?>

            </div>
        </div>
    </div>
</div>




<script>
    $("#ShowAddPayout").click(function() {

        $("#ShowAddPayoutFrom").toggleClass("hidden");

    });
</script>