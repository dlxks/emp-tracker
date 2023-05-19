<?php
include('../config.php');

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

    <title>Users</title>

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
                <h3 class="fw-bolder">Users</h3>
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

            <div class="main-table">

                <?php

                // Set the number of records to be displayed per page
                $per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 10;

                // Determine the current page number
                $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

                // Calculate the starting record number and the ending record number
                $starting_record = ($current_page - 1) * $per_page;
                $ending_record = $starting_record + $per_page - 1;
                ?>

                <div class="table-wrap shadow mx-2 my-4 p-4 rounded-2" role="region" aria-labelledby="Cap1" tabindex="0">
                    <!-- Table Controls -->
                    <div class="row">
                        <!-- Per Page -->
                        <div class="col-sm sm:d-flex sm:justify-content-end">
                            <div class="d-inline-block">
                                <form method="get" class="">
                                    <div class="form-group ">
                                        <div class="input-group mb-3">
                                            <label class="input-group-text" id="inputGroup-sizing-sm">Show</label>
                                            <select id="per_page" name="per_page" class="form-control">
                                                <option value="1" <?= $per_page == 1 ? 'selected' : '' ?>>1</option>
                                                <option value="10" <?= $per_page == 10 ? 'selected' : '' ?>>10</option>
                                                <option value="25" <?= $per_page == 25 ? 'selected' : '' ?>>25</option>
                                                <option value="50" <?= $per_page == 50 ? 'selected' : '' ?>>50</option>
                                                <option value="100" <?= $per_page == 100 ? 'selected' : '' ?>>100</option>
                                            </select>
                                            <label class="input-group-text" id="inputGroup-sizing-sm">entries</label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Search -->
                        <div class="col-sm d-flex justify-content-end">
                            <div class="d-inline-block">
                                <input type="text" id="record_search" name="record_search" placeholder="Search here" class="form-control" />
                            </div>
                            <div class="d-inline-block">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addAdmin"><span class="fa fa-circle-plus"></span> Add</button>
                                <?php include('modals/admin_modal.php'); ?>
                            </div>
                        </div>
                        <!-- Button -->

                    </div>
                    <!-- End Table Controls -->

                    <!-- Modal Container -->
                    <div class="modal-container"></div>
                    <!-- End Modal Container -->

                    <table id="data_table" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Branch</th>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="show_users">
                            <?php

                            // Write a MySQL query to retrieve the records for the current page
                            $sql = "SELECT us.*, br.id as branch_id, br.branch_name
                            FROM users as us 
                            INNER JOIN branches as br 
                            ON us.branch_id = br.id 
                            HAVING us.role = 'admin' 
                            ORDER BY employee_id ASC
                            LIMIT $starting_record, $per_page";

                            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                            if ($count = mysqli_num_rows($result) == 0) {
                            ?>
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <span class="fw-bold text-danger">No Records</span>
                                    </td>
                                </tr>
                                <?php
                            } else {

                                // Display the records 
                                while ($row = mysqli_fetch_assoc($result)) {
                                    // display table row
                                    $id = $row['id'];
                                ?>
                                    <tr>
                                        <td><?= $row['branch_name']; ?></td>
                                        <td><?= $row['employee_id']; ?></td>
                                        <td><?= $row['first_name'] . " " . $row['last_name']; ?></td>
                                        <td><?= $row['email']; ?></td>
                                        <td><?= $row['status']; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editAdmin<?= $id; ?>"><span class="fa fa-pen-to-square"></span> View</button>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAdmin<?= $id; ?>"><span class="fa fa-trash"></span> Remove</button>
                                        </td>
                                        <?php include('modals/admin_modal.php'); ?>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>

                    <!-- Add pagination controls -->
                    <ul class="pagination justify-content-end ">
                        <?php
                        // Get the total number of records
                        $sql = "SELECT COUNT(*) AS total_records FROM users WHERE role = 'admin'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $total_records = $row['total_records'];

                        // Calculate the total number of pages
                        $total_pages = ceil($total_records / $per_page);

                        if ($current_page > 1) {
                        ?>
                            <li class=""><a href="?page=<?= ($current_page - 1) . '&per_page=' . $per_page; ?>" class="text-decoration-none btn"><i class="fa-solid fa-circle-chevron-left"></i> Previous</a></li>
                        <?php
                        }

                        for ($i = 1; $i <= $total_pages; $i++) {
                            $active = $i == $current_page ? 'active' : '';
                        ?>
                            <li class="<?= $active; ?> "><a href="?page=<?= $i . '&per_page=' . $per_page; ?>" class="p-hover text-decoration-none btn"><?= $i ?></a></li>
                        <?php
                        }

                        if ($current_page < $total_pages) {
                        ?>
                            <li class=""><a href="?page=<?= ($current_page + 1) . '&per_page=' . $per_page; ?>" class="text-decoration-none btn">Next <i class="fa-solid fa-circle-chevron-right"></i> </a></li>
                        <?php
                        }
                        ?>
                    </ul>
                    <!-- End Pagination Controls -->

                </div>
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
                var admin_search = $(this).val();
                $.ajax({
                    method: 'POST',
                    url: 'fetch/admin_users.php',
                    data: {
                        admin_search: admin_search
                    },
                    success: function(response) {
                        $("#show_users").html(response);
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

            // disable submit button until all required fields are filled
            $('#addForm input[type="submit"]').prop("disabled", true);
            $("#addForm input[required]").keyup(function() {
                var empty = false;
                $("form input[required]").each(function() {
                    if ($(this).val() == "") {
                        empty = true;
                    }
                });
                if (empty) {
                    $('#addForm input[type="submit"]').prop("disabled", true);
                } else {
                    $('#addForm input[type="submit"]').prop("disabled", false);
                }
            });

            // assign automatic password
            $("#employee_id, #lastname").on("input", function() {
                var value1 = $('#employee_id').val();
                var value2 = $('#lastname').val();
                $('#password').val(value1 + value2);
                $('#confirm_password').val(value1 + value2);
                $('#add_message').html('Password is automatically generated. The password is Employee ID + Last Name').css('color', 'green');
            });
        });
        
        // disable submit button until all required fields are filled
        $('#addForm input[type="submit"]').prop("disabled", true);
        $("#addForm input[required]").keyup(function() {
            var empty = false;
            $("form input[required]").each(function() {
                if ($(this).val() == "") {
                    empty = true;
                }
            });
            if (empty) {
                $('#addForm input[type="submit"]').prop("disabled", true);
            } else {
                $('#addForm input[type="submit"]').prop("disabled", false);
            }
        });

        // Set Alert Timeout
        setTimeout(function() {
            $('.alert').alert('close');
        }, 7200);
    </script>

</body>

</html>