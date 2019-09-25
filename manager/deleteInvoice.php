<?php
require("dbConfig.php");
$id = $_GET['id'];

$sql = "DELETE FROM payment_ledger WHERE pay_id = '$id'";
if ($conn->query($sql) === TRUE) {
       $msg =  "Invoice Deleted successfully";
       header("Location: /manager/unpaid-invoice.php/?getmsg=".$msg);
   }else{
       echo "gud";
   }

?>