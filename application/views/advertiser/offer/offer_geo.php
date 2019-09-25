<div class="col-sm-12">
    <div class="panel panel-default" >
        <div class="panel-heading">
            <h3 class="panel-title">
                Targeting  </h3></div>
        <div class="panel-body">
            <div class="row">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">

                        <div class="form-group m-b-10 m-b-10">
                            <label class="col-md-12 control-label">GEO</label>
                            <div class="col-md-9">

                                <?php
                                if (isset($offer_country) && !empty($offer_country)) {
                                    echo implode(",", $offer_country);
                                } else {
                                    echo "Global Geo";
                                }

                                // print_r($campaign);
                                ?>
                            </div>
                        </div>


                    </div> <!-- col -->
                </div>


            </div>
        </div>
    </div>
</div>

