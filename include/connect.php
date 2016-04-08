<?php
/*** mysql hostname ***/
$hostname = 'localhost';

/*** mysql username ***/
$username = 'root';

/*** mysql password ***/
/** if using at west-mec */
$password = 'root';

/**If using at home
$password = '';
 * */

try {
    $dbh = new PDO("mysql:host=$hostname;dbname=subscription_service", $username, $password);
}
catch(PDOException $e) {
    echo $e->getMessage();
}
