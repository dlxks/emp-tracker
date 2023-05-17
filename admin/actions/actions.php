<?php
ob_start();

require_once('../../config.php');

// Get the current date and time in the Philippine timezone
$current_date = date('Y-m-d H:i:s');

// ***************Add Branch****************
if (isset($_POST['add_branch'])) {
    // Data
    $branch_name = mysqli_real_escape_string($conn, $_POST['branch_name']);
    $branch_desc = mysqli_real_escape_string($conn, $_POST['branch_desc']);

    $chk_stmt = "SELECT * FROM branches WHERE branch_name = '$branch_name'";
    $chk_qry = mysqli_query($conn, $chk_stmt) or die(mysqli_error($conn));
    $chk_res = mysqli_num_rows($chk_qry);

    // Check if branch name exists
    if ($chk_res > 0) {
        $message = "Branch name " . $branch_name . " already exists. Please make a new one.";
        setcookie('data_err_message', $message, time() + 15, '/');
        setcookie('data_message_class', 'alert-danger', time() + 15, '/');
        header("location: ../branches.php");
        exit();
    } else { //If branch name does not exist.

        $stmt = "INSERT INTO branches (branch_name, branch_desc, created_at, updated_at) VALUES ('$branch_name', '$branch_desc', '$current_date', '$current_date')";
        $qry = mysqli_query($conn, $stmt) or die(mysqli_error($conn));

        // If adding failed
        if (!$qry) {
            $message = "Branch is not added. Please check the details you entered.";
            setcookie('data_err_message', $message, time() + 15, '/');
            setcookie('data_message_class', 'alert-danger', time() + 15, '/');
            header("location: ../branches.php");
            exit();
        } else { // Adding branch success
            $message = "New branch added.";
            setcookie('data_err_message', $message, time() + 15, '/');
            setcookie('data_message_class', 'alert-success', time() + 15, '/');
            header("location: ../branches.php");
            exit();
        }
    }
}

// ***************Update Branch****************
if (isset($_POST['update_branch'])) {
    // Data
    $branch_id = mysqli_real_escape_string($conn, $_POST['branch_id']);
    $branch_name = mysqli_real_escape_string($conn, $_POST['branch_name']);
    $branch_desc = mysqli_real_escape_string($conn, $_POST['branch_desc']);

    $stmt = "UPDATE branches SET branch_name = '$branch_name', branch_desc = '$branch_desc', updated_at = '$current_date' WHERE id = '$branch_id'";
    $qry = mysqli_query($conn, $stmt) or die(mysqli_error($conn));

    // If adding failed
    if (!$qry) {
        $message = "Branch is not updated. Please check the details you entered.";
        setcookie('data_err_message', $message, time() + 15, '/');
        setcookie('data_message_class', 'alert-danger', time() + 15, '/');
        header("location: ../branches.php");
        exit();
    } else { // Adding branch success
        $message = "Branch updated.";
        setcookie('data_err_message', $message, time() + 15, '/');
        setcookie('data_message_class', 'alert-success', time() + 15, '/');
        header("location: ../branches.php");
        exit();
    }
}

// ***************Remove Branch****************
if (isset($_POST['delete_branch'])) {
    // Data
    $branch_id = mysqli_real_escape_string($conn, $_POST['branch_id']);

    $stmt = "DELETE FROM branches WHERE id = '$branch_id'";
    $qry = mysqli_query($conn, $stmt) or die(mysqli_error($conn));

    // If adding failed
    if (!$qry) {
        $message = "Branch is not removed.";
        setcookie('data_err_message', $message, time() + 15, '/');
        setcookie('data_message_class', 'alert-danger', time() + 15, '/');
        header("location: ../branches.php");
        exit();
    } else { // Adding branch success
        $message = "Branch removed.";
        setcookie('data_err_message', $message, time() + 15, '/');
        setcookie('data_message_class', 'alert-success', time() + 15, '/');
        header("location: ../branches.php");
        exit();
    }
}


