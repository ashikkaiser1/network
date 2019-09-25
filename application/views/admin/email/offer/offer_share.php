<?php
echo "Hi " . $user['name'];
echo '<br>';
echo $email_msg;
?>

<?php
foreach ($campaign as $row) {
    ?>

    <div style="
         border: 1px solid #f1f1f1;
         background: whitesmoke;
         padding: 4px;
         margin: 4px;
         ">
        <h4 style="
            font-size: 18px;
            font-weight: bold !important;margin: 0px auto;
            "><?php echo $row['campaign_name'] ?></h4>
        <h6 style="color: #15bb15; font-size: 15px;margin: 5px auto;
            ">Payout(<?php echo CURR ?>) : <?php echo $row['payOutTypeName'] . ", " . $row['payout_cost'] ?></h6>

        <a href="<?php echo SITEURL . "affiliate/campaign/offerRequest/" . $row['campaign_id']; ?>" style="
           border: 1px solid green;
           background: green;
           color: white;
           padding: 3px;
           text-transform: uppercase;
           text-decoration: none;
           ">Get the Offer </a>


    </div>



    <?php
}
?>

<br>

Thanks<br>
Team <?php echo SITENAME ?><br>



