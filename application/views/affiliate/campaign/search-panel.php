
<div class="col-12">
<div class="card">
<div class="card-body">  
<form id="searchFormOffer" class="form-material m-t-40 row" ng-submit="search()">

                                   
                                    <div class="form-group col-md-3 m-t-20">
                                       <input type="text" class="form-control" placeholder="Search" name="search" class="form-control input"/> </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <select class="form-control" name="category_id">
                                            <option value="0">--All--</option>
                                                 <?php
                                                    foreach ($category as $list) {

                                                         echo "<option value='{$list['category_id']}'>{$list['category_name']}</option>";
                                                                                                }
                                                                                    ?>
                                        </select> </div>
                                    <div class="form-group col-md-3 m-t-20">
                                          <?php echo form_multiselect("country_id[]", $country, '', "class='form-control select2' multiple") ?> </div>
                                    
                                     <div class="form-group col-md-3 m-t-20">
                                    <div class="input-group-btn ">
                                    <button type="submit"  class="btn col-md-12 waves-effect waves-light btn-warning" ><span class="fa fa-search"></span> SEARCH</button> </div>

            </div>
        </form>  

  
</div>
</div>
</div>
<div class="row"></div>