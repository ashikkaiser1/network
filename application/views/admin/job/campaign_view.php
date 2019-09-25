<div class="form-group">
    <label class="col-md-2 control-label" >Campaign</label>
    <div class="col-md-10">
        <?php echo form_multiselect("job_data[campaign_id][]",$campaign ,isset($autoSelect['campaign_id']) ? $autoSelect['campaign_id'] : '', "class='form-control select2 '") ?>  

    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">Campaign Status</label>
    <div class="col-md-4">
        <?php
        echo form_dropdown("job_data[status]", $this->config->item('campaign_status'), isset($autoSelect['status']) ? $autoSelect['status'] : '', "class='form-control' ");
        ?>
    </div>
</div>

