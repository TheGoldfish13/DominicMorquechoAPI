<?php
    require_once(__DIR__ . '/../model/config.php');

    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
    $query = $_SESSION["connection"]->query("SELECT * FROM users WHERE username = '$username'");

    if ($query->num_rows == 1) {
        $row = $query->fetch_array();

        if ($row["password"] === crypt($password, $row["salt"])) {
            $_SESSION["authenticated"] = true;
            $_SESSION["name"] = $username;
        } else {
            echo "Invalid username and password1";
        }
    } else {
        echo "Invalid username and password2";
    }