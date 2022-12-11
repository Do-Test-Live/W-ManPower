<?php
session_start();
include ('config/db_config.php');
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
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

</head>

<body class="color-theme-blue mont-font">

<div class="preloader"></div>


<div class="main-wrapper">

    <!-- navigation top-->
    <?php include ('include/navigation_top.php');?>
    <!-- navigation top -->

    <!-- navigation left -->
    <?php include ('include/navigation_left.php');?>
    <!-- navigation left -->


    <!-- main content -->
    <div class="main-content right-chat-active">

        <div class="middle-sidebar-bottom">
            <div class="middle-sidebar-left pe-0">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card shadow-xss w-100 d-block d-flex border-0 p-4 mb-3">
                            <div class="card-body flex text-center p-0">
                                <h2 class="fw-700 mb-0 mt-0 font-md text-grey-900">Saved Jobs</h2>
                            </div>
                        </div>

                        <?php
                        $user_id = $_SESSION['user'];
                        $fetch_post = $con->query("select * from saved_post where user_id = '$user_id'");
                        if($fetch_post-> num_rows > 0){
                            while($post_id = mysqli_fetch_assoc($fetch_post)){
                                $post_found = $post_id['post_id'];
                                $fetch_post_details = $con->query("select * from post where id = '$post_found'");
                                if($fetch_post_details){
                                    while($post = mysqli_fetch_assoc($fetch_post_details)){
                                        ?>
                                        <div class="row ps-2 pe-1">
                                            <div class="col-md-12 col-sm-12 pe-2 ps-2" style="box-shadow: -26px 2px 2px 0px rgba(0,88,255,1);
-webkit-box-shadow: -26px 2px 2px 0px rgba(0,88,255,1);
-moz-box-shadow: -26px 2px 2px 0px rgba(0,88,255,1);">
                                                <div class="card d-block border-0 shadow-xss rounded-3 overflow-hidden">
                                                    <div class="card-body d-block w-100 pe-4 ps-4 pb-4 pt-0 text-left position-relative">
                                                        <div class="clearfix">
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6 text-center my-auto">
                                                                <div class="text-center">
                                                                    <h2 class="fw-700 font-xsss mt-3 mb-1"
                                                                        style="font-size: 25px !important;"><?php echo $post['company_name'];?></h2>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="text-center">
                                                                    <h2 class="fw-700 font-xsss mt-3 mb-1"><?php echo $post['salary'];?></h2>
                                                                </div>
                                                                <div class="text-center">
                                                                    <h2 class="fw-700 font-xsss mt-3 mb-1"><?php echo $post['location'];?></h2>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                            }
                        }
                        ?>



                    </div>
                </div>
            </div>

        </div>
        <!--whatsapp button-->
        <?php include ('include/whatsapp.php');?>
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

<div class="modal bottom side fade" id="Modalstries" tabindex="-1" role="dialog" style=" overflow-y: auto;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 bg-transparent">
            <button type="button" class="close mt-0 position-absolute top--30 right--10" data-dismiss="modal"
                    aria-label="Close"><i class="ti-close text-white font-xssss"></i></button>
            <div class="modal-body p-0">
                <div class="card w-100 border-0 rounded-3 overflow-hidden bg-gradiant-bottom bg-gradiant-top">
                    <div class="owl-carousel owl-theme dot-style3 story-slider owl-dot-nav nav-none">
                        <div class="item"><img src="images/story-5.jpg" alt="image"></div>
                        <div class="item"><img src="images/story-6.jpg" alt="image"></div>
                        <div class="item"><img src="images/story-7.jpg" alt="image"></div>
                        <div class="item"><img src="images/story-8.jpg" alt="image"></div>

                    </div>
                </div>
                <div class="form-group mt-3 mb-0 p-3 position-absolute bottom-0 z-index-1 w-100">
                    <input type="text"
                           class="style2-input w-100 bg-transparent border-light-md p-3 pe-5 font-xssss fw-500 text-white"
                           value="Write Comments">
                    <span class="feather-send text-white font-md text-white position-absolute"
                          style="bottom: 35px;right:30px;"></span>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="js/plugin.js"></script>
<script src="js/scripts.js"></script>

</body>


</html>