<?php include "../../init/init.php"; ?>




<div class="container py-5">
    <h3>
        Cources
    </h3>
    <hr />
    <a class="btn btn-block mb-3 btn-primary" href="add.php">Add New</a>

    <div class="table-responsive">


        <table id="example" class="table table-striped  table-hover table-bordered w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Location</th>
                    <th>DeadLine</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Category</th>
                    <th>Lecturer</th>
                    <th>certificate</th>
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
                    <td>2011/04/25</td>
                    <td>$320,800</td>
                    <td>$320,800</td>
                    <td>$320,800</td>
                    <td>
                        <a class="btn btn-sm mb-1 btn-dark" href="show.php">Details</a>
                        <a class="btn btn-sm mb-1 btn-dark" href="edit.php">Edit</a>
                        <a class="btn btn-sm mb-1 btn-danger" href="delete.php">Delete</a>
                    </td>
                </tr>
                <tr>
                    <td>mnhbg Nixon</td>
                    <td>mjnhbg Architect</td>
                    <td>,mjnhbg</td>
                    <td>,kmjnhbg</td>
                    <td>2011/04/25</td>
                    <td>2011/04/25</td>
                    <td>$mjnhb,800</td>
                    <td>$mjnhb,800</td>
                    <td>$mjnhuyt,800</td>
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
                    <th>Location</th>
                    <th>DeadLine</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Category</th>
                    <th>Lecturer</th>
                    <th>certificate</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>

</div>
<?php include "../includes/footer.php"; ?>