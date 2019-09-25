Hello!  <?php echo $name ?> ,<br>
Important Notification from <?php echo SITENAME ?><br>
Your account status is
<?php
$mystatus = "InActive";
switch ($status) {
    case 0: $mystatus = "InActive";
        break;
    case 1: $mystatus = "Active";
        break;
    case 2: $mystatus = "Pending";
        break;
    case 3: $mystatus = "Blocked";
        break;
    case 4: $mystatus = "Rejected";
        break;

    default:
        break;
}
?>
<h4><?php echo $mystatus; ?></h4>
<a href="<?php echo SITEURL ?>"> <?php echo SITENAME ?></a><br>
Thanks<br>
Team <?php echo SITENAME ?><br>