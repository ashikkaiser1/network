
<?php $this->load->view("admin/dashboard/widgets") ?>

<div class="row"  ng-controller="dashboardCon">


    <!-- Page-Title -->
    <!--                        <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="pull-left page-title">Welcome !</h4>
                                    <ol class="breadcrumb pull-right">
                                        <li><a href="#">Moltran</a></li>
                                        <li class="active">Dashboard</li>
                                    </ol>
                                </div>
                            </div>-->

    <!-- Start Widget -->
    <!--Widget-4 -->
    <div class="col-md-3">
        <div class="col-md-12 col-sm-6 col-lg-12">
            <div class="mini-stat clearfix bx-shadow bg-white">
                <span class="mini-stat-icon bg-info"><i class="ion-social-usd"></i></span>
                <div class="mini-stat-info text-right text-dark">
                    <span class="counter text-dark"><?php echo CURR ?>{{today}}</span>
                    Today
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-6 col-lg-12">
            <div class="mini-stat clearfix bx-shadow bg-white">
                <span class="mini-stat-icon bg-purple"><i class="ion-social-usd"></i></span>
                <div class="mini-stat-info text-right text-dark">
                    <span class="counter text-dark"><?php echo CURR ?>{{yesterday}}</span>
                    Yesterday
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-6 col-lg-12">
            <div class="mini-stat clearfix bx-shadow bg-white">
                <span class="mini-stat-icon bg-success"><i class="ion-social-usd"></i></span>
                <div class="mini-stat-info text-right text-dark">
                    <span class="counter text-dark"><?php echo CURR ?>{{month}}</span>
                    This Month
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-6 col-lg-12">
            <div class="mini-stat clearfix bx-shadow bg-white">
                <span class="mini-stat-icon bg-primary"><i class="ion-social-usd"></i></span>
                <div class="mini-stat-info text-right text-dark">
                    <span class="counter text-dark">0.0</span>
                    Paid
                </div>
            </div>
        </div>

        <div class="col-md-12 col-sm-6 col-lg-12">
            <div class="mini-stat clearfix bx-shadow bg-white">
                <span class="mini-stat-icon bg-danger"><i class="ion-social-usd"></i></span>
                <div class="mini-stat-info text-right text-dark">
                    <span class="counter text-dark">0.0</span>
                    Unpaid
                </div>
            </div>
        </div>
    </div> <!-- End row-->


    <div class="col-md-9">
        <div class="col-lg-12">
            <div class="portlet"><!-- /portlet heading -->
                <div class="portlet-heading">
                    <h3 class="portlet-title text-dark text-uppercase">
                        <select ng-model="graphType" class="form-control">
                            <option value="1" ng-selected="true" >Click Stats</option>
                            <option value="2" >Earning Stats</option>
                        </select>
                    </h3>
                    <div class="col-md-9 col-sm-6 col-xs-12  ">
                        <!--                        search-->
                        <form id="searchForm" class="form-inline" role="form" ng-submit="searchByForm()" >

                            <div class="form-group m-l-10">
                                <label class="text-dark col-md-2 text-center"  style="margin: 4px auto;" for="">From</label>
                                <input type="text" name="startDate"  style="width: 20%" class="form-control datepicker input-sm col-md-2" id="startDate" placeholder="">

                                <label class="text-dark col-md-2  text-center" style="margin: 4px auto;" for="">To</label>
                                <input type="text" name="endDate"  style="width: 20%" class="form-control datepicker input-sm col-md-2" id="endDate" placeholder="">
                                <button type="submit" class="btn btn-success btn-sm waves-effect waves-light m-l-10"><span class="fa fa-bar-chart">   </span> Show </button>
                            </div>


                        </form>
                        <!--end search-->
                    </div>


<!--                    <div class="portlet-widgets">
                        <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                        <span class="divider"></span>
                        <a data-toggle="collapse" data-parent="#accordion1" href="#portlet1"><i class="ion-minus-round"></i></a>
                        <span class="divider"></span>
                        <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                    </div>-->
                    <div class="clearfix"></div>
                </div>
                <div id="portlet1" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="webstats" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- /Portlet -->
        </div> <!-- end col -->

    </div>


    <!--                            <div class="col-lg-4">
                                    <div class="portlet"> /portlet heading 
                                        <div class="portlet-heading">
                                            <h3 class="portlet-title text-dark text-uppercase">
                                                Website Stats
                                            </h3>
                                            <div class="portlet-widgets">
                                                <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                                                <span class="divider"></span>
                                                <a data-toggle="collapse" data-parent="#accordion1" href="#portlet2"><i class="ion-minus-round"></i></a>
                                                <span class="divider"></span>
                                                <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div id="portlet2" class="panel-collapse collapse in">
                                            <div class="portlet-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div id="pie-chart">
                                                            <div id="pie-chart-container" class="flot-chart" style="height: 320px">
                                                            </div>
                                                        </div>
    
                                                        <div class="row text-center m-t-30">
                                                            <div class="col-sm-6">
                                                                <h4 class="counter">86,956</h4>
                                                                <small class="text-muted"> Weekly Report</small>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <h4 class="counter">86,69</h4>
                                                                <small class="text-muted">Monthly Report</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  /Portlet 
                                </div>  end col -->
