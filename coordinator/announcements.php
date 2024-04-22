<?php
include('../config.php');

// Check session
require_once('include/session_check.php');

// Get active user
$id = $_SESSION['id'];
$stmt = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
$row = mysqli_fetch_assoc($stmt);

$user_branch = $row['branch_id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Announcements</title>

    <!-- CSS Include -->
    <?php include('include/header.php'); ?>
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
                <h3 class="fw-bolder">Announcements</h3>
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

        </div>
    </main>
    <!-- End Main Slot -->

    <!-- JS Include -->
    <?php include('include/footer.php'); ?>

    <!-- Live Search -->
    <script>
        $(document).ready(function() {

            // Searching
            $('#record_search').on("keyup", function() {
                var record_search = $(this).val();
                $.ajax({
                    method: 'POST',
                    url: 'fetch/records.php',
                    data: {
                        record_search: record_search
                    },
                    success: function(response) {
                        $("#show_records").html(response);
                    }
                });
            });

            // Per page function
            $('#per_page').on('change', function() {
                const perpage = $(this).val();
                const urlParams = new URLSearchParams(window.location.search);
                urlParams.set('per_page', perpage);
                urlParams.set('page', 1);
                window.location.search = urlParams.toString();
            });

            // Year picker
            $("#year").datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                autoclose: true //to close picker once year is selected
            });

            // Year picker
            $("#r_year").datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                autoclose: true //to close picker once year is selected
            });
        });

        // Set Alert Timeout
        setTimeout(function() {
            $('.alert').alert('close');
        }, 7200);
    </script>

</body>

</html>