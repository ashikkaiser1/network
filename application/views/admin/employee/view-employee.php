<div class="row">
    <div class="col-sm-12">
        <!--        <h1 class="text-danger">Don't use this module.</h1>-->
        <div class="panel panel-default"  >
            <div class="panel-heading"><h3 class="panel-title">
                    <a href="<?php echo SITEURL . "admin/users/ShowUsers" ?>" class=" btn btn-purple waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-list"></span> All Users</a>
                    <?php echo $panel_title ?></h3></div>
            <div class="panel-body">
                <div class="right" style="    float: right;">

                    <?php
                    if ($user['UTID'] < 4) {
                        ?>
                        <a   href="<?php echo SITEURL . "admin/users/UpdateUser/" . $user['uid'] ?>" type="button" class="btn btn-primary waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span> Edit</a>

                        <?php
                    } else if ($user['UTID'] >= 4) {
                        ?>
                        <a   href="<?php echo SITEURL . "admin/employee/UpdateEmployee/" . $user['uid'] ?>" type="button" class="btn btn-primary waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span> Edit</a>
                        <?php
                    }
                    ?>

                    <a   class="btn btn-primary waves-effect waves-light m-b-5 btn-xs" href="<?php echo SITEURL . "admin/globalpostback/index/" . $user['uid'] ?>"><span class="fa fa-link"></span> Global Post back</a>
              <!--                                            <button type="button" class="btn btn-info waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-eye"></span></button>
                                      <a  ng-if="user.UTID < 4" href="<?php echo SITEURL . "admin/users/UpdateUser/" ?>{{user.uid}}" type="button" class="btn btn-primary waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span></a>
                                      <a  ng-if="user.UTID >= 4" href="<?php echo SITEURL . "admin/employee/UpdateEmployee/" ?>{{user.uid}}" type="button" class="btn btn-primary waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span></a>


                                      <a   class="btn btn-primary waves-effect waves-light m-b-5 btn-xs" href="<?php echo SITEURL . "admin/globalpostback/index/" ?>{{user.uid}}"><span class="fa fa-link"></span></a>
                                      <button type="button" class="btn btn-danger waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-trash"></span></button>-->
                </div>
                

                <form class="form-horizontal" role="form" id="usersForm" ng-submit="createUser_updateUser()"> 
                    <div class="form-group">
                        <label class="col-md-2 control-label">Date</label>
                        <div class="col-md-4">
                            
                            <?php echo isset($user['DOJ']) ? $user['DOJ'] : 'NILL' ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Company</label>
                        <div class="col-md-4">
                            <?php echo isset($user['company']) ? $user['company'] :'NIlL' ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Name</label>
                        <div class="col-md-4">
                            <?php echo isset($user['name']) ? $user['name'] :'NILL' ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="">Email</label>
                        <div class="col-md-4">
                            <?php
                            if (!isset($user['email'])) {
                                ?>
                                <?php echo isset($user['email']) ? $user['email'] :'NILL' ?>
                                <?php
                            } else {
                                echo $user['email'];
                            }
                            ?>


                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="">User ID</label>
                        <div class="col-md-4">
                            <?php
                            if (!isset($user['username'])) {
                                ?>
                                <?php echo isset($user['username']) ? $user['username'] :'NILL' ?>
                                <?php
                            } else {
                                echo $user['username'];
                            }
                            ?>

                        </div>
                    </div>

<!--                    <div class="form-group">
                        <label class="col-md-2 control-label">Password</label>
                        <div class="col-md-4">
                           <?php // echo isset($user['password']) ? $user['password'] :'NILL' ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Password R-Type</label>
                        <div class="col-md-4">
                           <?php // echo isset($user['re_password']) ? $user['re_password'] :'NILL' ?>
                        </div>
                    </div>-->




                    <div class="form-group">
                        <label class="col-md-2 control-label" for="">Contact</label>
                        <div class="col-md-4">
                          <?php echo isset($user['contact']) ? $user['contact'] :'NILL' ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="">Skype</label>
                        <div class="col-md-4">
                          <?php echo isset($user['skype_id']) ? $user['skype_id'] :'NILL' ?>
                        </div>
                    </div>




                    <div class="form-group">
                        <label class="col-md-2 control-label ">
                            Country <span class='text-danger'>*</span></label>
                        <div class="col-md-4">
                            <?php echo form_dropdown("country_id", $country, isset($user['country_id']) ? $user['country_id'] :'NILL', "class='select2 form-control' disabled='true'") ?>
                        </div>
                    </div>
                   

                    <div class="form-group">
                        <label class="col-md-2 control-label">Address</label>
                        <div class="col-md-6">
                            <?php echo isset($user['address']) ? $user['address'] :'NILL' ?>
                        </div>
                    </div>

                 




                    <div class="form-group">
                        <label class="col-md-2 control-label">User Verification</label>
                        <div class="col-md-3">
                            <?php
                            echo form_dropdown("verified", array("1" => "Verified", "0" => "Not Verified"), isset($user['verified']) ? $user['verified'] :'NILL', "class='form-control' disabled='true'")
                            ?> 

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">User status</label>
                        <div class="col-md-3">
                            <?php
                            echo form_dropdown("status", array("1" => "Active", "0" => "De-Active"), isset($user['u_status']) ? $user['u_status'] :'NILL', "class='form-control'disabled='true'")
                            ?> 
<!--                            <select name="status" class="form-control">
        <option value="1">Active</option>
        <option value="0">De-Active</option>
    </select>-->
                        </div>
                    </div>




                    <div class="form-group">
                        <label class="col-sm-2 control-label">User Type</label>
                        <div class="col-sm-3">
                            <?php
                            echo form_dropdown("UTID", $userType, isset($user['UTID']) ? $user['UTID'] :'NILL', "class='form-control' disabled='true'")
                            ?> 


                        </div>
                    </div>

<!--                    <div class="form-group"> 
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-10">

                            <button type="submit" class="btn btn-purple waves-effect waves-light">{{saveBtn}}</button>
                            <button type="Reset" class="btn btn-danger waves-effect waves-light">Cancel</button>
                        </div>
                    </div>-->

                </form>
            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col -->
</div>
