<?php
    // require_once('include/authorize.php');
    require_once('include/connect.php');
    require_once('include/appvars.php');
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Profile</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" />

        <!-- Bootstrap -->
        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" />
    </head>
    <body>

        <div align="center" id="content">
            <h1>Welcome, <?php echo $_COOKIE['name']; ?> </h1>
            <a href="log_out.php">log out</a>

        </div>
    </body>
</html>