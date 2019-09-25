
<div class="row">
    <div class="col-md-12">
        <?php
        if (isset($category)) {
            category_list($category);
        }

        function category_list($menu) {
            if (!empty($menu)) {
                ?>
                <ul class="aff_category col-md-7">
                    <li class="">
                        <div style=" " class="" id="cat0" ng-click="getPostByCatClick(0)">All</div>
                    </li>
                    <?php
                    foreach ($menu as $list) {
                        ?>
                        <li class="">

                            <div style=" " class="" id="cat<?php echo $list['category_id'] ?>" ng-click="getPostByCatClick(<?php echo $list['category_id'] ?>)">
                                <?php echo $list['category_name'] ?>

                            </div>

                            <?php
                            if (isset($list['child']))
                                category_list($list['child']);
                            ?>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <?php
            }
        }
        ?>     
        <form id="searchFormOffer" ng-submit="search()">
            <div class="col-md-2">

                <?php echo form_multiselect("country_id[]", $country, '', "class='form-control select2' multiple") ?>

            </div>

            <div class="col-md-3">
                <div class="input-group-btn ">

                    <div class="col-md-9">
                        <input type="text" placeholder="Search" name="search" class="form-control input"/> 
                    </div> 

                    <button type="submit"  class="btn col-md-3 waves-effect waves-light btn-warning" ><span class="fa fa-search"></span></button>

                </div>

                <!--        <div class="input-group-btn ">
                            <button type="button"  class="btn col-md-12 waves-effect waves-light btn-warning  dropdown-toggle" data-toggle="dropdown" style="overflow: hidden; position: relative;    padding: 5%;" aria-expanded="true">{{selectedDomain}} <span class="caret"></span></button>
                            <ul class="dropdown-menu dropdown-menu-right">
                <?php
                if (isset($domain)) {
                    foreach ($domain as $dom) {
                        ?>
                                                                <li><label ng-click="selectDomain('<?php echo $dom['domain_name'] ?>', '<?php echo $dom['domain_id'] ?>')" class="customLabel"><input type="radio" name="domain"/> <?php echo $dom['domain_name'] ?></label></li>
                        <?php
                    }
                }
                ?>
                
                            </ul>
                        </div>-->
            </div>
        </form>  

    </div>
</div>
<div class="row"></div>