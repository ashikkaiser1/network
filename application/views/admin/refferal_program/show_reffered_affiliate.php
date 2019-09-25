<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>

                <th>#ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Status</th>

            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="user in all_reffusers" ng-cloak="" >
                <td>
                    {{user.uid}}  
                </td>
                <td>
                    {{user.name}}  
                </td>
<!--                                        <td>{{user.DOJ}}</td>-->
<!--                                        <td>{{user.username}}</td>-->
<!--                                        <td>{{user.email}}</td>-->
                <td>{{user.email}}</td>
                <td>{{user.mobile}}</td>

                <td>
                    <span ng-if="user.u_status == 0" class="text-danger">Inactive</span>
                    <span ng-if="user.u_status == 1" class="text-success">Active</span>
                    <span ng-if="user.u_status == 2" class="text-warning">Pending</span>
                    <span ng-if="user.u_status == 3" class="text-danger">Block</span>
                    <span ng-if="user.u_status == 4" class="text-danger">Rejected</span>
                    <span ng-if="user.u_status == 5" class="text-danger">Deleted</span>
                </td>



            </tr>
        </tbody>
    </table>

    <div class="text-danger text-center" ng-if="all_reffusers == ''">
        <h3 class='text-danger'>There is no data available ....</h3>
    </div>
</div>