<?php
session_start();
include('config/db_config.php');
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

if (isset($_POST["uploadDocument"])) {
    $image = '';
    $user_id = $_SESSION['user'];
    if (!empty($_FILES['document']['name'])) {
        $RandomAccountNumber = mt_rand(1, 99999);
        $file_name = $RandomAccountNumber . "_" . $_FILES['document']['name'];
        $file_size = $_FILES['document']['size'];
        $file_tmp = $_FILES['document']['tmp_name'];

        $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if (
            $file_type != "jpg" && $file_type != "png" && $file_type != "jpeg"
            && $file_type != "gif" && $file_type != "pdf"
        ) {
            $attach_files = '';

            echo "<script>
                alert('Document Not Supported');
                window.location.href='profile.php';
                </script>";
        } else {
            move_uploaded_file($file_tmp, "images/document/" . $file_name);
            $image = "images/document/" . $file_name;
            $add_image = $con->query("INSERT INTO `profile_document`( `user_id`, `image`) VALUES ('$user_id','$image')");
            if ($add_image) {
                echo "<script>
                alert('Document Uploaded Successfully');
                window.location.href='profile.php';
                </script>";
            } else {
                echo "<script>
                alert('Something Went Wrong');
                window.location.href='profile.php';
                </script>";
            }
        }
    }
}

if (isset($_GET['document_id'])) {
    $data = $con->query("select * FROM `profile_document` WHERE id='{$_GET['document_id']}'");

    if ($data->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($data)) {
            unlink($row['image']);
        }
    }

    $con->query("delete from profile_document where id=" . $_GET['document_id'] . "");

    echo "<script>
                alert('Document Delete Successfully');
                window.location.href='profile.php';
                </script>";
}
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GogoJob</title>

    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/feather.css">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        .modal-backdrop.show {
            display: none;
        }
    </style>
</head>

<body class="color-theme-blue mont-font">

<div class="preloader"></div>


<div class="main-wrapper">

    <!-- navigation top-->
    <?php include('include/navigation_top.php'); ?>
    <!-- navigation top -->

    <!-- navigation left -->
    <?php include('include/navigation_left.php'); ?>
    <!-- navigation left -->


    <!-- main content -->
    <div class="main-content right-chat-active">

        <div class="middle-sidebar-bottom">
            <div class="middle-sidebar-left pe-0">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card shadow-xss w-100 d-block d-flex border-0 p-4 mb-3">
                            <div class="card-body flex text-center p-0">
                                <h2 class="fw-700 mb-0 mt-0 font-md text-grey-900">Profile</h2>
                            </div>
                        </div>
                        <div class="row ps-2 pe-1">
                            <div class="col-md-12 col-sm-12 pe-2 ps-2" style="box-shadow: -26px 2px 2px 0px rgba(0,88,255,1);
-webkit-box-shadow: -26px 2px 2px 0px rgba(0,88,255,1);
-moz-box-shadow: -26px 2px 2px 0px rgba(0,88,255,1);">
                                <div class="card d-block border-0 shadow-xss rounded-3 overflow-hidden">
                                    <div class="card-body d-block w-100 pe-4 ps-4 pb-4 pt-0 text-left position-relative">
                                        <div class="clearfix">
                                        </div>
                                        <div class="row">
                                            <div class="col-12 text-center my-auto">
                                                <form action="" method="post" enctype="multipart/form-data">
                                                    <div class="mb-3">
                                                        <label for="document" class="form-label">Upload Document</label>
                                                        <input class="form-control" type="file" name="document"
                                                               id="document" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary" name="uploadDocument">
                                                        Upload
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-striped text-center">
                                        <thead>
                                        <tr>
                                            <th scope="col">Serial</th>
                                            <th scope="col">Document</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $user_id = $_SESSION['user'];
                                        $fetch_document = $con->query("select * from profile_document where user_id = '$user_id'");
                                        $i = 0;
                                        if ($fetch_document->num_rows > 0) {
                                            while ($row = mysqli_fetch_assoc($fetch_document)) {
                                                $i++;
                                                ?>
                                                <tr>
                                                    <th scope="row"><?php echo $i; ?></th>
                                                    <td><a href="<?php echo $row['image']; ?>"
                                                           target="_blank">document_<?php echo $i; ?></a></td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                                data-bs-target="#staticBackdrop<?php echo $row['id']; ?>">
                                                            Delete <i
                                                                    class="feather-delete"></i></button>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="staticBackdrop<?php echo $row['id']; ?>"
                                                             data-bs-backdrop="static" data-bs-keyboard="false"
                                                             tabindex="-1" aria-labelledby="staticBackdropLabel"
                                                             aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="staticBackdropLabel">Are You Sure?</h5>
                                                                        <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Delete Document</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Close
                                                                        </button>
                                                                        <a href="profile.php?document_id=<?php echo $row['id']; ?>"
                                                                           class="btn btn-primary">Delete</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <th colspan="3">No Data Found</th>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--whatsapp button-->
        <?php include('include/whatsapp.php'); ?>
    </div>
    <!-- main content -->


    <div class="app-footer border-0 shadow-lg bg-primary-gradiant">
        <a href="index.php" class="nav-content-bttn nav-center"><i class="feather-home"></i></a>
        <a href="saved_jobs.php" class="nav-content-bttn"><i class="feather-package"></i></a>
        <a href="#" class="nav-content-bttn"><img src="images/female-profile.png" alt="user"
                                                  class="w30 shadow-xss"></a>
    </div>

    <div class="app-header-search">
        <form class="search-form">
            <div class="form-group searchbox mb-0 border-0 p-1">
                <input type="text" class="form-control border-0" placeholder="Search...">
                <i class="input-icon">
                    <ion-icon name="search-outline" role="img" class="md hydrated"
                              aria-label="search outline"></ion-icon>
                </i>
                <a href="#" class="ms-1 mt-1 d-inline-block close searchbox-close">
                    <i class="ti-close font-xs"></i>
                </a>
            </div>
        </form>
    </div>

</div>


<script src="js/plugin.js"></script>
<script src="js/scripts.js"></script>

</body>


</html>
