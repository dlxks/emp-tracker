<?php
require_once('../config.php');

//verify session status
if (!isset($_SESSION['id'])) { //if no session..
    header("Location: ../login/index.php"); //redirect to authorizer login page
    exit; //end of instruction
}

// check if remember token is valid
if (isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
    $query = "SELECT * FROM users WHERE remember_token='$token'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $expiry_time = date($user['remember_token_expire']);

        if (time() > $expiry_time) {
            // token has expired, destroy session and remove token
            session_unset();
            session_destroy();
            $query = "UPDATE users SET remember_token = NULL, remember_token_expire = NULL WHERE id=" . $user['id'];
            mysqli_query($conn, $query);
            setcookie('remember_token', '', time() - (60 * 60 * 2), '/');
            header("Location: ../login/index.php"); //redirect to authorizer login page
            exit;
        }
        // refresh token expiration time
        $new_expiry_time = time() + 7200;
        $query = "UPDATE users SET remember_token_expire='" .  $new_expiry_time . "' WHERE id=" . $user['id'];
        mysqli_query($conn, $query);
        setcookie('remember_token', $token, $new_expiry_time, '/');
        $_SESSION['email'] = $user['email'];
        $_SESSION['id'] = $user['id'];
    } else {
        // token is invalid, remove it
        setcookie('remember_token', '', time() - (60 * 60 * 2), '/');
    }
}