</div> <!-- End row -->


<!--                        <div class="row">
                             INBOX 
                            <div class="col-lg-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">Inbox</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="inbox-widget nicescroll mx-box">
                                            <a href="#">
                                                <div class="inbox-item">
                                                    <div class="inbox-item-img"><img src="<?php echo ASSETS; ?>images/users/avatar-1.jpg" class="img-circle" alt=""></div>
                                                    <p class="inbox-item-author">Chadengle</p>
                                                    <p class="inbox-item-text">Hey! there I'm available...</p>
                                                    <p class="inbox-item-date">13:40 PM</p>
                                                </div>
                                            </a>
                                            <a href="#">
                                                <div class="inbox-item">
                                                    <div class="inbox-item-img"><img src="<?php echo ASSETS; ?>images/users/avatar-2.jpg" class="img-circle" alt=""></div>
                                                    <p class="inbox-item-author">Tomaslau</p>
                                                    <p class="inbox-item-text">I've finished it! See you so...</p>
                                                    <p class="inbox-item-date">13:34 PM</p>
                                                </div>
                                            </a>
                                            <a href="#">
                                                <div class="inbox-item">
                                                    <div class="inbox-item-img"><img src="<?php echo ASSETS; ?>images/users/avatar-3.jpg" class="img-circle" alt=""></div>
                                                    <p class="inbox-item-author">Stillnotdavid</p>
                                                    <p class="inbox-item-text">This theme is awesome!</p>
                                                    <p class="inbox-item-date">13:17 PM</p>
                                                </div>
                                            </a>
                                            <a href="#">
                                                <div class="inbox-item">
                                                    <div class="inbox-item-img"><img src="<?php echo ASSETS; ?>images/users/avatar-4.jpg" class="img-circle" alt=""></div>
                                                    <p class="inbox-item-author">Kurafire</p>
                                                    <p class="inbox-item-text">Nice to meet you</p>
                                                    <p class="inbox-item-date">12:20 PM</p>
                                                </div>
                                            </a>
                                            <a href="#">
                                                <div class="inbox-item">
                                                    <div class="inbox-item-img"><img src="<?php echo ASSETS; ?>images/users/avatar-5.jpg" class="img-circle" alt=""></div>
                                                    <p class="inbox-item-author">Shahedk</p>
                                                    <p class="inbox-item-text">Hey! there I'm available...</p>
                                                    <p class="inbox-item-date">10:15 AM</p>
                                                </div>
                                            </a>
                                            <a href="#">
                                                <div class="inbox-item">
                                                    <div class="inbox-item-img"><img src="<?php echo ASSETS; ?>images/users/avatar-6.jpg" class="img-circle" alt=""></div>
                                                    <p class="inbox-item-author">Adhamdannaway</p>
                                                    <p class="inbox-item-text">This theme is awesome!</p>
                                                    <p class="inbox-item-date">9:56 AM</p>
                                                </div>
                                            </a>
                                            <a href="#">
                                                <div class="inbox-item">
                                                    <div class="inbox-item-img"><img src="<?php echo ASSETS; ?>images/users/avatar-8.jpg" class="img-circle" alt=""></div>
                                                    <p class="inbox-item-author">Arashasghari</p>
                                                    <p class="inbox-item-text">Hey! there I'm available...</p>
                                                    <p class="inbox-item-date">10:15 AM</p>
                                                </div>
                                            </a>
                                            <a href="#">
                                                <div class="inbox-item">
                                                    <div class="inbox-item-img"><img src="<?php echo ASSETS; ?>images/users/avatar-9.jpg" class="img-circle" alt=""></div>
                                                    <p class="inbox-item-author">Joshaustin</p>
                                                    <p class="inbox-item-text">I've finished it! See you so...</p>
                                                    <p class="inbox-item-date">9:56 AM</p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>  end col 

                             CHAT 
                            <div class="col-lg-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title">Chat</h3> 
                                    </div> 
                                    <div class="panel-body"> 
                                        <div class="chat-conversation">
                                            <ul class="conversation-list nicescroll">
                                                <li class="clearfix">
                                                    <div class="chat-avatar">
                                                        <img src="<?php echo ASSETS; ?>images/avatar-1.jpg" alt="male">
                                                        <i>10:00</i>
                                                    </div>
                                                    <div class="conversation-text">
                                                        <div class="ctext-wrap">
                                                            <i>John Deo</i>
                                                            <p>
                                                                Hello!
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="clearfix odd">
                                                    <div class="chat-avatar">
                                                        <img src="<?php echo ASSETS; ?>images/users/avatar-5.jpg" alt="Female">
                                                        <i>10:01</i>
                                                    </div>
                                                    <div class="conversation-text">
                                                        <div class="ctext-wrap">
                                                            <i>Smith</i>
                                                            <p>
                                                                Hi, How are you? What about our next meeting?
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="clearfix">
                                                    <div class="chat-avatar">
                                                        <img src="<?php echo ASSETS; ?>images/avatar-1.jpg" alt="male">
                                                        <i>10:01</i>
                                                    </div>
                                                    <div class="conversation-text">
                                                        <div class="ctext-wrap">
                                                            <i>John Deo</i>
                                                            <p>
                                                                Yeah everything is fine
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="clearfix odd">
                                                    <div class="chat-avatar">
                                                        <img src="<?php echo ASSETS; ?>images/users/avatar-5.jpg" alt="male">
                                                        <i>10:02</i>
                                                    </div>
                                                    <div class="conversation-text">
                                                        <div class="ctext-wrap">
                                                            <i>Smith</i>
                                                            <p>
                                                                Wow that's great
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="row">
                                                <div class="col-sm-9 chat-inputbar">
                                                    <input type="text" class="form-control chat-input" placeholder="Enter your text">
                                                </div>
                                                <div class="col-sm-3 chat-send">
                                                    <button type="submit" class="btn btn-info btn-block waves-effect waves-light">Send</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>  end col


                             TODO 
                            <div class="col-lg-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title">Todo</h3> 
                                    </div> 
                                    <div class="panel-body todoapp"> 
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <h4 id="todo-message"><span id="todo-remaining"></span> of <span id="todo-total"></span> remaining</h4> 
                                            </div>
                                            <div class="col-sm-6">
                                                <a href="" class="pull-right btn btn-primary btn-sm waves-effect waves-light" id="btn-archive">Archive</a>
                                            </div>
                                        </div>

                                        <ul class="list-group no-margn nicescroll todo-list" style="max-height: 288px" id="todo-list"></ul>

                                         <form name="todo-form" id="todo-form" role="form" class="m-t-20">
                                            <div class="row">
                                                <div class="col-sm-9 todo-inputbar">
                                                    <input type="text" id="todo-input-text" name="todo-input-text" class="form-control" placeholder="Add new todo">
                                                </div>
                                                <div class="col-sm-3 todo-send">
                                                    <button class="btn-primary btn-block btn waves-effect waves-light" type="button" id="todo-btn-submit">Add</button>
                                                </div>
                                            </div>
                                        </form> 
                                    </div> 
                                </div>
                            </div>  end col 
                        </div>  end row -->

