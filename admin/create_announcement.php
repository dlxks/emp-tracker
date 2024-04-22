<?php
require_once('../config.php');

// Check session
require_once('include/session_check.php');

// Get active user
$id = $_SESSION['id'];
$stmt = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
$row = mysqli_fetch_assoc($stmt);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Create Announcement</title>

    <!-- CSS Include -->
    <?php include('include/header.php'); ?>

    <style>
        /* JQTE */
        .jqte_editor {
            min-height: 30vh !important;
        }
    </style>
</head>

<body>

    <!-- Top Navbar -->
    <?php include('include/navbar.php'); ?>
    <!-- Sidebar -->
    <?php include('include/sidebar.php'); ?>

    <!-- Main Slot -->
    <main id="main" class="main">
        <div class="contrainer">
            <!-- Page Header -->
            <div class="page-header px-5 py-2 text-custom-darkgreen">
                <h3 class="fw-bolder">Create Announcement</h3>
            </div>
            <!-- End Page Header -->

            <!-- Div Starter -->
            <div class="w-auto bg-custom-darkgreen px-4 py-2">
                <div class="d-flex justify-content-between">
                    <span class="text-light fw-bold">
                        <?= date_format($current_date_time, 'F j, Y (l)'); ?>
                    </span>
                    <span class="text-light fw-bold" id="clock">
                    </span>
                </div>
            </div>
            <!-- End Div Starter -->

            <!-- Alert Banner -->
            <?php if (isset($_COOKIE['data_err_message'])) {
            ?>
                <div class="alert <?= $_COOKIE['data_message_class']; ?> alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_COOKIE['data_err_message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>
            <?php
            }
            ?>
            <!-- End Alert Banner -->

            <div class="main-form">
                <div class="shadow mx-2 my-4 p-4 rounded-2">
                    <div class="row ">
                        <div class="col-lg-10 mx-auto">
                            <!-- Controls -->
                            <div class="row mb-4">
                                <div class="col-sm d-flex justify-content-start">
                                    <div class="d-inline-block">
                                        <a href="announcements.php" class="btn btn-danger"><span class="fa fa-chevron-left"></span> Return</a>
                                    </div>
                                </div>
                            </div>
                            <!-- End Controls -->
                            <form method="POST" action="actions/announcements_actions.php" enctype="multipart/form-data">

                                <div class="row mb-2">
                                    <div class="form-group">
                                        <label for="ann_title">Title *</label>
                                        <input id="ann_title" type="text" name="ann_title" class="form-control" placeholder="" required="required" data-error="Title is required.">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="form-group">
                                        <label for="ann_description" class="form-label">Details</label>
                                        <textarea name="ann_description" id="ann_description" class="form-control" cols="30" rows="5" placeholder="Enter your message/description here." required></textarea>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="ann_file">Attachment <i class="text-secondary">(optional)</i></label>
                                            <input type="file" id="ann_file" name="ann_file" class="form-control" onchange="displayImg2(this,$(this))">
                                            <i class="text-secondary"> You can only attach one file (JPG, PNG, GIF)</i>
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <img src="<?php echo isset($banner) ? '../uploads/' . $banner : '' ?>" alt="" id="banner-field" class="img-thumbnail rounded">
                                    </div>
                                </div>

                                <div class="row mb-2">

                                    <div class="col-md-12">
                                        <input type="submit" class="btn btn-success  pt-2 btn-block" value="Save">
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </main>
    <!-- End Main Slot -->

    <!-- JS Include -->
    <?php include('include/footer.php'); ?>

    <script>
        $("#ann_description").jqte();

        setTimeout(function() {
            $('.alert').alert('close');
        }, 7200);


        function displayIMG(input) {

            if (input.files) {
                if ($('#dname').length > 0)
                    $('#dname').remove();

                Object.keys(input.files).map(function(k) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        // $('#cimg').attr('src', e.target.result);
                        var bin = e.target.result;
                        var fname = input.files[k].name;
                        var imgF = document.getElementById('img-clone');
                        imgF = imgF.cloneNode(true);
                        imgF.removeAttribute('id')
                        imgF.removeAttribute('style')
                        var img = document.createElement("img");
                        var fileinput = document.createElement("input");
                        var fileinputName = document.createElement("input");
                        fileinput.setAttribute('type', 'hidden')
                        fileinputName.setAttribute('type', 'hidden')
                        fileinput.setAttribute('name', 'img[]')
                        fileinputName.setAttribute('name', 'imgName[]')
                        fileinput.value = bin
                        fileinputName.value = fname
                        img.classList.add("imgDropped")
                        img.src = bin;
                        imgF.appendChild(fileinput);
                        imgF.appendChild(fileinputName);
                        imgF.appendChild(img);
                        drop.appendChild(imgF)
                    }
                    reader.readAsDataURL(input.files[k]);
                })

                rem_func()

            }
        }

        function displayImg2(input, _this) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#banner-field').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function rem_func(_this) {
            _this.closest('.imgF').remove()
            if ($('#drop .imgF').length <= 0) {
                $('#drop').append('<span id="dname" class="text-center">Drop Files Here</label></span>')
            }
        }
    </script>

</body>

</html>