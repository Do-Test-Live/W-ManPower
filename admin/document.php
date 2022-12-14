<?php
$result = 0;
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: index.php");
}
include('../config/db_config.php');

if (isset($_GET['document_id'])) {
    $data = $con->query("select * FROM `profile_document` WHERE id='{$_GET['document_id']}'");

    if ($data->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($data)) {
            unlink('../'.$row['image']);
        }
    }

    $con->query("delete from profile_document where id=" . $_GET['document_id'] . "");

    echo "<script>
                alert('Document Delete Successfully');
                window.location.href='document.php';
                </script>";
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

    <title>Document - GogoJob</title>

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

                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>Sl. No</th>
                        <th>Name</th>
                        <th>Document</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $select_post = $con->query("select * from profile_document, user where user.user_id = profile_document.user_id order by profile_document.id desc");
                    if($select_post->num_rows > 0){
                        $sl = 1;
                        while($post = mysqli_fetch_assoc($select_post)){
                            ?>
                            <tr>
                                <td><?php echo $sl;?></td>
                                <td><?php echo $post['user_name']; ?></td>
                                <td><a href="../<?php echo $post['image']; ?>"
                                       target="_blank">document_<?php echo $sl; ?></a></td>
                                <td>
                                    <button data-toggle="modal" data-target="#exampleModal<?php echo $sl; ?>" class="btn btn-danger">Delete</button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal<?php echo $sl; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Are You Sure?</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Delete Document</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <a href="document.php?document_id=<?php echo $post['id'];?>"
                                                       class="btn btn-primary">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            $sl++;
                        }
                    }
                    ?>
                    </tbody>
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
                        <label for="exampleInputEmail1">Company Name</label>
                        <input type="text" name="company_name" class="form-control" id="exampleInputEmail1" placeholder="Enter company name">
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
