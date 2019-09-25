<div class="row"  ng-controller="api_kit">
    <nav class="top-nav">
        <h2 class="page-heading blue-bg">Infomation about postbacks</h2>
    </nav>
    <div class="row"> 
        <div class="col-sm-12">

            <div class="panel-group panel-group-joined" id="accordion-test"> 
                <div class="panel panel-default" >
                    <div class="panel-body">

                        <div class="col-lg-12"> 
                            <div class="panel-group panel-group-joined" id="accordion-test"> 

                            
                                        <div class="panel panel-default"> 
                                            <div class="panel-heading"> 
                                                <h4 class="panel-title"> 
                                                
                                                
                                                        Server to Server (S2S) Postback
                                                
                                                </h4> 
                                            </div> 
                                            <div  class="panel-collapse collapse in" > 
                                                <div class="panel-body">
                                                    <?php
                                                    echo @STOSPOSTBACK
                                                    ?>
                                                </div> 
                                            </div> 
                                        </div> 
                                
                                
                                    <div class="panel panel-default"> 
                                            <div class="panel-heading"> 
                                                <h4 class="panel-title"> 
                                                    
                                                        
                                                        Iframe for convertion
                                                     
                                                </h4> 
                                            </div> 
                                            <div  class="panel-collapse collapse in" > 
                                                <div class="panel-body">
                                                    
                                                    <xmp><iframe width="1" height="1" src="<?php
                                                    echo @STOSPOSTBACK
                                                    ?>"></iframe></xmp>
                                                   
                                                </div> 
                                            </div> 
                                        </div>
                                
                                 <div class="panel panel-default"> 
                                            <div class="panel-heading"> 
                                                <h4 class="panel-title"> 
                                                    
                                                        
                                                        Image Pixel only for convertion not goals
                                                     
                                                </h4> 
                                            </div> 
                                            <div  class="panel-collapse collapse in" > 
                                                <div class="panel-body">
                                                    
                                                    <xmp><img width="1" height="1" src="<?php
                                                    echo @CONV_PIXEL
                                                    ?>"/></xmp>
                                                   
                                                </div> 
                                            </div> 
                                        </div>
                                
                                
                                
                            </div> 
                        </div>


                    </div>

                </div> <!-- col -->
            </div>
        </div>


    </div>
</div>
