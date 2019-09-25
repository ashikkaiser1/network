<div class="row" >
    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading"><h3 class="panel-title">
                    <?php
                    echo isset($campaign['campaign_id']) ? $campaign['campaign_id'] : 'NILL';
                    echo ' ';
                    echo isset($campaign['campaign_name']) ? $campaign['campaign_name'] : 'NILL';
                    ?>    
                </h3></div>
            <div class="panel-body">
                <div class="row">

                    <div class="col-sm-12">
                        <div class="panel panel-default" >
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    Default Payout  
                                </h3></div>
                            <div class="panel-body">
                                <div class="row">

                                    <div class="col-md-12 col-sm-12 col-xs-12 ">

                                        <table class="table table-responsive">
                                            <thead>
                                                <tr>
                                                    <th>Revenue Type</th>
                                                    <th>Revenue</th>
                                                    <th>Payout Type</th>
                                                    <th>Payout</th>

                                                </tr>
                                            </thead> 
                                            <tbody>
                                                <tr>
                                                    <td><?php echo isset($campaign['rtypeName']) ? $campaign['rtypeName'] : '' ?> </td>
                                                    <td><?php echo isset($campaign['revenue_cost']) ? CURR . $campaign['revenue_cost'] : '' ?> </td>

                                                    <td><?php echo isset($campaign['ptypeName']) ? $campaign['ptypeName'] : '' ?> </td>
                                                    <td><?php echo isset($campaign['payout_cost']) ? CURR . $campaign['payout_cost'] : '' ?></td>
                                                </tr>

                                            </tbody>
                                        </table>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="col-md-12">
                        <?php
                        if (isset($affiliate_payout))
                            echo $affiliate_payout;
                        ?>  
                    </div>
                    <div class="col-md-6">
                        <?php
                        if (isset($group_payout))
                            echo $group_payout;
                        ?>  
                    </div>
                </div>
            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col -->
</div>
