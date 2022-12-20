<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}
include("config/db_config.php");
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

</head>

<body class="color-theme-blue mont-font">

<div class="preloader"></div>


<div class="main-wrapper">

    <!-- navigation top-->
    <div class="nav-header bg-white shadow-xs border-0">
        <div class="nav-top">
            <a href="index.php"><i class="feather-zap text-success display1-size me-2 ms-0"></i><span
                        class="d-inline-block fredoka-font ls-3 fw-600 text-current font-xxl logo-text mb-0">GogoJob. </span>
            </a>
            <a href="#" class="me-2 menu-search-icon mob-menu ms-5"><i class="feather-search text-grey-900 font-sm btn-round-md bg-greylight"></i></a>
        </div>
        <form class="float-left header-search" style="margin-left: 25%;">
            <div class="form-group mb-0 icon-input">
                <i class="feather-search font-sm text-grey-400"></i>
                <input type="text" id="filter" placeholder="Start typing to search.." class="bg-grey border-0 lh-32 pt-2 pb-2 ps-5 pe-3 font-xssss fw-500 rounded-xl w350 theme-dark-bg">
            </div>
        </form>


        <a href="logout.php" class="p-2 text-center ms-auto menu-icon">Log Out</a>

    </div>
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
                                <h2 class="fw-700 mb-0 mt-0 font-md text-grey-900">New Jobs</h2>
                            </div>
                        </div>

                        <?php
                        $fetch_post = $con->query("select * from post where status = '1'");
                        if ($fetch_post->num_rows > 0) {
                            while ($post = mysqli_fetch_assoc($fetch_post)) {
                                ?>
                                <div class="row ps-2 pe-1" id="post">
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
                                                                style="font-size: 25px !important;"><?php echo $post['company_name']; ?></h2>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="text-center">
                                                            <h2 class="fw-700 font-xsss mt-3 mb-1"><?php echo $post['salary']; ?></h2>
                                                        </div>
                                                        <div class="text-center">
                                                            <h2 class="fw-700 font-xsss mt-3 mb-1"><?php echo $post['location']; ?></h2>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-3 text-center">
                                                    <?php
                                                    $post_id = $post['id'];
                                                    $user_id = $_SESSION['user'];
                                                    $check_saved_post = $con->query("select * from saved_post where post_id = '$post_id' and user_id = '$user_id'");
                                                    if ($check_saved_post->num_rows > 0) {
                                                        $saved = 0;
                                                    } else {
                                                        $saved = 1;
                                                    }
                                                    ?>
                                                    <div class="col-6">
                                                        <button id="<?php echo $post['id']; ?>"
                                                                onclick="save_post(<?php echo $post['id'] ?>)"
                                                                class="text-center p-2 lh-24 w125 ms-1 ls-3 d-inline-block rounded-xl bg-current font-xsss fw-700 ls-lg text-white" <?php if ($saved == 0) echo 'disabled'; ?>>
                                                            <?php
                                                            if ($saved == 0) echo 'Post Saved'; else echo 'Save Post';
                                                            ?>
                                                        </button>
                                                    </div>
                                                    <div class="col-6">
                                                        <?php
                                                        $select_query = $con->query("SELECT * FROM `applicants` WHERE user_id = '$user_id' and job_id = '$post_id'");
                                                        if($select_query-> num_rows > 0){
                                                            $applied = 0;
                                                            while($status = mysqli_fetch_assoc($select_query)){
                                                                if($status['status'] == 1){
                                                                    $applied = 2;
                                                                }
                                                            }
                                                        }else{
                                                            $applied = 1;
                                                        }

                                                        ?>
                                                            <button onclick="apply(<?php echo $post['id'];?>)" class="text-center p-2 lh-24 w125 ms-1 ls-3 d-inline-block rounded-xl bg-current font-xsss fw-700 ls-lg text-white" <?php if ($applied == 0) echo 'disabled'; ?>>
                                                                <?php
                                                                if ($applied == 0) echo 'Pending'; elseif ($applied == 1)  echo 'Apply Now'; elseif ($applied == 2)  echo 'Approved';
                                                                ?>
                                                            </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo "nothing posted";
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


<script>
    function save_post(clicked) {
        var post_id = clicked;
        $("#", post_id).attr("disabled", "disabled");
        var post_id = clicked;
        $.ajax({
            url: "save_post.php",
            type: "POST",
            data: {
                post_id: post_id
            },
            cache: false,
            success: function (dataResult) {
                var dataResult = JSON.parse(dataResult);
                if (dataResult.statusCode == 200) {
                    $('#', clicked).html('Post Saved!');
                    alert("Post Saved Successfully!");
                    console.log(post_id);
                } else if (dataResult.statusCode == 201) {
                    alert("Error occured !");
                }

            }
        });
    }

    function apply(clicked) {
        var post_id = clicked;
        $.ajax({
            url: "apply.php",
            type: "POST",
            data: {
                post_id: post_id
            },
            cache: false,
            success: function (dataResult) {
                var Result = JSON.parse(dataResult);
                if (Result.statusCode == 200) {
                    alert("Successfully Applied for the Job");
                    console.log(post_id);
                } else if (Result.statusCode == 201) {
                    alert("Error occured !");
                }else if (Result.statusCode == 202) {
                    alert("You have already applied for the job!");
                }

            }
        });
    }
</script>

<script>
    /*for search function*/
    $(document).ready(function () {
        $("#filter").keyup(function () {

            // Retrieve the input field text and reset the count to zero
            var filter = $(this).val(), count = 0;

            // Loop through the comment list
            $("#post").each(function () {

                // If the list item does not contain the text phrase fade it out
                if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                    $(this).fadeOut();

                    // Show the list item if the phrase matches and increase the count by 1
                } else {
                    $(this).show();
                    count++;
                }
            });

            // Update the count
            var numberItems = count;
            console.log($("#filter-count").text("Number of Filter = " + count));
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

<script src="js/plugin.js"></script>
<script src="js/scripts.js"></script>

</body>


</html>