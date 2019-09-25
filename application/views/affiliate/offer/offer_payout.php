

<div class="col-sm-12" ng-controller="payout_manager">
    <div class="card" >
            <div class="card-header">
                        <h3 class="card-title">Payout</h3>

                        </div>
        <div class="card-body">
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
    <!--                                            <td><?php //echo isset($campaign['rtypeName']) ? $campaign['rtypeName'] : ''   ?> </td>
                                            <td><?php //echo isset($campaign['revenue_cost']) ? CURR . $campaign['revenue_cost'] : ''   ?> </td>-->

                                            <td>
                                                
                                                {{payouts.ptypeName}}
                                                
                                                </td>
                                            <td>
                                                    <?php echo CURR?> {{payouts.payout_cost}}
                                            
                                            </td>
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

<script>

    viral_pro.controller("payout_manager", function ($scope) {

        $scope.payouts = {};


        $scope.getCustomPayouts = function (campaign_id) {

            $.ajax({
                url: "<?php echo SITEURL . "affiliate/campaign/getCustomPayouts" ?>",
                type: 'POST',
                data: "campaign_id=" + campaign_id,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {

                    if (data['success']) {
                        $scope.payouts = data['payouts'];
                    } else
                    {
                        $scope.payouts = <?php echo json_encode($campaign) ?>;
                    }

                    $scope.$apply();
                }

            });
        };
        
        $scope.getCustomPayouts('<?php echo $campaign['campaign_id'] ?>');


    });

</script>

