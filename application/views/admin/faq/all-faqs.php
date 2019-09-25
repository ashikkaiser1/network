<div class="row"  ng-controller="all_faq_controller">

    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading"><h3 class="panel-title">
                    <a href="<?php echo SITEURL . "admin/faq/CreateFaq" ?>" class=" btn btn-info waves-effect waves-light m-b-5 btn-sm"><span class="fa fa-plus"></span> New FAQ </a>
                    All FAQs</h3></div>
            <div class="panel-body">
                <div class="row">




                    <div class="col-md-12 col-sm-12 col-xs-12 ">



                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th style="width: 60%">Desc.</th>
                                    <th>Sort Order</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="faqs in all_faqs" id="faqs{{faqs.faq_id}}"> 
                                    <td>{{faqs.faq_id}}</td>
                                    <td ng-class="faqs.faq_status==1? 'text-success' :'text-danger'">
                                            {{faqs.faq_title}}
                                    </td>
                                    <td>
                                        <div  ng-bind-html="reder_html(faqs.faq_desc)"> 
                                        </div>
                                    </td>
                                    <td>
                                        {{faqs.faq_order}}
                                    </td>
                                    <td>
<!--                                        <button  class=" btn btn-info waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-eye"></span></button>-->
                                        <a  href="<?php echo SITEURL . "admin/faq/update_faq/" ?>{{faqs.faq_id}}" class=" btn btn-purple waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-edit"></span></a>
                                        <button ng-click="delete_faqs(faqs.faq_id)" class=" btn btn-danger waves-effect waves-light m-b-5 btn-xs"><span class="fa fa-remove"></span></button>
                                    </td>

                                </tr>
                            </tbody>

                        </table>
                        <div></div>
                        <!--<div ng-init="search()"></div>-->
<!--                        <div class="col-md-3">

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

                        </div>-->



                    </div>
                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col -->
    </div>
</div>
<script>

    //var faqsManager = angular.module("faqs_app", ['ui.bootstrap']);
    //all_faq_controller
    var all_faq_controller = viral_pro.controller("all_faq_controller", function ($scope, $sce) {
        $scope.currentPage = 1;
        $scope.numPerPage = 10;
        $scope.all_faqs = {};
        $scope.searchBtn = "SEARCH";
        $scope.FormAction = "<?php echo SITEURL . "admin/faq/allFAQs" ?>";
        $scope.search = function () {
            $scope.searchBtn = "SEARCHING...";
            var form = $("#searchForm").serialize();
            $.ajax({
                url: $scope.FormAction,
                type: 'POST',
                data: form,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_faqs = data;
                    $scope.searchBtn = "SEARCH";
                    $scope.$apply();
                }
            });
        };
        $scope.$watch('currentPage + numPerPage', function () {

            $scope.search();
        });

        $scope.reder_html = function (html) {


            return $sce.trustAsHtml(html);

        };

        $scope.delete_faqs = function (faq_id)
        {
            swal({
                title: "Are you sure?",
                text: "Your will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn btn-sm btn-danger waves-effect waves-light",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function (isconfirm) {
                if (isconfirm)
                {
                    $.ajax({
                        url: "<?php echo SITEURL . "admin/faq/delete_faq" ?>",
                        type: 'POST',
                        data: "faq_id=" + faq_id,
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            if (data['success'])
                            {
                                $.Notification.autoHideNotify('success',
                                        'botton right',
                                        data['msg'],
                                        '');
                                $("#faqs" + faq_id).remove();
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
        $scope.getFaqs = function () {

            $.ajax({
                url: $scope.FormAction,
                type: 'POST',
                data: 'faqs=1',
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.all_faqs = data;
                    $scope.$apply();
                }
            });
        };
        $scope.getFaqs();
    });





</script>