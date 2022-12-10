<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: index.php");
}
include('../config/db_config.php');
$id = $_GET['id'];
$result = 0;

if (isset($_POST['update_post'])){
    $company_name = mysqli_real_escape_string($con, $_POST['company_name']);
    $salary = mysqli_real_escape_string($con, $_POST['salary']);
    $location = mysqli_real_escape_string($con, $_POST['location']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $update_post = $con->query("UPDATE `post` SET `company_name`='$company_name',`salary`='$salary',`location`='$location',`status`='$status' WHERE id='$id'");
    if($update_post){
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

    <title>Post Edit - GogoJob</title>

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

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <form action="" method="post">
                    <?php
                    $post_select = $con->query("select * from post where id='$id'");
                    if($post_select){
                        while($post = mysqli_fetch_assoc($post_select)){
                            ?>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Job position</label>
                                <input type="text" name="company_name" class="form-control" value="<?php echo $post['company_name'];?>" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hour Rate</label>
                                <input type="text" name="salary" class="form-control" value="<?php echo $post['salary'];?>" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Location</label>
                                <input type="text" name="location" class="form-control" value="<?php echo $post['location'];?>" required>
                            </div>
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Status</label>
                                    <select class="form-control" id="exampleFormControlSelect1" name="status" required>
                                        <option <?php echo $post['status'];?>><?php if($post['status'] == 1) echo "Public"; else echo "Private"?></option>
                                        <option value="1">Public</option>
                                        <option value="0">Private</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="update_post" class="btn btn-primary">Submit</button>
                            <?php
                        }
                    }
                    ?>
                </form>

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

<?php require_once 'include/js.php'; ?>

</body>

</html>
