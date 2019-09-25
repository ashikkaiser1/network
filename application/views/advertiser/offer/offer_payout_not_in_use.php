

<div class="col-sm-12">
    <div class="panel panel-default" >
        <div class="panel-heading">
            <h3 class="panel-title">
                Payout  </h3></div>
        <div class="panel-body">
            <div class="row">

                <div class="row">
                    <?php
                    if (!empty($campaign)) {

//                        echo "<pre>";
//                        print_r($campaign);
                        ?>   
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">

                                <table class="table table-responsive">
                                    <thead>
                                        <tr>
<!--                                            <th>Revenue Type</th>-->
<!--                                            <th>Revenue</th>-->
                                            <th>Payout Type</th>
                                            <th>Payout</th>

                                        </tr>
                                    </thead> 
                                    <tbody>
                                        <tr>
<!--                                            <td><?php //echo isset($campaign['rtypeName']) ? $campaign['rtypeName'] : '' ?> </td>
                                            <td><?php //echo isset($campaign['revenue_cost']) ? CURR . $campaign['revenue_cost'] : '' ?> </td>-->

                                            <td><?php echo isset($campaign['ptypeName']) ? $campaign['ptypeName'] : '' ?> </td>
                                            <td><?php echo isset($campaign['payout_cost']) ? CURR . $campaign['payout_cost'] : '' ?></td>
                                        </tr>

                                    </tbody>
                                </table>



                            </div> <!-- col -->
                        </div>

                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>

