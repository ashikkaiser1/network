<?php
if (isset($campaign['campaign_id'])) {
    ?>

    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading">
                <h3 class="panel-title">
                    Payout  
                    <div class="pull-right">
                        <ul class="bulkActions">
                            <li><a href="<?php echo SITEURL . "advertiser/offer/UpdateOfferPayout/" . $campaign['campaign_id'] ?>"  class=" btn btn-success waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span> Edit</a></li>
<!--                            <li><a href="<?php echo SITEURL . "admin/offer_payout/index/" . $campaign['campaign_id'] ?>"  class=" btn btn-info waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-plus"></span> Add Payout</a></li>-->
                        </ul>
                    </div>

                </h3></div>
            <div class="panel-body">
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
<!--                                            <th>Revenue Type</th>
                                            <th>Revenue</th>-->
                                            <th>Payout Type</th>
                                            <th>Payout</th>

                                        </tr>
                                    </thead> 
                                    <tbody>
                                        <tr>
<!--                                             <td><?php
                                             
//                                             echo isset($campaign['rtypeName']) ? $campaign['rtypeName'] : '' ?> </td>-->
                                              <td><?php echo isset($campaign['ptypeName']) ? $campaign['ptypeName'] : '' ?> </td>
                                              <td><?php echo isset($campaign['revenue_cost']) ?  CURR .$campaign['revenue_cost'] : '' ?> </td>
                                            
                                            
                                            <!--<td><?php // echo isset($campaign['payout_cost']) ? CURR . $campaign['payout_cost'] : '' ?></td>-->
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

<?php } ?> 



