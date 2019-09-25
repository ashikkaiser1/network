<?php
require("dbConfig.php");
$publisher = $_POST['publisher'];
$start_date= $_POST['start-date'];
$end_date = $_POST['end-date'];
$invoice_amount = "0";
if($_POST['filter-salles']){
$sql="SELECT COUNT(tr_id) As total FROM transactions Where uid = '$publisher' AND c_valid ='1' AND payment_status='0' AND dbTime Between '$start_date' AND '$end_date'";
$result = mysqli_query($conn,$sql);
$values = mysqli_fetch_assoc($result);
$count = mysqli_num_rows($result);
$number_rows = $values['total'];
$camp_id_sql = "SELECT campaign_id FROM transactions  Where uid = '$publisher' AND   c_valid ='1' AND payment_status='0' AND dbTime Between '$start_date' AND '$end_date'";
$camp_id = $conn->query($camp_id_sql);
 while($row = $camp_id->fetch_assoc()) {
     $camp_selected_id = $row['campaign_id'];
     $camp_rate_by_id_sql = "SELECT * FROM campaign WHERE campaign_id = '$camp_selected_id'";
     $camp_rate_by_id = $conn->query($camp_rate_by_id_sql);
     $row = $camp_rate_by_id->fetch_assoc();
     $payout_cost = $row['payout_cost'];
     $invoice_amount +=  $payout_cost;
    
}
   if($invoice_amount > 0){
        $sql = "INSERT INTO users_balance (uid, balance)
    VALUES ('$publisher', '$invoice_amount')";
    
    if ($conn->query($sql) === TRUE) {
        
        $sqlpaynebt = "INSERT INTO payment_ledger (uid, amt, mode, status)
       VALUES ('$publisher', '$invoice_amount', 'cash',  '1')";
        
        if($conn->query($sqlpaynebt) === TRUE){
            
            $sqlupdate = "UPDATE transactions SET payment_status='1' WHERE uid= '$publisher'";

                if ($conn->query($sqlupdate) === TRUE) {
                    
                    
                    $msg =  "Invoice Created successfully";
                    header("Location: /manager/index.php/?getmsg=".$msg);

                } else {
                    echo "Error updating record: " . $conn->error;
                }
                            
        }else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        
        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
   }else{
                    $msg =  "Error : Invoice Amount Less Than $1";
                    header("Location: /manager/index.php/?getmsg=".$msg);
   }
}
echo $invoice_amount;

?>