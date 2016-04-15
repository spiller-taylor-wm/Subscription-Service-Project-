<?php
    // if the user is logged in, delete the cookie
    if (isset($_COOKIE['user_id'])) {
        setcookie('user_id', '', time() - 3600);
        setcookie('name', '', time() - 3600);
    }

    // Redirect to the home page
    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . ' ';
    header('Location: ' . $home_url);

?>