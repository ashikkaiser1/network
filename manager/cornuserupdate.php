<?php
require("dbConfig.php");
             $sql = "SELECT * FROM users WHERE UTID='2'";
             $result = $conn->query($sql);
             $start_date= $_POST['start-date'];
             $end_date = $_POST['end-date'];
            
                        while($row = $result->fetch_assoc()) {
                            $affid = $row['uid'];
                            $invoice_amount = "0";
                                 $camp_id_sql = "SELECT campaign_id FROM transactions  Where uid = '$affid' AND   c_valid ='1' AND payment_status='0' AND dbTime Between '$start_date' AND '$end_date'";
                                 $camp_id = $conn->query($camp_id_sql);
                                 while($row = $camp_id->fetch_assoc()) {
                                 $camp_selected_id = $row['campaign_id'];
                                 $camp_rate_by_id_sql = "SELECT * FROM campaign WHERE campaign_id = '$camp_selected_id'";
                                 $camp_rate_by_id = $conn->query($camp_rate_by_id_sql);
                                 $row = $camp_rate_by_id->fetch_assoc();
                                 $payout_cost = $row['payout_cost'];
                                 $invoice_amount +=  $payout_cost;
                                 }
                                 
                                 
                                if($invoice_amount > 0) {
           
                               $sql = "INSERT INTO users_balance (uid, balance)
                                VALUES ('$affid', '$invoice_amount')";
                                
                                if ($conn->query($sql) === TRUE) {
                                    
                                    $sqlpaynebt = "INSERT INTO payment_ledger (uid, amt, mode, status)
                                   VALUES ('$affid', '$invoice_amount', 'cash',  '1')";
                                    
                                    if($conn->query($sqlpaynebt) === TRUE){
                                        
                                        $sqlupdate = "UPDATE transactions SET payment_status='1' WHERE uid= '$affid'";
                            
                                            if ($conn->query($sqlupdate) === TRUE) {
                                                
                                              
                                              $msg =  "Invoice Created successfully";
                                              header("Location: /manager/unpaid-invoice.php/?getmsg=".$msg);
                            
                                            } else {
                                                $msg =  "Invoice Created successfully";
                                              header("Location: /manager/unpaid-invoice.php/?getmsg=".$msg);
                                            }
                                                        
                                    }else {
                                        $msg =  "Invoice Created successfully";
                                              header("Location: /manager/unpaid-invoice.php/?getmsg=".$msg);
                                    }
                                               
                                           }else{
                                             $msg =  "Invoice Created successfully";
                                              header("Location: /manager/unpaid-invoice.php/?getmsg=".$msg);
                                           }
                                      
                                    }else{
                                        
                                         $msg =  "Invoice Created successfully";
                                              header("Location: /manager/unpaid-invoice.php/?getmsg=".$msg);
                                    }
                                 
                                 
                                 
                                 
                        }
                            
                
?>    