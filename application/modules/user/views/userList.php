<div class="row">
<div class="col-md-12">
    <div class="card">
        <div class="card-header ch-alt m-b-20">
            <h2><?php echo $pageTitle; ?></h2>
            <button id="add-user" class="btn bgm-amber btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="user-grid" class="table table-hover table-vmiddle" data-ajax="true" data-url="<?php echo base_url('user/loadGrid'); ?>">
                    <thead>
                        <tr>
                            <th data-column-id="id" data-identifier="true" data-visible="false">ID</th>
                            <th data-column-id="profilePicture" data-formatter="profilePicture">Image</th>
                            <th data-column-id="username">Username</th>
                            <th data-column-id="firstName">First Name</th>
                            <th data-column-id="lastName">Last Name</th>
                            <th data-column-id="email">Email</th>
                            <th data-column-id="companyName">Company</th>
                            <th data-column-id="userRole">Permission Level</th>
                            <th data-column-id="createdAt" data-order="desc" data-visible="false">Created At</th>
                            <th data-align="center" data-header-align="center" data-column-id="action" data-formatter="action" data-sortable="false">Action
                            </th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

