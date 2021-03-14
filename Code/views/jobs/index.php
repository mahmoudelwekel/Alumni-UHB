<?php include "../../init/init.php"; ?>




<div class="container py-5">
    <h3>
        Jobs
    </h3>
    <hr />
    <a class="btn btn-block mb-3 btn-primary" href="add.php">Add New</a>

    <div class="table-responsive">


        <table id="example" class="table table-striped  table-hover table-bordered w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Company</th>
                    <th>Link</th>
                    <th>Details</th>
                    <th></th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Tiger Nixon</td>
                    <td>System Architect</td>
                    <td>Edinburgh</td>
                    <td>61</td>
                    <td>2011/04/25</td>
                    
                    <td>
                        <a class="btn btn-sm mb-1 btn-dark" href="show.php">Details</a>
                        <a class="btn btn-sm mb-1 btn-dark" href="edit.php">Edit</a>
                        <a class="btn btn-sm mb-1 btn-danger" href="delete.php">Delete</a>
                    </td>
                </tr>
                <tr>
                <td>Tiger Nixon</td>
                    <td>System Architect</td>
                    <td>Edinburgh</td>
                    <td>61</td>
                    <td>2011/04/25</td>
                    <td>
                        <a class="btn btn-sm mb-1 btn-dark" href="show.php">Details</a>
                        <a class="btn btn-sm mb-1 btn-dark" href="edit.php">Edit</a>
                        <a class="btn btn-sm mb-1 btn-danger" href="delete.php">Delete</a>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                <th>ID</th>
                    <th>Title</th>
                    <th>Company</th>
                    <th>Link</th>
                    <th>Details</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>

</div>
<?php include "../includes/footer.php"; ?>