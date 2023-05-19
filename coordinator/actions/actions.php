<?php
ob_start();

require_once('../../config.php');

// Get the current date and time in the Philippine timezone
$current_date = date('Y-m-d H:i:s');

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

// ***************Remove Record****************
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
            $message = "Profile updated.";
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

    if ($data_from == "records") { //exporting records
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
        while ($row1 = mysqli_fetch_assoc($result1)) {
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
        while ($row2 = mysqli_fetch_assoc($result2)) {
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
