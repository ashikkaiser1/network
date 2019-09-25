<?php
if (isset($campaign) && !empty($campaign)) {
    ?>

    <div class="row">
      
        <div class="col-lg-2">
            <span class="NameAppilcant" style="background-color: <?php echo '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT); ?>">
            <?php echo substr($user['name'], 0, 1)  ?>
            </span>
        </div>
        <div  class="col-lg-10">
            <a class="pull-right" href="<?php echo SITEURL."admin/campaign/show_offer_request/".$request_id ?>"><span class=" fa fa-info-circle text-primary "></span></a>
            <p> 
                <a href="<?php echo SITEURL . "admin/users/ViewUser/{$user['uid']}" ?>"><?php echo $user['name'] ?></a> submitted a request for offer <a href="<?php echo SITEURL."admin/campaign/offerRequest/{$campaign['campaign_id']}" ?>"><?php echo $campaign['campaign_name'] ?></a>
            </p>
            <div class="col-md-12">
                <button class="btn btn-primary btn-sm waves-effect waves-light" type="button" onclick="approve('<?php echo $request_id ?>','<?php echo $user['uid'] ?>', '<?php echo $campaign['campaign_id'] ?>')"><span class="fa fa-check"></span> Approve</button>
                <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" onclick="reject('<?php echo $request_id ?>', '<?php echo $user['uid'] ?>', '<?php echo $campaign['campaign_id'] ?>')"><span class="fa fa-remove"></span> Reject</button>
            </div>
            
        </div>

    </div>

    <?php
}
?>

