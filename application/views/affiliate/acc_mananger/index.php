<div class="row"  ng-controller="acc_manger">
    <nav class="top-nav">
        <h2 class="page-heading blue-bg">Account Manager</h2>
    </nav>
    <div class="row"> 
        <div class="col-sm-12">

            <div class="panel-group panel-group-joined" id="accordion-test"> 
                <div class="panel panel-default" >
                    <div class="panel-body">

                        <div class="col-lg-12"> 
                            <div class="panel-group panel-group-joined" id="accordion-test"> 

                                
                                <div class="col-md-6" ng-if="account_manager != ''">
                                        <!-- Personal-Information -->
                                        <div class="panel panel-default panel-fill">
                                            <div class="panel-heading"> 
                                                <h3 class="panel-title">Personal Information</h3> 
                                            </div> 
                                            <div class="panel-body"> 
                                                <div class="about-info-p">
                                                    <strong>Full Name</strong>
                                                    <br>
                                                    <p class="text-muted">{{account_manager.name}}</p>
                                                </div>
                                                <div class="about-info-p">
                                                    <strong>Mobile</strong>
                                                    <br>
                                                    <p class="text-muted">-------</p>
                                                </div>
                                                <div class="about-info-p">
                                                    <strong>Email</strong>
                                                    <br>
                                                    <p class="text-muted">{{account_manager.email}}</p>
                                                </div>
                                                <div class="about-info-p">
                                                    <strong>Skype ID</strong>
                                                    <br>
                                                    <p class="text-muted">{{account_manager.skype_id}}</p>
                                                </div>
<!--                                                <div class="about-info-p m-b-0">
                                                    <strong>Location</strong>
                                                    <br>
                                                    <p class="text-muted">USA</p>
                                                </div>-->
                                            </div> 
                                        </div>
                                        <!-- Personal-Information -->

                                        <!-- Languages -->
<!--                                        <div class="panel panel-default panel-fill">
                                            <div class="panel-heading"> 
                                                <h3 class="panel-title">Languages</h3> 
                                            </div> 
                                            <div class="panel-body"> 
                                                <ul>
                                                    <li>English</li>
                                                    <li>Franch</li>
                                                    <li>Greek</li>
                                                </ul>
                                            </div> 
                                        </div>-->
                                        <!-- Languages -->

                                    </div>
                                
                                <div ng-if="account_manager == ''" style="text-align: center; font-size: x-large;">
                                    Sorry , Admin haven't Allot you a Affiliate Manager.
                                </div>




                            </div> 
                        </div>


                    </div>

                </div> <!-- col -->
            </div>
        </div>


    </div>
</div>
<script>
    viral_pro.controller("acc_manger", function ($scope) {


        $scope.account_manager = <?php echo json_encode($acc_manager) ?>;


    });

</script>
