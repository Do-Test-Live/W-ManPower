<?php
$result = 0;
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: index.php");
}
include('../config/db_config.php');
if (isset($_POST['add_post'])){
    $company_name = mysqli_real_escape_string($con, $_POST['company_name']);
    $salary = mysqli_real_escape_string($con, $_POST['salary']);
    $location = mysqli_real_escape_string($con, $_POST['location']);
    $post_insert = $con->query("INSERT INTO `post`(`company_name`, `salary`, `location`) VALUES ('$company_name','$salary','$location')");
    if($post_insert){
        $result = 1;
    }else{
        $result = 2;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Post - GogoJob</title>

    <?php require_once 'include/css.php'; ?>

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <?php require_once 'include/sidebar.php'; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <?php require_once 'include/topbar.php'; ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary my-3" data-toggle="modal" data-target="#exampleModal">
                    Add Post
                </button>

                <?php
                if ($result == 1){
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Thank You!</strong> Post has been updated successfully!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php
                }elseif ($result == 2){
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Sorry!</strong> Something went wrong!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php
                }
                ?>

                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>Sl. No</th>
                        <th>Job Position</th>
                        <th>Hour Rate</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Edit</th>
                    </tr>
                    </thead>
                    <tbody>

                        <?php
                        $select_post = $con->query("select * from post order by id desc");
                        if($select_post->num_rows > 0){
                            $sl = 0;
                            while($post = mysqli_fetch_assoc($select_post)){
                                $sl++;
                                ?>
                        <tr>
                                <td><?php echo $sl;?></td>
                                <td><?php echo $post['company_name'];?></td>
                                <td><?php echo $post['salary'];?></td>
                                <td><?php echo $post['location'];?></td>
                                <td><?php if($post['status'] == 1) echo '<span class="badge badge-success">Public</span>'; else echo '<span class="badge badge-danger">Private</span>';?></td>
                                <td><a href="edit_post.php?id=<?php echo $post['id'];?>"><span class="badge badge-primary">Edit</span></a></td>
                        </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Sl. No</th>
                        <th>Company Name</th>
                        <th>Salary (HKD)</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Edit</th>
                    </tr>
                    </tfoot>
                </table>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <?php require_once 'include/footer.php'; ?>

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="logout.php">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Position</label>
                        <input type="text" name="company_name" class="form-control" id="exampleInputEmail1" placeholder="Position">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Salary</label>
                        <input type="text" name="salary" class="form-control" id="exampleInputPassword1" placeholder="Enter salary">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Location</label>
                        <input type="text" name="location" class="form-control" id="exampleInputPassword1" placeholder="Enter location">
                    </div>
                    <button type="submit" name="add_post" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>

<?php require_once 'include/js.php'; ?>

</body>

</html>
