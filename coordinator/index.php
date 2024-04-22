<?php
require_once('../config.php');

// Check session
require_once('include/session_check.php');

// Get active user
$id = $_SESSION['id'];
$stmt = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
$row = mysqli_fetch_assoc($stmt);

$user_branch = $row['branch_id'];

// Count data
$pending_stmt = "SELECT COUNT(*) as pending_count FROM users WHERE status = 'pending' AND role = 'coordinator'";
$pending_qry = mysqli_query($conn, $pending_stmt);
$pending_res = mysqli_fetch_assoc($pending_qry);

$active_stmt = "SELECT COUNT(*) as users_count FROM users WHERE status = 'active'";
$active_qry = mysqli_query($conn, $active_stmt);
$active_res = mysqli_fetch_assoc($active_qry);

$branch_stmt = "SELECT COUNT(*) as branches_count FROM branches";
$branch_qry = mysqli_query($conn, $branch_stmt);
$branch_res = mysqli_fetch_assoc($branch_qry);

// Get latest update
$user_latest_stmt = "SELECT * FROM users ORDER BY updated_at DESC LIMIT 1";
$user_latest_qry = mysqli_query($conn, $user_latest_stmt);
$user_latest_res = mysqli_fetch_assoc($user_latest_qry);
$user_latest_date = strtotime($user_latest_res['updated_at']);

$pending_latest_stmt = "SELECT * FROM users WHERE status = 'pending' ORDER BY updated_at DESC LIMIT 1";
$pending_latest_qry = mysqli_query($conn, $pending_latest_stmt);
$pending_latest_res = mysqli_fetch_assoc($pending_latest_qry);

$pending_latest_date = '';

if (mysqli_num_rows($pending_latest_qry) == 0) {
    $pending_latest_date = $user_latest_date;
} else {
    $pending_latest_date = strtotime($pending_latest_res['updated_at']);
}

$branch_latest_stmt = "SELECT * FROM branches ORDER BY updated_at DESC LIMIT 1";
$branch_latest_qry = mysqli_query($conn, $branch_latest_stmt);
$branch_latest_res = mysqli_fetch_assoc($branch_latest_qry);
$branch_latest_date = strtotime($branch_latest_res['updated_at']);

