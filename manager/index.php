<?php
require("dbConfig.php");
	$sql = "SELECT * FROM users WHERE UTID='2'";
    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="/manager/app.css">
    <title>Manager Panel</title>
</head>
<body>
<header>
        <nav>
            <h1>Manager Panel</h1>
            <ul class="link-list">
                <li>
                    <a href="/manager/index.php">Home</a> || 
                    <a href="/manager/createBulk.php">Bulk Create</a> || 
                    <a href="/manager/unpaid-invoice.php">Unpaid Invoces</a> || 
                    <a href="/manager/paid-invoices.php">Paid Invoces</a>
                </li>
            </ul>
        </nav>
    </header>
    <div class="container">
                 <?php if($_GET['getmsg']) {
                echo $_GET['getmsg'] ;
                echo "</br>";
            }
            
            ?>
            
        <form id="my-form" class="filter-form" action="filter-action.php" method="POST">
            <div class="form-input">
                <lebel class="form-lebel" for="publisher">Publisher</lebel>
                
                <select class="form-group" name="publisher" style="width: 250px;height: 35px;">
                    <option value=""> Choose From Any One Customer  </option>
                    <?php
                        while($row = $result->fetch_assoc()) {
                            
                        ?>
                        <option value="<?php echo $row['uid'] ?>"><?php echo $row['name'];   ?> (<?php $invoice_amount = "0";
                                        $aff_id = $row['uid'];
                                    $camp_id_sql = "SELECT campaign_id FROM transactions  Where uid = '$aff_id' AND   c_valid ='1' AND payment_status='0'";
                                      $camp_id = $conn->query($camp_id_sql);
                                         while($row = $camp_id->fetch_assoc()) {
                                     $camp_selected_id = $row['campaign_id'];
                                     $camp_rate_by_id_sql = "SELECT * FROM campaign WHERE campaign_id = '$camp_selected_id'";
                                     $camp_rate_by_id = $conn->query($camp_rate_by_id_sql);
                                     $row = $camp_rate_by_id->fetch_assoc();
                                     $payout_cost = $row['payout_cost'];
                                     $invoice_amount +=  $payout_cost;
                                    
                                    
                                }
                             echo "$".$invoice_amount; ?>)
                        
                        </option>
                    <?php } ?>
                </select>
               
            </div>
            <div class="form-input">
                <lebel class="form-lebel" for="start-date"> Period Starting Date</lebel>
                <input type="date" name="start-date" class="form-group" id="start-date" value="<?php echo date('Y-m-d',time()+( -6 - date('w'))*24*3600); ?>">
            </div>
             <div class="form-input">
                <lebel class="form-lebel" for="end-date"> Period Ending Date</lebel>
                <input type="date" name="end-date" class="form-group" id="end-date" value="<?php echo date('Y-m-d',time()+( 0 - date('w'))*24*3600); ?>">
            </div>
              <div class="form-input">
                <input type="submit" name="filter-salles" class="form-group btn" id="filtter-sells">
            </div>
               
        </form>
        <div class="publisher-balance" style="z-index: -1;">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    
                    <tr>
                        <th>Affilite Id</th>
                        <th>Affiliate Name</th>
                        <th>Total Unpaid Sales</th>
                        <th>Unpaid Balance</th>
                        <th>Status</th>
                       
                    </tr>
                  
                </thead>
                <tbody>
                     <?php
                     	$sql = "SELECT * FROM users WHERE UTID='2'";
                            $affresult = $conn->query($sql);
                        while($affrow = $affresult->fetch_assoc()) {
                            
                        ?>
                    <tr>
                        <td>#<?php echo $affrow['uid'] ?></td>
                        <td><?php echo $affrow['name'] ?></td>
                        <td>
                            
                            <?php 
                                    $aff_id = $affrow['uid'];
                                    $sql="SELECT COUNT(tr_id) As total FROM transactions Where  c_valid ='1' AND uid = '$aff_id' AND payment_status='0'";
                                    $result = mysqli_query($conn,$sql);
                                    $values = mysqli_fetch_assoc($result);
                                    $count = mysqli_num_rows($result);
                                    $number_rows = $values['total'];
                                    echo $number_rows;
                                    
                                    
                                    
                            ?>
                            
                            
                        </td>
                        <td>
                            
                            <?php   
                                    $invoice_amount = "0";
                                    $camp_id_sql = "SELECT campaign_id FROM transactions  Where uid = '$aff_id' AND   c_valid ='1' AND payment_status='0'";
                                      $camp_id = $conn->query($camp_id_sql);
                                         while($row = $camp_id->fetch_assoc()) {
                                     $camp_selected_id = $row['campaign_id'];
                                     $camp_rate_by_id_sql = "SELECT * FROM campaign WHERE campaign_id = '$camp_selected_id'";
                                     $camp_rate_by_id = $conn->query($camp_rate_by_id_sql);
                                     $row = $camp_rate_by_id->fetch_assoc();
                                     $payout_cost = $row['payout_cost'];
                                     $invoice_amount +=  $payout_cost;
                                    
                                    
                                }
                             echo "$".$invoice_amount;
                            ?>
                            
                            
                            
                        </td>
                        <td>
                          Unpaid
                    </tr>
                      <?php } ?>
                </tfoot>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script>
        $(document).ready(function() {
    $('#example').DataTable();
} );
    </script>
    <script src="./app.js"></script>
</body>
</html>