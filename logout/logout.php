<?php
session_start();
require_once('../config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $logout_update = mysqli_query($conn, "UPDATE users SET remember_token = NULL, remember_token_expire = NULL WHERE id = $id");

    if ($logout_update) {
        session_unset();
        session_destroy();
        header("Location: ../index.php");
        exit();
    }
}
