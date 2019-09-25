<div class="row" ng-app="payment"  ng-controller="payment_cont">
   

    <div class="col-sm-12">
      

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
<script>

</script>



</div> <!-- panel -->
</div> <!-- col -->
</div>

<script>
    var payment_post = angular.module("payment",  ['ui.bootstrap']);
    payment_post.controller("payment_cont", function ($scope) {

        

    //    $scope.getPost(0);

    });


</script>
