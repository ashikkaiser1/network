<div class="row"  ng-controller="api_kit">
    <nav class="top-nav">
        <h2 class="page-heading blue-bg">Frequently Asked Questions</h2>
    </nav>
    <div class="row"> 
        <div class="col-sm-12">

            <div class="panel-group panel-group-joined" id="accordion-test"> 
                <div class="panel panel-default" >
                    <div class="panel-body">

                        <div class="col-lg-12"> 
                            <div class="panel-group panel-group-joined" id="accordion-test"> 

                                <?php
                                if (isset($faqs) && !empty($faqs)) {
                                    foreach ($faqs as $key => $faq) {
                                        ?>
                                        <div class="panel panel-default"> 
                                            <div class="panel-heading"> 
                                                <h4 class="panel-title"> 
                                                    <a data-toggle="collapse" data-parent="#accordion-test" href="#collapseOne<?php echo @$key ?>" class="collapsed" aria-expanded="false">
                                                        <span class="fa fa-question-circle"></span>   <?php echo @$faq['faq_title'] ?>
                                                    </a> 
                                                </h4> 
                                            </div> 
                                            <div id="collapseOne<?php echo @$key ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;"> 
                                                <div class="panel-body">
                                                    <?php echo @$faq['faq_desc'] ?>
                                                </div> 
                                            </div> 
                                        </div> 


                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                 <div  style="text-align: center; font-size: x-large;" class="ng-scope">
                                    No Data Exist!!
                                </div>
                                
                                <?php
                                }
                                ?>



                            </div> 
                        </div>


                    </div>

                </div> <!-- col -->
            </div>
        </div>


    </div>
</div>
