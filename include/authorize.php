<?php
if(!isset($_SESSION['users_id']) || !is_numeric($_SESSION['users_id'])){
    // The user is not logged in so send the authentication headers
    header('HTTP/1.1 401 Unauthorized');
    exit('<h6>There was an error. Please log in again.</h6>');
}