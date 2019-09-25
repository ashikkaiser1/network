<div class="row">
  
    <div class="col-md-4">
         <h3>Offer Data Selection</h3> 
    
    <?php
    foreach ($dataSelection as $key => $val) {
        ?>
        <div class="col-md-12">
            <label>
                <input type="checkbox" value="<?php echo $key ?>"/> <?php echo $val ?>
            </label> 
        </div>

        <?php
    }
    ?>
        </div>
    
     <div class="col-md-4">
        <h3>User Data Selection</h3>
    
    <?php
    foreach ($dataSelection1 as $key => $val) {
        ?>
        <div class="col-md-12">
            <label>
                <input type="checkbox" value="<?php echo $key ?>"/> <?php echo $val ?>
            </label> 
        </div>

        <?php
    }
    ?>
        </div>

</div>
