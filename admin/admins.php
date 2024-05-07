<?php include('includes/header.php'); ?>

<div class="container-fluid px-4 ">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Admins/Staff
                <a href="admins-create.php" class="btn btn-primary float-end">Add Admin</a>
            </h4>
            
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>