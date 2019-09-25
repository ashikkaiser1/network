
<div class="row topSearchBar">
   

        <form id="searchFormOffer" ng-submit="search()">
            <div class="col-md-12 m-t-5 m-b-5">
                <input type="text" placeholder="Search" name="search" class="form-control input"/> 
            </div> 

            <div class="col-md-4  m-b-5">
                <div class="">
                    <select class="form-control" name="category_id">

                        <option value="0">--All--</option>
                        <?php
                        foreach ($category as $list) {

                            echo "<option value='{$list['category_id']}'>{$list['category_name']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>


            <div class="col-md-5 m-b-5">

                <?php echo form_multiselect("country_id[]", $country, '', "class='form-control select2' multiple") ?>

            </div>

            <div class="col-md-3 m-b-5" > 
                <div class="input-group-btn ">


                    <button type="submit"  class="btn col-md-6 waves-effect waves-light btn-warning" ><span class="fa fa-search"></span> SEARCH</button>
                   

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
<div class="row"></div>