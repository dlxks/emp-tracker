<?php
require_once('../config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Employment Tracker</title>

    <!-- Header Imports -->
    <?php
    require_once('../include/header.php');
    ?>
</head>

<body>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-10 col-xl-12">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Registration Form</h3>

                            <!-- Alert Banner -->
                            <?php if (isset($_COOKIE['err_message'])) {
                            ?>
                                <div class="alert <?= $_COOKIE['message_class']; ?> alert-dismissible fade show" role="alert">
                                    <?= htmlspecialchars($_COOKIE['err_message']); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    </button>
                                </div>
                            <?php
                            }
                            ?>
                            <!-- End Alert Banner -->

                            <form method="POST" action="actions.php">

                                <div class="row">
                                    <div class="col-12 mb-4">

                                        <select class="select form-control form-control-lg" name="branch" required>
                                            <option value="0" disabled>Choose branch</option>
                                            <?php
                                            $stmt = "SELECT * FROM branches WHERE id != 1";
                                            $qry = mysqli_query($conn, $stmt) or die(mysqli_error($conn));


                                            while ($row = mysqli_fetch_assoc($qry)) {
                                            ?>
                                                <option value=<?= $row['id'] ?>><?= $row['branch_name'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <label class="form-label select-label">Select Branch</label>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 mb-4">

                                        <div class="form-outline">
                                            <input type="number" id="employee_id" name="employee_id" class="form-control form-control-lg" value="<?php if (isset($_POST['employee_id'])) echo $_POST['employee_id']; ?>" required />
                                            <label class="form-label" for="employee_id">Employeed ID</label>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-4">

                                        <div class="form-outline">
                                            <input type="text" id="firstname" name="firstname" class="form-control form-control-lg" value="<?php if (isset($_POST['firstname'])) echo $_POST['firstname']; ?>" required />
                                            <label class="form-label" for="firstname">First Name</label>
                                        </div>

                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <div class="form-outline">
                                            <input type="text" id="middlename" name="middlename" class="form-control form-control-lg" value="<?php if (isset($_POST['middlename'])) echo $_POST['middlename']; ?>" />
                                            <label class="form-label" for="middlename">Middle Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <div class="form-outline">
                                            <input type="text" id="lastname" name="lastname" class="form-control form-control-lg" value="<?php if (isset($_POST['lastname'])) echo $_POST['lastname']; ?>" required />
                                            <label class="form-label" for="lastname">Last Name</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">

                                        <div class="form-outline">
                                            <input type="email" id="email" name="email" class="form-control form-control-lg" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" required />
                                            <label class="form-label" for="email">Email</label>
                                        </div>

                                    </div>
                                    <div class="col-md-6 mb-4">

                                        <div class="form-outline">
                                            <input type="tel" id="phonenumber" name="phonenumber" placeholder="63-912-345-6789" pattern="[6]{1}[3]{1}[0-9]{10}" class=" form-control form-control-lg" value="<?php if (isset($_POST['phonenumber'])) echo $_POST['phonenumber']; ?>" required />
                                            <label class="form-label" for="phonenumber">Phone Number</label>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">

                                        <div class="form-outline">
                                            <input type="password" id="password" name="password" class="form-control form-control-lg" required />
                                            <label class="form-label" for="password">Password</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">

                                        <div class="form-outline">
                                            <input type="password" id="confirm_password" name="confirm_password" class="form-control form-control-lg" required />
                                            <label class="form-label" for="confirm_password">Confirm Password</label>
                                            <span id='message'></span>
                                        </div>

                                    </div>
                                </div>

                                <div class="mt-4 pt-2">
                                    <a href="index.php" class="btn btn-danger btn-lg"> Go Back</a>
                                    <input class="btn btn-primary btn-lg" type="submit" value="Submit" name="register" />
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Imports -->
    <?php require_once('../include/footer.php') ?>

    <script>
        $(document).ready(function() {
            // disable submit button until all required fields are filled
            $('form input[type="submit"]').prop('disabled', true);
            $('form input[required]').keyup(function() {
                var empty = false;
                $('form input[required]').each(function() {
                    if ($(this).val() == '') {
                        empty = true;
                    }
                });
                if (empty) {
                    $('form input[type="submit"]').prop('disabled', true);
                } else {
                    $('form input[type="submit"]').prop('disabled', false);
                }
            });

            // check password length and confirmation
            $('#password, #confirm_password').on('keyup', function() {
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
        });
    </script>
</body>

</html>