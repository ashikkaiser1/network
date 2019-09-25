<style>
    .tooltip {
        position: relative;
        display: inline-block;
    }

    .tooltip .tooltiptext {
        visibility: hidden;
        width: 140px;
        background-color: #555;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px;
        position: absolute;
        z-index: 1;
        bottom: 150%;
        left: 50%;
        margin-left: -75px;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .tooltip .tooltiptext::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #555 transparent transparent transparent;
    }

    .tooltip:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }
</style>



    <div class="col-lg-12" ng-controller="refferal_controller> 
        <div class="card" > 
            <div class="card-body"> 
               
                    <h4 class="panel-title"> 
                        
                        Refferal Program

                    </h4> 
                </div>
                <div  class="card" aria-expanded="true"> 
                    <div class="card-body">
                        <form class="form-horizontal" role="form" id="usersForm_basic" ng-submit="getRefferalLink()"> 

                            <div class="text-center col-md-12">
                                <img  style="width: 125px"src="<?php echo ASSETS . "images/refferal.png"; ?>"/>

                                <div class="row"><h3>Refferal Link</h3></div>
                                <div class="row">

                                    <div class="col-md-1">

                                    </div>
                                    <div class="col-md-10">

                                        <div class="input-group m-t-10">
                                            <input readonly="" type="text" id="ref_link" name="" class="form-control" value="<?php echo SITEURL . "account/account/CreateAccountRequest?ref_by=" . (isset($user['ref_id']) ? $user['ref_id'] : '') ?>">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn waves-effect waves-light btn-primary tooltiptext" onclick="copy_this_text()" onmouseout="mouse_out_fun" id="myTooltip">Copy</button>
                                            </span>
                                        </div>



                                    </div>  
                                    <div class="col-md-1">

                                    </div>



                                </div>
                            </div>

                        </form>
                    </div> 
                </div> 
            </div> 





        </div> 
    </div>
</div>

<script>
    function copy_this_text() {
        var copyText = document.getElementById("ref_link");
        copyText.select();
        document.execCommand("Copy");

        var tooltip = document.getElementById("myTooltip");
        tooltip.innerHTML = "Copied: ";
    }

    function mouse_out_fun() {
        var tooltip = document.getElementById("myTooltip");
        tooltip.innerHTML = "Copy to clipboard";
    }
</script>
<script>


    // var setting_app = angular.module("setting_app", ['ui.bootstrap']);
    viral_pro.controller("refferal_controller", function ($scope) {

        $scope.FormAction = "<?php echo SITEURL . "affiliate/setting/get_refferal_link" ?>";

        $scope.saveBtn = "Save";

        $scope.getRefferalLink = function (type)
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