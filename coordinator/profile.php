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

    <title>Profile</title>

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
                <h3 class="fw-bolder">Profile: <?= $row['first_name']; ?></h3>
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

                <div class="container py-5 h-100">
                    <div class="row justify-content-center align-items-center h-100">
                        <div class="col-12 col-lg-10 col-xl-12">
                            <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                <div class="card-body p-4 p-md-5">
                                    <form method="POST" action="actions/actions.php">

                                        <div class="row">
                                            <div class="col-12 mb-1">

                                                <div class="form-outline">
                                                    <input type="hidden" id="user_id" name="user_id" class="form-control" value="<?= $row['id']; ?>" required />
                                                    <input type="number" id="employee_id" name="employee_id" class="form-control" value="<?= $row['employee_id']; ?>" required />
                                                    <label class="form-label" for="employee_id">Employeed ID</label>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 mb-1">

                                                <div class="form-outline">
                                                    <input type="text" id="firstname" name="firstname" class="form-control" value="<?= $row['first_name']; ?>" required />
                                                    <label class="form-label" for="firstname">First Name</label>
                                                </div>

                                            </div>
                                            <div class="col-md-4 mb-1">
                                                <div class="form-outline">
                                                    <input type="text" id="middlename" name="middlename" class="form-control" value="<?= $row['middle_name']; ?>" />
                                                    <label class="form-label" for="middlename">Middle Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-1">
                                                <div class="form-outline">
                                                    <input type="text" id="lastname" name="lastname" class="form-control" value="<?= $row['last_name']; ?>" required />
                                                    <label class="form-label" for="lastname">Last Name</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-1">

                                                <div class="form-outline">
                                                    <input type="email" id="email" name="email" class="form-control" value="<?= $row['email']; ?>" required />
                                                    <label class="form-label" for="email">Email</label>
                                                </div>

                                            </div>
                                            <div class="col-md-6 mb-1">

                                                <div class="form-outline">
                                                    <input type="tel" id="phonenumber" name="phonenumber" placeholder="63-912-345-6789" pattern="[6]{1}[3]{1}[0-9]{10}" class=" form-control" value="<?= $row['phone_number']; ?>" required />
                                                    <label class="form-label" for="phonenumber">Phone Number</label>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-1">

                                                <div class="form-outline">
                                                    <input type="password" id="password" name="password" class="form-control" />
                                                    <label class="form-label" for="password">Password</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-1">

                                                <div class="form-outline">
                                                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" />
                                                    <label class="form-label" for="confirm_password">Confirm Password</label>
                                                    <span id='message'></span>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="mt-4 pt-2">
                                            <a href="index.php" class="btn btn-danger"> Go Back</a>
                                            <input class="btn btn-primary" type="submit" value="Update" name="update_profile" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>
    <!-- End Main Slot -->

    <!-- JS Include -->
    <?php include('include/footer.php'); ?>

    <!-- Live Search -->
    <script>
        $(document).ready(function() {

            // check password length and confirmation
            $('#password, #confirm_password').on('keyup', function() {

                if ($('#password').val().length == "" && $('#confirm_password').val().length == "") {
                    $('form input[type="submit"]').prop('disabled', false);
                    $('#message').hide(); // Hide the message element
                    return;
                }
                if ($('#password').val().length >= 8 && $('#confirm_password').val().length >= 8) {
                    if ($('#password').val() == $('#confirm_password').val()) {
                        $('#message').html('Passwords match.').css('color', 'green');
                        $('form input[type="submit"]').prop('disabled', false);
                    } else {
                        $('#message').html('Passwords do not match.').css('color', 'red');
                        $('form input[type="submit"]').prop('disabled', true);
                    }
                } else {
                    $('#message').html('Password must be at least 8 characters long.').css('color', 'red');
                    $('form input[type="submit"]').prop('disabled', true);
                }
            });

            // Set Alert Timeout
            setTimeout(function() {
                $('.alert').alert('close');
            }, 7200);
        });
    </script>

</body>

</html>