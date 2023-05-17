<?php
include('../config.php');

// Check session
require_once('include/session_check.php');

// Get active user
$id = $_SESSION['id'];
$stmt = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
$row = mysqli_fetch_assoc($stmt);

// Get record id to fetch data
$record_id = $_GET['record_id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title> Records per Quarter</title>

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
                <h3 class="fw-bolder">Quarterly Records</h3>
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

            <!-- Record Information -->
            <div class="w-auto px-4 py-2 mt-4">
                <?php

                $rec_stmt = "SELECT * FROM records WHERE id = '$record_id'";
                $rec_qry = mysqli_query($conn, $rec_stmt) or die(mysqli_error($conn));
                $rec_res = mysqli_fetch_assoc($rec_qry);
                ?>
                <div>
                    <h5>Year: <span class="fw-bold"><?= $rec_res['year']; ?></span></h5>
                </div>
                <div>
                    <h5>Total Graduates: <span class="fw-bold"><?= $rec_res['total_graduates']; ?></span></h5>
                </div>
            </div>
            <!-- End Record Information -->

            <!-- Table -->
            <div class="main-table">
                <div class="table-wrap shadow mx-2 my-4 p-4 rounded-2" role="region" aria-labelledby="Cap1" tabindex="0">
                    <!-- Table Controls -->
                    <div class="row">
                        <!-- Back to Records -->
                        <div class="col-sm sm:d-flex sm:justify-content-end">
                            <div class="d-inline-block">
                                <a href="records.php" class="btn btn-danger"><i class="fa-solid fa-chevron-left"></i> Return to Records</a>
                            </div>
                        </div>
                        <!-- End Back to Records -->

                        <!-- Button -->
                        <div class="col-sm d-flex justify-content-end">
                            <div class="d-inline-block">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addQuarter<?= $record_id; ?>"><i class="fa fa-circle-plus"></i> Add Record</button>
                                <?php include('modals/quarterly_modal.php'); ?>
                            </div>
                        </div>
                        <!-- End Button -->

                    </div>
                    <!-- End Table Controls -->

                    <!-- Modal Container -->
                    <div class="modal-container"></div>
                    <!-- End Modal Container -->

                    <table id="data_table" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Quarter</th>
                                <th>Employed</th>
                                <th>Percentage</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="show_quarter">
                            <?php

                            // Write a MySQL query to retrieve the records for the current page
                            $sql = "SELECT * FROM quarterlies WHERE record_id = '$record_id' ORDER BY quarter ASC";
                            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                            if ($count = mysqli_num_rows($result) == 0) {
                            ?>
                                <tr>
                                    <td colspan="4" class="text-center">
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
                                        <td><?= $row['quarter']; ?></td>
                                        <td><?= $row['employed']; ?></td>
                                        <td><?= $row['percentage']; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#removeQuarter<?= $id; ?>"><i class="fa fa-trash"></i> Remove</button>
                                        </td>
                                        <?php include('modals/quarterly_modal.php'); ?>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>

                </div>
            </div>
            <!-- End Table -->

        </div>
    </main>
    <!-- End Main Slot -->

    <!-- JS Include -->
    <?php include('include/footer.php'); ?>

    <!-- Live Search -->
    <script>
        $(document).ready(function() {

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