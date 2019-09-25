<div class="row"  ng-controller="APIRequestController">
    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading"><h3 class="panel-title">
                    All API Token Request</h3></div>
            <div class="panel-body">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 m-t-10 m-b-10 searchCustom">
                        <!--                        search-->
                        <form id="searchForm" class="form-inline" role="form" ng-submit="searchByForm()" >

                            <div class="form-group m-l-10">
                                <label class="" for="exampleInputEmail2">Company</label>
                                <input type="text" name="search" class="form-control input-sm" id="searchSuggetion"  ng-model="searchText" placeholder="">
                                <input type="hidden" name="UTID" value="<?php echo isset($UTID) ? $UTID : '' ?>"/>
                                <input type="hidden" name="company" ng-value="searchText" />
                            </div>




                            <div class="form-group m-l-10">
                                <label class="" for="">Status</label>
                                <?php echo form_dropdown("status", array("" => "All")+$this->config->item('apiToken_status'), '', "class='form-control'") ?>
                            </div>

                            <button type="submit" class="btn btn-success waves-effect waves-light m-l-10"><span class="fa fa-search">   </span> </button>

                        </form>
                    </div>
                    <script>
                                //    $(document).ready(function () {
                                //
                                //        $('input.ad_title').typeahead({
                                //            name: 'q',
                                //            remote: '?q=%QUERY'
                                //
                                //        });
                                //
                                //    });
                                //$(document).ready(function () {
                                var options = {
                                    url: function (phrase) {
                                        return '<?php echo SITEURL . "admin/users/search_suggetions" ?>';
                                    },
                                    template: {
                                        type: "custom",
                                        method: function (value, item) {
                                            if (item.company !== null)
                                            {
                                                var option_selct = "<div class='searchResult'><span class='companyName'>" + item.company + "</span> <span class='userName'>" + item.name + " </span> <span class='userEmail'>" + item.email + " </span></div>"

                                                return option_selct;
                                            }

                                            return  value;

                                        }

                                    },
                                    getValue: function (element) {
                                        return element.company;
                                    },
                                    list: {
                                        onSelectItemEvent: function () {
                                            //			var value = $("#searchSugg").getSelectedItemData().category_id;
                                            //
                                            //			$("#category_id_sub").val(value).trigger("change");
                                        }
                                    },
                                    ajaxSettings: {
                                        dataType: "json",
                                        method: "POST",
                                        data: {
                                            dataType: "json"
                                        }
                                    },
                                    preparePostData: function (data) {
                                        data.phrase = $("#searchSuggetion").val();
                                        data.UTID = '<?php echo isset($UTID) ? $UTID : '' ?>';
                                        return data;
                                    },
                                    requestDelay: 400
                                };


                                $("#searchSuggetion").easyAutocomplete(options);


                    </script>
                    <!--end search-->
                </div>





                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive table  table-hover">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="    width: 20%;">Company</th>
                                    <th>Token</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr ng-repeat="token in all_tokenRequest" id="tr{{token.campaign_id}}">
                                    <td>{{token.usr_token_id}}</td>
                                    <td>
                                        <a target="_blank" href="<?php echo SITEURL . "admin/users/ViewUser/" ?>{{token.uid}}"> {{token.company}} ({{token.name}}) </a>
                                    </td>
                                    <td> {{token.token}}</td>

                                    <td>
                                        <div ng-if="token.status == 1"> <span  class="fa fa-circle text-success"></span> Active</div>
                                        <div ng-if="token.status == 0"> <span  class="fa fa-circle text-danger"></span> In-Active</div>
                                        <div ng-if="token.status == 2"> <span  class="fa fa-circle text-danger"></span> Pending</div>
                                        <div ng-if="token.status == 3"> <span  class="fa fa-circle text-danger"></span> Rejected</div>

                                    </td>    
                                    <td>
                                        <form class="form-inline" id="formApi{{token.usr_token_id}}">
                                            <div class="form-group input-xs">
                                                <input type="hidden" name="usr_token_id" value="{{token.usr_token_id}}">
                                                <select name="status" class="form-control">
                                                    <option ng-repeat="(key,status) in apiTokenStatus"
                                                            value="{{key}}" ng-selected="token.status == key"   
                                                            >{{status}}</option>

                                                </select>
                                                <button type="button" ng-click="ChangeStausToken(token.usr_token_id)"  class="btn btn-success waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-save"></span> Save</button>

