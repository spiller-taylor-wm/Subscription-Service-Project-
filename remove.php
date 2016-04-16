<?php
    require_once('include/connect.php');
    require_once('include/appvars.php');

    if(!isset($_COOKIE['user_id']) || !isset($_COOKIE['name'])){
        // Redirect to the home page
        $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . ' ';
        header('Location: ' . $home_url);
        exit();
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />

    <!-- Bootstrap -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Navigation -->
    <link rel="stylesheet" href="css/styles.css">
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
</head>
<body>
<div align="center" id="content">
    <div id='cssmenu'>
        <ul>
            <li><a href='admin.php'>Home</a></li>
            <li><a href='send_email.php'>Email</a></li>
            <li class='active'><a href='remove.php'>Users</a></li>
            <li><a href='log_out.php'>Log Out</a></li>
        </ul>
    </div>

    <h1>Edit or Remove Users:</h1>
    <?php
    // Retrieve the score data from MySQL
    $query = "SELECT * FROM users";
    $stmt = $dbh->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll();

    // Loop through the array of users, formatting it as HTML
    echo '<table>';
    foreach ($result as $row) {
        // Display the score data
        echo '<tr><td><strong>' . $row['name'] . '</strong></td>';
        echo '<td>' . $row['email'] . '</td>';
        echo '<td><a href="remove_user.php?id=' . $row['id'] .
            '&amp;name=' . $row['name'] .
            '&amp;email=' . $row['email'] .
            '&amp;screenshot=' . $row['screenshot'] . '">Remove</a>';
        echo '</td></tr>';
    }
    echo '</table>';
    ?>

</div>
</body>
</html>