<?php
require("dbConfig.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="http://app.offerforest.xyz/manager/app.css">
    <title>Manager Panel</title>
</head>
<body>
    <header>
        <nav>
            <h1>Manager Panel / Paid Invoices</h1>
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
        <div class="publisher-balance" style="z-index: -1;">
            
            <?php if($_GET['getmsg']) {
                echo $_GET['getmsg'] ;
                echo "</br>";
            }
            
            ?>
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    
                    <tr>
                        <th>Affilite Id</th>
                        <th>Affiliate Name</th>
                        <th>Created Date</th>
                        <th>Invoice Amount</th>
                        <th>Status</th>
                       
                    </tr>
                  
                </thead>
                <tbody>
                     <?php
                     	$sql = "SELECT * FROM payment_ledger WHERE paid_status='1'";
                            $affresult = $conn->query($sql);
                        while($affrow = $affresult->fetch_assoc()) {
                            
                        ?>
                    <tr>
                        <td>#<?php echo $affrow['uid'] ?></td>
                        <td><?php 
                        
                        $aff_id = $affrow['uid'];
                                    
                                     $camp_rate_by_id_sql = "SELECT * FROM users WHERE uid = '$aff_id'";
                                         $camp_rate_by_id = $conn->query($camp_rate_by_id_sql);
                                         $row = $camp_rate_by_id->fetch_assoc();
                                         $payout_cost = $row['name'];
                                        echo $payout_cost
                                    ?></td>
                        <td>
                            
                            <?php 
                                    
                                 echo $affrow['dateTime']   
                                    
                                    
                            ?>
                            
                            
                        </td>
                        <td>
                            
                            <?php   
                                  echo $affrow['amt']   
                            ?>
                            
                            
                            
                        </td>
                        <td>
                           Paid
                            
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

</body>
</html>