<!--                                            <a title="View Details" type="button" href="{{token.campaign_id}}" class="btn btn-primary waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-eye">View</span></a>-->
                                            </div>

                                        </form>


                                    </td>

                                </tr>

                            </tbody>
                        </table>
                    </div>
                    
                    <div class="text-danger text-center" ng-if="all_tokenRequest == ''">
                            <h3 class='text-danger'>There is no data available ....</h3>
                        </div>
                    <div class="col-md-3">

                    </div>
                    <div class="col-md-6">
                        <pagination 
                            ng-model="currentPage"
                            total-items="1000"
                            max-size="5"  
                            boundary-links="true">
                        </pagination>
                    </div>
                    <div class="col-md-3">

                    </div>
                </div>
            </div>
        </div> <!-- panel-body -->
    </div> <!-- panel -->
</div> <!-- col -->


<script>
    //var campaignManager = angular.module("campaign_app", ['ui.bootstrap']);
    //APIRequestController
    var APIRequestController = viral_pro.controller("APIRequestController", function ($scope) {

        $scope.all_tokenRequest = {};
        $scope.searchBtn = "";
        $scope.FormAction = "<?php echo SITEURL . "admin/api_token/showApiTokenRequest" ?>";
        $scope.apiTokenStatus = <?php echo json_encode($this->config->item('apiToken_status')); ?>;
        $scope.currentPage = 1;
        $scope.numPerPage = 10;

        $scope.searchByForm = function () {
            $scope.currentPage = 1;
            $scope.search();
        };
        $scope.Selectchecked = function (status, Key)
        {
            console.log(status + "key=" + Key);
            if (status === Key)
            {

                return "true";
            }
            else
            {
                return "false";
            }
        };

        $scope.$watch('currentPage + numPerPage', function () {

            console.log($scope.currentPage + $scope.numPerPage);


            $scope.search();

        });


        $scope.search = function () {
            $scope.searchBtn = "";
            var form = $("#searchForm").serialize();
            $.ajax({
                url: $scope.FormAction + "?page=" + $scope.currentPage,
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_tokenRequest = data;
                    $scope.searchBtn = "";
                    $scope.$apply();
                }
            });
        };
        $scope.getAPIToken = function () {

            $.ajax({
                url: $scope.FormAction,
                type: 'POST',
                data: 'user=1',
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_tokenRequest = data;
                    $scope.$apply();
                }
            });
        };



        //delete campaing

        //code is used for chanage the api token request status 
        //Approve ,Reject ,Delete etc
        $scope.ChangeStausToken = function (usr_token_id)
        {
            swal({
                title: "Are you sure?",
                //text: "Offer will be approved for Affiliate!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn btn-sm btn-success waves-effect waves-light",
                confirmButtonText: "Yes, Continue it!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function (isConfirm) {
                if (isConfirm)
                {

                    var form = $("#formApi" + usr_token_id).serialize();

                    $.ajax({
                        url: "<?php echo SITEURL . "admin/api_token/ChangeUsrTokenStatus" ?>",
                        type: 'POST',
                        //  data: "usr_token_id=" + usr_token_id + "&status=" + status,
                        data: form, //"usr_token_id=" + usr_token_id + "&status=" + status,
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            if (data['success'])
                            {
                                $.Notification.autoHideNotify('success',
                                        'botton right',
                                        data['msg'],
                                        '');

                                $scope.search();
//                                $("#tr" + request_id).remove();
                                //$("#catForm")[0].reset();
                            } else {
                                $.Notification.autoHideNotify('error',
                                        'botton right',
                                        data['msg'],
                                        '');
                            }

                        }

                    });
                }


            });
        };
        //end of api request token code
        





//        $scope.getAPIToken();
    });</script>

