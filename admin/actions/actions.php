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