// ***************Add User****************
if (isset($_POST['add_user'])) {

    // Data from POST
    $branch = mysqli_real_escape_string($conn, $_POST['branch_id']);
    $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $middlename = mysqli_real_escape_string($conn, $_POST['middlename']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phonenumber = mysqli_real_escape_string($conn, $_POST['phonenumber']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Static Data
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
            setcookie('data_err_message', $message, time() + 15, '/');

            // Redirect based on role
            if ($role == "admin") {
                header("location: ../administrators.php");
                exit();
            } elseif ($role == "coordinator") {
                header("location: ../coordinators.php");
                exit();
            }
        }
        // Check if denied
        elseif ($chk_result['status'] == 'denied') {

            $message = "Your account has been denied of access. Please contact administrator to fix this issue.";
            setcookie('data_err_message', $message, time() + 15, '/');
            setcookie('data_message_class', 'alert-danger', time() + 15, '/');

            // Redirect based on role
            if ($role == "admin") {
                header("location: ../administrators.php");
                exit();
            } elseif ($role == "coordinator") {
                header("location: ../coordinators.php");
                exit();
            }
        }
        // Check if account is active
        elseif ($chk_result['status'] == 'active') {

            $message = "You already have an account. Please continue to Login";
            setcookie('data_err_message', $message, time() + 15, '/');
            setcookie('data_message_class', 'alert-warning', time() + 15, '/');

            // Redirect based on role
            if ($role == "admin") {
                header("location: ../administrators.php");
                exit();
            } elseif ($role == "coordinator") {
                header("location: ../coordinators.php");
                exit();
            }
        }
    } elseif (mysqli_num_rows($chk_email_stmt) > 0) {
        // Check if Employee ID or Email exists
        $message = "The E-mail or Employee ID you entered already belongs to another account.";
        setcookie('data_err_message', $message, time() + 15, '/');
        setcookie('data_message_class', 'alert-danger', time() + 15, '/');

        // Redirect based on role
        if ($role == "admin") {
            header("location: ../administrators.php");
            exit();
        } elseif ($role == "coordinator") {
            header("location: ../coordinators.php");
            exit();
        }
    } else {

        // Secure password
        $hash_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password using the default algorithm

        // If no error
        $stmt = "INSERT INTO users (branch_id, employee_id, first_name, middle_name, last_name, email, phone_number, password, role, status, created_at, updated_at) VALUES ('$branch', '$employee_id', '$firstname', '$middlename', '$lastname', '$email', '$phonenumber', '$hash_password', '$role', '$status', '$current_date', '$current_date')";
        $qry = mysqli_query($conn, $stmt) or die(mysqli_error($conn));

        $message = "Account has been created. Please wait for the approval.";
        setcookie('data_err_message', $message, time() + 15, '/');
        setcookie('data_message_class', 'alert-success', time() + 15, '/');

        // Redirect based on role
        if ($role == "admin") {
            header("location: ../administrators.php");
            exit();
        } elseif ($role == "coordinator") {
            header("location: ../coordinators.php");
            exit();
        }
    }
}

