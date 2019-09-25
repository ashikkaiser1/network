<div class="page-wrapper">

            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                     <h3 class="text-themecolor">Global PostBack</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item ">Account</li>
                        <li class="breadcrumb-item active">Global Postback</li>
                       
                    </ol>
                </div>
            </div>


    <div class="col-sm-12">
        <div class="card" >
            <div class="card-body"><h3 class="card-title">  Global Postback</h3></div>
            <div class="card-body">
                <div id="collapseOne" class="panel-collapse collapse in" aria-expanded="true"> 
                    <div class="card-body">
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

