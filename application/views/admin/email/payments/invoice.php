<?php
echo "Hi " . $name;
echo '<br>';
echo ""
?>

<style>
    table.emailTable td{

    }

</style>
<table  class="emailTable" style="    border: 1px solid #d6d1d1;
        border-collapse: collapse;">
    <tr>
        <td style="background: #1eb7c7;
            color: white;
            font-size: 18px;
            padding: 7px;">Transaction ID</td>
        <td><?php echo @$trn_no ?></td>
    </tr>
    <tr>
        <td style="background: #1eb7c7;
            color: white;
            font-size: 18px;
            padding: 7px;">Date</td>
        <td><?php echo date(OFFER_DATE_FROMAT_SHOW, strtotime($dateTime)) ?></td>
    </tr>
    <tr>
        <td style="background: #1eb7c7;
            color: white;
            font-size: 18px;
            padding: 7px;">Mode</td>
        <td><?php echo @$mode ?></td>
    </tr>
    <tr>
        <td style="background: #1eb7c7;
            color: white;
            font-size: 18px;
            padding: 7px;">Amount</td>
        <td><?php echo CURR . " " . @$amt ?></td>
    </tr>
    <tr>
        <td style="background: #1eb7c7;
            color: white;
            font-size: 18px;
            padding: 7px;">Status</td>
        <td><?php
            switch ($status) {
                case 1: echo "Approved";
                    break;
                case 0: echo "Canceled";
                    break;

                default:
                    break;
            }
            ?></td>
    </tr>
</table>


Thanks<br>
Team <?php echo SITENAME ?><br>