$record_latest_stmt = "SELECT * FROM records ORDER BY updated_at DESC LIMIT 1";
$record_latest_qry = mysqli_query($conn, $record_latest_stmt);
$record_latest_res = mysqli_fetch_assoc($record_latest_qry);
$record_latest_date = strtotime($record_latest_res['updated_at']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard - Coordinator</title>

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
                <h3 class="fw-bolder">Overview</h3>
            </div>
            <!-- End Page Header -->

            <!-- Div Starter -->
            <div class="w-auto bg-custom-darkgreen px-4 py-2">
                <div class="d-flex justify-content-between">
                    <span class="text-light fw-bold">
                        Today: <?= date_format($current_date_time, 'F j, Y (l)'); ?>
                    </span>
                    <span class="text-light fw-bold" id="clock">
                    </span>
                </div>
            </div>
            <!-- End Div Starter -->

            <!-- Main Dashboard -->
            <div class="container py-4 h-100">
                <div class="row justify-content-center align-items-center">
                    <div class="col-12 col-md-4 py-2">
                        <div class="card ">
                            <div class="card-header bg-custom-lightorange text-white">
                                Featured
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">All Active Users</h5>
                                <p class="card-text text-center px-4 py-2 fw-bolder ">
                                    <span class="rounded-circle bg-custom-darkgreen px-3 py-2 text-light"><?= $active_res['users_count']; ?></span>
                                </p>
                            </div>
                            <div class="card-footer text-light bg-custom-lightorange">
                                Last update: <?= date('F j, Y (D)', $user_latest_date); ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 py-2">
                        <div class="card ">
                            <div class="card-header bg-custom-lightorange text-white">
                                Featured
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Pending Coordinator Accounts</h5>
                                <p class="card-text text-center px-4 py-2 fw-bolder ">
                                    <span class="rounded-circle bg-custom-darkgreen px-3 py-2 text-light"><?= $pending_res['pending_count']; ?></span>
                                </p>
                            </div>
                            <div class="card-footer text-light bg-custom-lightorange">
                                Last update: <?= date('F j, Y (D)', $pending_latest_date); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 py-2">
                        <div class="card ">
                            <div class="card-header bg-custom-lightorange text-white">
                                Featured
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Branches</h5>
                                <p class="card-text text-center px-4 py-2 fw-bolder ">
                                    <span class="rounded-circle bg-custom-darkgreen px-3 py-2 text-light"><?= $branch_res['branches_count']; ?></span>
                                </p>
                            </div>
                            <div class="card-footer text-light bg-custom-lightorange">
                                Last update: <?= date('F j, Y (D)', $branch_latest_date); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center py-3">
                    <div class="col-12 col-md-8">
                        <div class="card ">
                            <div class="card-header bg-custom-darkgreen text-white">
                                Employment Reports:
                            </div>
                            <div class="card-body">
                                <canvas id="myChart"></canvas> <!-- Canvas element for the chart -->
                            </div>
                            <div class="card-footer text-light bg-custom-darkgreen">
                                Last update: <?= date('F j, Y (D)', $record_latest_date); ?>

                            </div>
                        </div>
                    </div>


                    <div class="col-12 col-md-4">
                        <div class="card ">
                            <div class="card-header bg-custom-darkgreen text-white">
                                News/Announcements:
                            </div>
                            <div class="card-body">
                                <canvas id="myChart"></canvas> <!-- Canvas element for the chart -->
                            </div>
                            <div class="card-footer text-light bg-custom-darkgreen">
                                <a href="announcements.php" class="text-light">See all announcements <i class="fas fa-angle-double-right"></i></a>
                            </div>
                            <!-- End Main Dashboard -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End Main Slot -->

    <?php
    // Query to retrieve data
    $sql = "SELECT rec.*, br.branch_name FROM records AS rec INNER JOIN branches AS br ON rec.branch_id = br.id WHERE rec.branch_id = $user_branch";

    // Execute the query
    $result = $conn->query($sql);

    // Array to store the data
    $data = array();

    // Loop through the result and add data to the array
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    ?>

    <!-- JS Include -->
    <?php include('include/footer.php'); ?>
    <script>
        // Retrieve the PHP data and convert it to a JavaScript array
        var data = <?php echo json_encode($data); ?>;

        // Extract the year, total_employed, and total_percentage values from the data
        var branch_years = [];
        var graduates = [];
        var employed = [];
        var percentages = [];

        data.forEach(function(item) {
            branch_years.push(item.branch_name + ': ' + item.year);
            graduates.push(item.total_graduates);
            employed.push(item.total_employed);
            percentages.push(item.total_percentage);
        });

        // Create the chart using Chart.js
        var ctx = document.getElementById('myChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar', // Choose the chart type (e.g., bar, line, pie)
            data: {
                labels: branch_years, // Set the labels (x-axis values)
                datasets: [{
                        label: 'Graduates', // Set the dataset label
                        data: graduates, // Set the dataset values
                        backgroundColor: 'rgba(75, 192, 192, 0.2)', // Set the color
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1 // Set the border width
                    },
                    {
                        label: 'Employed Graduates', // Set the dataset label
                        data: employed, // Set the dataset values
                        backgroundColor: 'rgba(192, 75, 75, 0.2)', // Set the color
                        borderColor: 'rgba(192, 75, 75, 1)',
                        borderWidth: 1 // Set the border width
                    },
                    {
                        label: 'Percentage', // Set the dataset label
                        data: percentages, // Set the dataset values
                        backgroundColor: 'rgba(95, 75, 75, 0.2)', // Set the color
                        borderColor: 'rgba(92, 75, 75, 1)',
                        borderWidth: 1 // Set the border width
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true // Start the y-axis at zero
                    }
                },
            }
        });
    </script>
</body>

</html>