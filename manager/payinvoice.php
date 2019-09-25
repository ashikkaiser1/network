<?php
require("dbConfig.php");
$id = $_GET['id'];


$sql = "DELETE FROM users_balance WHERE uid = '$id' ";
if ($conn->query($sql) === TRUE) {
   $sqlupdate = "UPDATE payment_ledger SET paid_status='1' WHERE pay_id = '$id'";
   if ($conn->query($sqlupdate) === TRUE) {
       $msg =  "Invoice Paid successfully";
       header("Location: /manager/unpaid-invoice.php/?getmsg=".$msg);
   }else{
       echo "gud";
   }
}else{
    echo "fuck";
}

?>