<script>

    //var dashboard = angular.module("viral_pro", ['ui.bootstrap']);
    //genUrlController
    var dashboardCon = viral_pro.controller("dashboardCon", function ($scope) {


        $scope.FormAction = "<?php echo SITEURL . "admin/dashboard" ?>";
        $scope.startDate = '';
        $scope.endDate = '';
        $scope.graphType = 1;
        $scope.today = 0.0;
        $scope.yesterday = 0.0;
        $scope.month = 0.0;


        $scope.$watch('graphType', function () {
            $scope.getGraphpData($scope.graphType);

        });
        $scope.searchByForm = function ()
        {
            $scope.startDate = $("#startDate").val();
            $scope.endDate = $("#endDate").val();
            $scope.getGraphpData($scope.graphType);
        };
        $scope.getGraphpData = function (type) {

            var url = $scope.FormAction;
            type = parseInt(type);
            console.log(type);
            switch (type)
            {
                case 1:
                    url = url + "/getgraph";
                    break;
                case 2:
                    url = url + "/getgraphEarning";
                    break;

            }
            ;

            $.ajax({
                url: url,
                type: 'POST',
                data: "startDate=" + $scope.startDate + "&endDate=" + $scope.endDate,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {

                    $scope.drawGraph(data['x'], data['y'], data['gtype'], data['sign'],data['title']);
                }
            });
        };

        $scope.getEarning = function (type)
        {
            var url = "<?php echo SITEURL . "admin/dashboard/Earningstats" ?>";
            $.ajax({
                url: url,
                type: 'POST',
                data: "type=" + type,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {

                    if (type == "today")
                    {
                        $scope.today =data['earn'];
                    }
                    if (type == "yesterday")
                    {
                        $scope.yesterday = data['earn'];
                    }
                    if (type == "month")
                    {

                        $scope.month = data['earn'];
                    }
                    $scope.$apply();
                }
            });
        };

        $scope.drawGraph = function (x, y, gtype, sign,title)
        {
            $('#webstats').highcharts({
                title: {
                    text: title,
                    x: -20 //center
                },
                subtitle: {
                    text: '',
                    x: -20
                },
                xAxis: {
                    categories: y
                },
                yAxis: {
                    title: {
                        text: gtype,
                    },
                    plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                },
                tooltip: {
                    valueSuffix: sign,
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: x
            });
        };

        $scope.getGraphpData(1);
        
        $scope.getEarning('today');
        $scope.getEarning('yesterday');
        $scope.getEarning('month');

    });

</script>
