<?php
ob_start();
// session_start();
require_once('../config.php');

// Get the current date and time in the Philippine timezone
$current_date = date('Y-m-d H:i:s');

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

    // Secure password
    $hash_password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password using the default algorithm


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
            setcookie('err_message', $message, time() + 300, '/');
            setcookie('message_class', 'text-warning', time() + 300, '/');
            header("location: register.php");
            exit();
        }
        // Check if denied
        elseif ($chk_result['status'] == 'denied') {

            $message = "Your account has been denied of access. Please contact administrator to fix this issue.";
            setcookie('err_message', $message, time() + 300, '/');
            setcookie('message_class', 'text-danger', time() + 300, '/');
            header("location: register.php");
            exit();
        }
        // Check if account is active
        elseif ($chk_result['status'] == 'active') {

            $message = "You already have an account. Please continue to Login";
            setcookie('err_message', $message, time() + 300, '/');
            setcookie('message_class', 'text-warning', time() + 300, '/');
            header("location: register.php");
            exit();
        }
    } elseif (mysqli_num_rows($chk_email_stmt) > 0) {
        // Check if Employee ID or Email exists
        $message = "The E-mail or Employee ID you entered already belongs to another account.";
        setcookie('err_message', $message, time() + 300, '/');
        setcookie('message_class', 'text-danger', time() + 300, '/');
        exit();
    } else {

        // If no error
        $stmt = "INSERT INTO users (branch_id, employee_id, first_name, middle_name, last_name, email, phone_number, password, role, status, created_at, updated_at) VALUES ('$branch', '$employee_id', '$firstname', '$middlename', '$lastname', '$email', '$phonenumber', '$hash_password', '$role', '$status', '$current_date', '$current_date')";
        $qry = mysqli_query($conn, $stmt) or die(mysqli_error($conn));

        $message = "Account has been created. Please wait for the approval.";
        setcookie('message', $message, time() + 300, '/');
        setcookie('message_class', 'text-success', time() + 300, '/');
        header("location: index.php");
        exit();
    }
}


// User Login
if (isset($_POST['login'])) {

    // Data from POST
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $remember = mysqli_real_escape_string($conn, $_POST['remember']);

    // Query the database for the user's credentials
    $stmt = "SELECT * FROM users WHERE email='$email'";
    $res = mysqli_query($conn, $stmt) or die(mysqli_error($conn));

    // If the user is found and the password is correct
    if (mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);

        // Check if account is pending
        if ($row['status'] == "pending") {

            $message = "Account is still pending for approval. Please wait.";
            setcookie('message', $message, time() + 300, '/');
            header("location: index.php");
            exit();
        } elseif ($row['status'] == "denied") { // Check if account is denied

            $message = "Account is still pending for approval. Please wait.";
            setcookie('message', $message, time() + 300, '/');
            header("location: index.php");
            exit();
        } elseif ($row['status'] == "active") { // Check if account is active

            $verify = password_verify($password, $row["password"]);

            if ($verify) {

                //For generating session ID == student_id
                session_regenerate_id();
                $_SESSION["email"] = $row["email"];
                $_SESSION["id"] = $row["id"];

                // Set the remember token if the user selected the "remember me" option
                if (isset($_POST["remember"])) {
                    $token = bin2hex(random_bytes(16)); // Generate a random 32-character hexadecimal string
                    $expire = time() + (60 * 60 * 2); // Set the expiration time to 2 hours from now
                    setcookie("remember_token", $token, $expire, "/", "", true, true); // Set the cookie with HTTP-only and secure flags
                    $query = "UPDATE users SET remember_token='$token', remember_token_expire='$expire' WHERE id={$row['id']}";
                    mysqli_query($conn, $query);
                }

                session_write_close();

                // Redirect to home page
                header("Location: ../admin/dashboard.php");
                exit();
            } else {

                $message = "The password you entered is incorrect. Please try again.";
                setcookie('message', $message, time() + 300, '/');
                setcookie('message_class', 'text-danger', time() + 300, '/');
                header("location: index.php");
                exit();
            }
        }
    }

    // If the login failed, show an error message
    $error_msg = "Invalid username or password";
}
