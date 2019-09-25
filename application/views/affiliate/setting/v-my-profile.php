<div class="page-wrapper" ng-controller="profile_controller">

            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                     <h3 class="text-themecolor">Basic Info</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Account</a></li>
                        <li class="breadcrumb-item active">Basic Info</li>
                       
                    </ol>
                </div>
            </div>


    <div class="col-lg-12"> 
            <div class="card"> 
                <div class="card-body"> 
                    <h4 class="card-title"> Basic Info
                        
                        <a href="<?php echo SITEURL ?>affiliate/setting?section=1" class="btn btn-success btn-sm waves-effect waves-light pull-right m-l-10">
                            <span class="fa fa-pencil-square-o"> </span>  Edit 
                        </a>
                    </h4> 
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" aria-expanded="true"> 
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" id="usersForm_basic" ng-submit="updateUser('basic')"> 

                            <div class="form-group">
                                <label class="col-md-2 control-label">Name</label>
                                <div class="col-md-10 m-t-10">
                                    <?php echo isset($user['name']) ? $user['name'] : 'NA' ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="">Email</label>
                                <div class="col-md-10 m-t-10">
                                    <?php echo isset($user['email']) ? $user['email'] : 'NA' ?>
                                </div>
                            </div>




                            <div class="form-group">
                                <label class="col-md-2 control-label">Address</label>
                                <div class="col-md-10 m-t-10">
                                    <?php echo isset($user['address']) ? $user['address'] : 'NA' ?>
                                </div>
                            </div>                                  

                        </form>
                    </div> 
                </div> 
            </div> 





        </div> 
    

<script>
    // var setting_app = angular.module("setting_app", ['ui.bootstrap']);
    viral_pro.controller("profile_controller", function ($scope) {

        $scope.FormAction = "<?php echo SITEURL . "affiliate/setting/setting_edit" ?>";

        $scope.saveBtn = "Save";

        $scope.updateUser = function (type)
        {
            var form = $("#usersForm_" + type).serialize();
            $.ajax({
                url: $scope.FormAction + "?type=" + type,
                data: form,
                type: 'POST',
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $.Notification.autoHideNotify('success',
                                'botton right',
                                data['msg'],
                                '');
                    } else
                    {
                        $.Notification.autoHideNotify('error',
                                'botton right',
                                data['msg'],
                                '');
                    }
                }

            });
        };

    });
</script>
<?php $this->load->view("affiliate/setting/v-refferal"); ?>