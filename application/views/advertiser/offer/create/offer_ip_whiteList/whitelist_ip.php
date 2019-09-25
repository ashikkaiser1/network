<div class="col-sm-12"  ng-controller="IpWhiteLisController">
    <div class="panel panel-default" >
        <div class="panel-heading">
            <h3 class="panel-title">
                IP Address White listing  
                <div class="pull-right">
                    <ul class="bulkActions">
                        <li><a href="void:javascript" id="IpWhiteListFormBtn" class=" btn btn-info waves-effect waves-light m-b-5 btn-xs">
                                <span class="fa fa-plus"></span> Add IP </a></li>
                    </ul>
                </div>
            </h3></div>
        <div class="panel-body">
            <div class="row">
                <div>
                    <?php
                    if (!empty($campaign)) {
                        ?>   
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <table class="table table-responsive">
                                    <thead>
                                        <tr>
                                            <th>#ID</th>
                                            <th>IP address</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="ip in all_ips" id="tr{{ip.camp_ip_id}}">
                                            <td>{{ip.camp_ip_id}}
                                            </td>
                                            <td>
                                                {{ip.ip_address}}
                                            </td>
                                            <td>
                                                <button type="button" ng-click="delete_offer_ip(ip.camp_ip_id)" class="btn btn-danger waves-effect waves-light m-b-5 btn-xs">
                                                    <span class="fa fa-trash"></span></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div> <!-- col -->
                        </div>
                        <?php
                    }
                    $this->load->view("admin/offer/offer_ip_whiteList/add-ip-whitelist");
                    ?>


                </div>
            </div>
        </div>
    </div>
</div>







