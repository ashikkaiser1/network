<div class="row"  ng-controller="genUrlController">

    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading"><h3 class="panel-title">
                    Generate CSV</h3></div>
            <div class="panel-body">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 m-t-10 m-b-10 searchCustom">
                        <!--                        search-->
                        <form id="searchForm" class="form-inline" role="form" ng-submit="searchByForm()" >

                            <div class="form-group m-l-10">
                                <label class="" for="">Enter No Of URL</label>
                                <input type="number" name="url_nos" class="form-control input-sm" id="" placeholder="">
                                <input type="hidden" name="domain_id" />
                            </div>
                            <button type="submit" class="btn btn-success waves-effect waves-light m-l-10"><span class="fa fa-download">   </span> GET URL </button>

                        </form>
                        <!--end search-->
                    </div>


                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <form id="genFormCSV" ng-submit="generateCSV()">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox"  ng-model="checkme"/></th>
                                        <th>Image</th>
                                        <th style="width: 60%">Title</th>
                                        <th>Short Url</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="post in all_post" id="post{{post.post_id}}"> 
                                        <td> <input type="checkbox"  ng-checked="checkme" name="post_ids[]" value="{{post.post_id}}"/></td>
                                        <td><a href="{{post.url_slug}}" target="_blank"> 
                                                <img style="width: 40px" ng-src="{{post.image}}"/>
                                            </a></td>
                                        <td><a class="text-dark" href="{{post.url_slug}}" target="_blank"> {{post.title}}</a></td>
                                        <td id="postcodep{{post.post_id}}"  ></td>
                                
                                    </tr>
                                </tbody>

                            </table>

                            <div class="">
                                <button type="submit" class="btn btn-pink waves-effect waves-light m-b-5">Generate CSV</button>
                            </div>
                        </form>
                        <!--

         
        </div> <!-- panel -->
                    </div> <!-- col -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>

   // var genUrlManager = angular.module("gen_url", ['ui.bootstrap']);
    //genUrlController
    var genUrlController = viral_pro.controller("genUrlController", function ($scope) {
        $scope.checkme = false;
        $scope.all_post = {};
        $scope.searchBtn = "SEARCH";
        $scope.FormAction = "<?php echo SITEURL . "affiliate/campaign/getPost" ?>";
        $scope.searchByForm = function () {

            $scope.search();
        };
        $scope.search = function () {
            $scope.searchBtn = "SEARCHING...";
            var form = $("#searchForm").serialize();
            $.ajax({
                url: $scope.FormAction,
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_post = data;
                    $scope.searchBtn = "SEARCH";
                    $scope.$apply();
                    $.each(data,function (index,item){
                        $scope.getCode(item.post_id,item.campaign_id);
                      
                    });
                }
            });
        };
        $scope.getCode = function (post_id, campaign_id)
        {
            var domain = '';

            $.ajax({
                url: "<?php echo SITEURL . "affiliate/campaign/generateLink" ?>",
                type: 'POST',
                data: 'post_id=' + post_id + '&domain_id=' + domain + '&campaign_id=' + campaign_id,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data['success'])
                    {
                        $("#postcodep" + post_id).html(data['gen_link']);
                    }
                }

            });
        };

        $scope.generateCSV = function () {
            var form = $("#genFormCSV").serialize();

            $.ajax({
                url: "<?php echo SITEURL ."affiliate/gencsv/generateCSVfile" ?>",
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                   if(data['success'])
                   {
                       window.location = data['fileLink'];
                   }
                }
            });




        };
    });





</script>