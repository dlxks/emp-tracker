<?php
ob_start();
// session_start();
require_once('../config.php');

// User Registration
if (isset($_POST['register'])) {

    // Data from POST
    $branch = mysqli_real_escape_string($conn, $_POST['branch']);
    $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $middlename = mysqli_real_escape_string($conn, $_POST['middlename']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phonenumber = mysqli_real_escape_string($conn, $_POST['phonenumber']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Static Data
    $role = "coordinator";
    $status = "pending";

    // Check if user exists
    $chk_stmt = mysqli_query($conn, "SELECT * FROM users WHERE employee_id = $employee_id");
    $chk_result = mysqli_fetch_assoc($chk_stmt);

    // Check if email exists
    $chk_email_stmt = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' OR employee_id = $employee_id");
    $chk_email_res = mysqli_fetch_assoc($chk_email_stmt);

    if (mysqli_num_rows($chk_stmt) > 0) {
        // Check if pending
        if ($chk_result['status'] == 'pending') {

            $message = "You already have a pending account request. Please wait for approval.";
            header("location: register.php?err_message=" . $message);
        }
        // Check if denied
        elseif ($chk_result['status'] == 'denied') {

            $message = "Your account has been denied of access. Please contact administrator to fix this issue.";
            header("location: register.php?err_message=" . $message);
        }
        // Check if account is active
        elseif ($chk_result['status'] == 'active') {

            $message = "You already have an account. Please continue to Login";
            header("location: register.php?err_message=" . $message);
        }
    } elseif (mysqli_num_rows($chk_email_stmt) > 0) {
        // Check if Employee ID or Email exists
        $message = "The E-mail or Employee ID you entered already belongs to another account.";
        header("location: register.php?err_message=" . $message);
    } else {
        // If no error
        $stmt = "INSERT INTO users (branch_id, employee_id, first_name, middle_name, last_name, email, phone_number, password, role, status) VALUES ('$branch', '$employee_id', '$firstname', '$middlename', '$lastname', '$email', '$phonenumber', '$password', '$role', '$status')";
        $qry = mysqli_query($conn, $stmt) or die(mysqli_error($conn));

        $message = "Account has been created. Please wait for the approval.";
        header("location: index.php?message=" . $message);
    }
}