// ***************Update User****************
if (isset($_POST['update_user'])) {
    // Data from POST
    $user_id = mysqli_real_escape_string($conn, $_POST['e_id']);
    $branch = mysqli_real_escape_string($conn, $_POST['e_branch_id']);
    $employee_id = mysqli_real_escape_string($conn, $_POST['e_employee_id']);
    $role = mysqli_real_escape_string($conn, $_POST['e_role']);
    $firstname = mysqli_real_escape_string($conn, $_POST['e_firstname']);
    $middlename = mysqli_real_escape_string($conn, $_POST['e_middlename']);
    $lastname = mysqli_real_escape_string($conn, $_POST['e_lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['e_email']);
    $phonenumber = mysqli_real_escape_string($conn, $_POST['e_phonenumber']);
    $status = mysqli_real_escape_string($conn, $_POST['e_status']);

    $stmt = "UPDATE users SET branch_id = '$branch', employee_id = '$employee_id', first_name = '$firstname', middle_name = '$middlename', last_name = '$lastname', email = '$email', phone_number = '$phonenumber', role = '$role', status = '$status', updated_at = '$current_date' WHERE id = '$user_id'";
    $qry = mysqli_query($conn, $stmt) or die(mysqli_error($conn));

    // If updateing failed
    if (!$qry) {
        $message = "User is not updated. Please check the details you entered.";
        setcookie('data_err_message', $message, time() + 15, '/');
        setcookie('data_message_class', 'alert-danger', time() + 15, '/');

        // Redirect based on role
        if ($role == "admin") {
            header("location: ../administrators.php");
            exit();
        } elseif ($role == "coordinator") {
            header("location: ../coordinators.php");
            exit();
        }
    } else { // Updating user success
        $message = "User updated.";
        setcookie('data_err_message', $message, time() + 15, '/');
        setcookie('data_message_class', 'alert-success', time() + 15, '/');

        // Redirect based on role
        if ($role == "admin") {
            header("location: ../administrators.php");
            exit();
        } elseif ($role == "coordinator") {
            header("location: ../coordinators.php");
            exit();
        }
    }
}

// ***************Reset User Password****************
if (isset($_POST['user_reset_password'])) {
    // Data from POST
    $user_id = mysqli_real_escape_string($conn, $_POST['e_id']);
    $employee_id = mysqli_real_escape_string($conn, $_POST['e_employee_id']);
    $lastname = mysqli_real_escape_string($conn, $_POST['e_lastname']);
    $role = mysqli_real_escape_string($conn, $_POST['e_role']);

    // Concat password
    $password = $employee_id . $lastname;
    echo $password;

    // Secure password
    $hash_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password using the default algorithm

    $stmt = "UPDATE users SET password = '$hash_password', remember_token = NULL, remember_token_expire = NULL, updated_at = '$current_date' WHERE id = '$user_id'";
    $qry = mysqli_query($conn, $stmt) or die(mysqli_error($conn));

    // If reset failed
    if (!$qry) {
        $message = "Unable to reset password.";
        setcookie('data_err_message', $message, time() + 15, '/');
        setcookie('data_message_class', 'alert-danger', time() + 15, '/');

        // Redirect based on role
        if ($role == "admin") {
            header("location: ../administrators.php");
            exit();
        } elseif ($role == "coordinator") {
            header("location: ../coordinators.php");
            exit();
        }
    } else { // User reset
        $message = "Password for " . $employee_id . " has been reset.";
        setcookie('data_err_message', $message, time() + 15, '/');
        setcookie('data_message_class', 'alert-success', time() + 15, '/');

        // Redirect based on role
        if ($role == "admin") {
            header("location: ../administrators.php");
            exit();
        } elseif ($role == "coordinator") {
            header("location: ../coordinators.php");
            exit();
        }
    }
}

// ***************Remove User****************
if (isset($_POST['delete_user'])) {
    // Data from POST
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $role = mysqli_real_escape_string($conn, $_POST['user_role']);

    $stmt = "DELETE FROM users WHERE id = '$user_id'";
    $qry = mysqli_query($conn, $stmt) or die(mysqli_error($conn));

    // If adding failed
    if (!$qry) {
        $message = "User is not removed.";
        setcookie('data_err_message', $message, time() + 15, '/');
        setcookie('data_message_class', 'alert-danger', time() + 15, '/');

        // Redirect based on role
        if ($role == "admin") {
            header("location: ../administrators.php");
            exit();
        } elseif ($role == "coordinator") {
            header("location: ../coordinators.php");
            exit();
        }
        exit();
    } else { // Adding user success
        $message = "User has been removed.";
        setcookie('data_err_message', $message, time() + 15, '/');
        setcookie('data_message_class', 'alert-success', time() + 15, '/');

        // Redirect based on role
        if ($role == "admin") {
            header("location: ../administrators.php");
            exit();
        } elseif ($role == "coordinator") {
            header("location: ../coordinators.php");
            exit();
        }
    }
}

// ***************Add Record****************
if (isset($_POST['add_record'])) {
    // Data
    $branch_id = mysqli_real_escape_string($conn, $_POST['branch_id']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);
    $graduates = mysqli_real_escape_string($conn, $_POST['graduates']);

    $chk_stmt = "SELECT * FROM records WHERE branch_id = '$branch_id' AND year = '$year'";
    $chk_qry = mysqli_query($conn, $chk_stmt) or die(mysqli_error($conn));
    $chk_res = mysqli_num_rows($chk_qry);

    // Check if record name exists
    if ($chk_res > 0) {
        $message = "Data already exists. Please make a new one.";
        setcookie('data_err_message', $message, time() + 15, '/');
        setcookie('data_message_class', 'alert-danger', time() + 15, '/');
        header("location: ../records.php");
        exit();
    } else { //If record name does not exist.

        $stmt = "INSERT INTO records (branch_id, year, total_graduates, created_at, updated_at) VALUES ('$branch_id', '$year', '$graduates', '$current_date', '$current_date')";
        $qry = mysqli_query($conn, $stmt) or die(mysqli_error($conn));

        // If adding failed
        if (!$qry) {
            $message = "Record is not added. Please check the details you entered.";
            setcookie('data_err_message', $message, time() + 15, '/');
            setcookie('data_message_class', 'alert-danger', time() + 15, '/');
            header("location: ../branches.php");
            exit();
        } else { // Adding record success
            $message = "New record added.";
            setcookie('data_err_message', $message, time() + 15, '/');
            setcookie('data_message_class', 'alert-success', time() + 15, '/');
            header("location: ../records.php");
            exit();
        }
    }
}

// ***************Remove User****************
if (isset($_POST['delete_record'])) {
    // Data from POST
    $record_id = mysqli_real_escape_string($conn, $_POST['record_id']);

    $qrtr_stmt = "DELETE FROM quarterlies WHERE record_id = '$record_id'";
    $qrtr_qry = mysqli_query($conn, $qrtr_stmt) or die(mysqli_error($conn));

    $stmt = "DELETE FROM records WHERE id = '$record_id'";
    $qry = mysqli_query($conn, $stmt) or die(mysqli_error($conn));

    // If adding failed
    if (!$qry) {
        $message = "Removing record failed.";
        setcookie('data_err_message', $message, time() + 15, '/');
        setcookie('data_message_class', 'alert-danger', time() + 15, '/');
        header("location: ../records.php");
        exit();
    } else { // Removing record success
        $message = "Record has been removed.";
        setcookie('data_err_message', $message, time() + 15, '/');
        setcookie('data_message_class', 'alert-success', time() + 15, '/');
        header("location: ../records.php");
        exit();
    }
}

// ***************Add Quarterly Recprd****************
if (isset($_POST['add_quarter'])) {
    // Fetch Data
    $record_id = mysqli_real_escape_string($conn, $_POST['record_id']);
    $quarter = mysqli_real_escape_string($conn, $_POST['quarter']);
    $no_of_employed = mysqli_real_escape_string($conn, $_POST['no_of_employed']);

    // Get record
    $rec_stmt = "SELECT * FROM records WHERE id = '$record_id'";
    $rec_qry = mysqli_query($conn, $rec_stmt) or die(mysqli_error($conn));
    $rec_res = mysqli_fetch_assoc($rec_qry);

    // Check existing data
    $chk_stmt = "SELECT * FROM quarterlies WHERE record_id = '$record_id' AND quarter = '$quarter'";
    $chk_qry = mysqli_query($conn, $chk_stmt) or die(mysqli_error($conn));
    $chk_res = mysqli_num_rows($chk_qry);

    // Check if record name exists
    if ($chk_res > 0) {
        $message = "Record already exists. Please add a new one.";
        setcookie('data_err_message', $message, time() + 15, '/');
        setcookie('data_message_class', 'alert-danger', time() + 15, '/');
        header("location: ../quarterly.php?record_id=$record_id");
        exit();
    } else { //If record does not exist.

        // Get all quarterly data
        $qr_stmt = "SELECT * FROM quarterlies WHERE record_id = '$record_id'";
        $qr_qry = mysqli_query($conn, $qr_stmt) or die(mysqli_error($conn));

        $total_employed = 0;
        while ($qr_res = mysqli_fetch_assoc($qr_qry)) {
            $total_employed += $qr_res['employed'];
        }

        $new_total_employed = $total_employed + $no_of_employed;
        $total_graduates = $rec_res['total_graduates'];

        // Check if data will exceed number of graduates
        if ($new_total_employed > $total_graduates) {
            $message = "Total employed exeeded total graduates. Adding new record failed";
            setcookie('data_err_message', $message, time() + 15, '/');
            setcookie('data_message_class', 'alert-danger', time() + 15, '/');
            header("location: ../quarterly.php?record_id=$record_id");
            exit();
        } else {
            // Compute for the percentage of graduate.
            $percentage = ($no_of_employed / $total_graduates) * 100;
            $total_percentage = ($new_total_employed / $total_graduates) * 100;

            // Get year
            $year = $rec_res['year'];

            $stmt = "INSERT INTO quarterlies (record_id, year, quarter, employed, percentage, created_at, updated_at) VALUES ('$record_id', '$year', '$quarter', '$no_of_employed', '$percentage', '$current_date', '$current_date')";
            $qry = mysqli_query($conn, $stmt) or die(mysqli_error($conn));

            $rec_update_stmt = "UPDATE records SET total_employed = '$new_total_employed', total_percentage = '$total_percentage' WHERE id = '$record_id'";
            $rec_update_qry = mysqli_query($conn, $rec_update_stmt) or die(mysqli_error($conn));

            // If adding failed
            if (!$qry || !$rec_update_qry) {
                $message = "Record is not added. Please check the details you entered.";
                setcookie('data_err_message', $message, time() + 15, '/');
                setcookie('data_message_class', 'alert-danger', time() + 15, '/');
                header("location: ../quarterly.php?record_id=$record_id");
                exit();
            } else { // Adding record success
                $message = "New record added.";
                setcookie('data_err_message', $message, time() + 15, '/');
                setcookie('data_message_class', 'alert-success', time() + 15, '/');
                header("location: ../quarterly.php?record_id=$record_id");
                exit();
            }
        }
    }
}

// ***************Delete Quarter Record****************
if (isset($_POST['delete_quarter'])) {
    // Data from POST
    $quarter_id = mysqli_real_escape_string($conn, $_POST['quarter_id']);

    // Get all quarterly data
    $rec_stmt = "SELECT * FROM quarterlies WHERE id = '$quarter_id'";
    $rec_qry = mysqli_query($conn, $rec_stmt) or die(mysqli_error($conn));
    $rec_res = mysqli_fetch_assoc($rec_qry);

    // Get record id for quarter
    $record_id = $rec_res['record_id'];

    // Delete quarter record
    $stmt = "DELETE FROM quarterlies WHERE id = '$quarter_id'";
    $qry = mysqli_query($conn, $stmt) or die(mysqli_error($conn));

    // // If removing failed
    if (!$qry) {
        $message = "Removing record failed.";
        setcookie('data_err_message', $message, time() + 15, '/');
        setcookie('data_message_class', 'alert-danger', time() + 15, '/');
        header("location: ../quarterly.php?record_id=$record_id");
        exit();
    } else { // Removing quarter success
        // Get all quarterly data
        $qrtr_stmt = "SELECT * FROM quarterlies WHERE record_id = '$record_id'";
        $qrtr_qry = mysqli_query($conn, $qrtr_stmt) or die(mysqli_error($conn));

        // Calculate new total employed 
        $total_employed = 0;
        while ($qrtr_res = mysqli_fetch_assoc($qrtr_qry)) {
            $total_employed += $qrtr_res['employed'];
        }

        // Get record data
        $rec_fetch_stmt = "SELECT * FROM records WHERE id = '$record_id'";
        $rec_fetch_qry = mysqli_query($conn, $rec_fetch_stmt) or die(mysqli_error($conn));
        $rec_fetch_res = mysqli_fetch_assoc($rec_fetch_qry);

        $total_graduates = $rec_fetch_res['total_graduates'];

        // Compute for the percentage of graduate.
        $total_percentage = ($total_employed / $total_graduates) * 100;

        $rec_update_stmt = "UPDATE records SET total_employed = '$total_employed', total_percentage = '$total_percentage' WHERE id = '$record_id'";
        $rec_update_qry = mysqli_query($conn, $rec_update_stmt) or die(mysqli_error($conn));

        // If adding failed
        if (!$qry || !$rec_update_qry) {
            $message = "Record is not removed";
            setcookie('data_err_message', $message, time() + 15, '/');
            setcookie('data_message_class', 'alert-danger', time() + 15, '/');
            header("location: ../quarterly.php?record_id=$record_id");
            exit();
        } else { // Adding record success
            $message = "Record has been removed.";
            setcookie('data_err_message', $message, time() + 15, '/');
            setcookie('data_message_class', 'alert-success', time() + 15, '/');
            header("location: ../quarterly.php?record_id=$record_id");
            exit();
        }
    }
}


// ***************Profile Update****************
if (isset($_POST['update_profile'])) {

    // Fetch data
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $middlename = mysqli_real_escape_string($conn, $_POST['middlename']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phonenumber = mysqli_real_escape_string($conn, $_POST['phonenumber']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Fetch data of the user
    $user_stmt = "SELECT * FROM users WHERE id = '$user_id'";
    $user_qry = mysqli_query($conn, $user_stmt) or die(mysqli_error($conn));
    $user_res = mysqli_fetch_assoc($user_qry);

    // if password is not changed
    if (empty($password) && empty($confirm_password)) {
        $stmt = "UPDATE users SET employee_id = '$employee_id', first_name = '$firstname', middle_name = '$middlename', last_name = '$lastname', email = '$email', phone_number = '$phonenumber', updated_at = '$current_date' WHERE id = '$user_id'";
        $qry = mysqli_query($conn, $stmt) or die(mysqli_error($conn));

        // If udpating failed
        if (!$qry) {
            $message = "Profile update failed.";
            setcookie('data_err_message', $message, time() + 15, '/');
            setcookie('data_message_class', 'alert-danger', time() + 15, '/');
            header("location: ../profile.php");
            exit();
        } else { // Profile record success
            $message = "Profile udpated.";
            setcookie('data_err_message', $message, time() + 15, '/');
            setcookie('data_message_class', 'alert-success', time() + 15, '/');
            header("location: ../profile.php");
            exit();
        }
    } else { //If password must be changed

        // Verify old password
        $old_password = password_verify($password, $user_res["password"]);
        // If same password
        if ($old_password) {
            $message = "The password you have entered is similar to your old password. Please create a new one.";
            setcookie('data_err_message', $message, time() + 15, '/');
            setcookie('data_message_class', 'alert-danger', time() + 15, '/');
            header("location: ../profile.php");
            exit();
        } else { // Profile record success
            // Secure new password
            $hash_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password using the default algorithm

            $new_pass_stmt = "UPDATE users SET employee_id = '$employee_id', first_name = '$firstname', middle_name = '$middlename', last_name = '$lastname', email = '$email', phone_number = '$phonenumber', password = '$hash_password', updated_at = '$current_date' WHERE id = '$user_id'";
            $new_pass_qry = mysqli_query($conn, $new_pass_stmt) or die(mysqli_error($conn));

            // If udpating failed
            if (!$new_pass_qry) {
                $message = "Profile update failed.";
                setcookie('data_err_message', $message, time() + 15, '/');
                setcookie('data_message_class', 'alert-danger', time() + 15, '/');
                header("location: ../profile.php");
                exit();
            } else { // Profile record success
                $message = "Profile udpated.";
                setcookie('data_err_message', $message, time() + 15, '/');
                setcookie('data_message_class', 'alert-success', time() + 15, '/');
                header("location: ../profile.php");
                exit();
            }
        }
    }
}


// ***************Data Export****************
if (isset($_POST['export_data'])) {
    $data_from = mysqli_real_escape_string($conn, $_POST['data_from']);

    if ($data_from == "branches") { //Exporting branches
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=branches.csv');
        $output = fopen("php://output", "w");
        fputcsv($output, array('Branch ID', 'Branch Name', 'Description'));
        $query = "SELECT id, branch_name, branch_desc FROM branches ORDER BY branch_name ASC";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            fputcsv($output, $row);
        }
        fclose($output);
    } elseif ($data_from == "users") { //exporting users
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=users.csv');
        $output = fopen("php://output", "w");
        fputcsv($output, array('Employeed ID', 'First Name', 'Middle Name', 'Last Name', 'Email', 'Phone Number', 'Role'));
        $query = "SELECT employee_id, first_name, middle_name, last_name, email, phone_number, role FROM users GROUP BY role ORDER BY employee_id  ASC";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            fputcsv($output, $row);
        }
        fclose($output);
    } elseif ($data_from == "records") { //exporting records
        // Retrieve data from the first table
        $sql1 = 'SELECT rec.*, br.id as br_id, br.branch_name FROM records AS rec INNER JOIN branches AS br ON rec.branch_id = br.id';
        $result1 = mysqli_query($conn, $sql1);

        // Create a new CSV file
        $filename = 'records.csv';
        $file = fopen($filename, 'w');

        // Set header row for the first table
        $header1 = ['Record ID', 'Branch', 'Year', 'Graduates', 'Employed', 'Employed Percentage'];
        fputcsv($file, $header1);

        // Set data rows for the first table
        while ($row1 = mysqli_fetch_assoc( $result1)) {
            $rowData1 = [$row1['id'], $row1['branch_name'], $row1['year'], $row1['total_graduates'], $row1['total_employed'], $row1['total_percentage']];
            fputcsv($file, $rowData1);
        }

        // Add an empty line to separate tables
        fputcsv($file, []);

        // Retrieve data from the second table
        $sql2 = 'SELECT * FROM quarterlies';
        $result2 = mysqli_query($conn, $sql2);

        // Set header row for the second table
        $header2 = ['Record ID', 'Year', 'Quarter', 'Employed', 'Employed Percentage'];
        fputcsv($file, $header2);

        // Set data rows for the second table
        while ($row2 = mysqli_fetch_assoc( $result2)) {
            $rowData2 = [$row2['record_id'], $row2['year'], $row2['quarter'], $row2['employed'], $row2['percentage']];
            fputcsv($file, $rowData2);
        }

        fclose($file);

        // Download the CSV file
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        readfile($filename);
    }
}
