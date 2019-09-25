<div class="row" >

    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading"><h3 class="panel-title">
                    Global Postback</h3></div>
            <div class="panel-body">
                <div id="collapseOne" class="panel-collapse collapse in" aria-expanded="true"> 
                    <div class="panel-body">
                        <?php
                        if (isset($globalPostBack)) {
                            echo $globalPostBack;
                        }
                        ?>
                    </div> 
                </div>
                <!--                 !-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col -->
    </div>
</div>
