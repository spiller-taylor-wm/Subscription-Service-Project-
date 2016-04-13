<?php
    require_once('include/connect.php');
    require_once('include/appvars.php');
    require_once('include/authorize.php');
    $message = '';
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
        <script src="js/navbar.js" type="text/javascript" rel="script"></script>
        <div align="center" id="content">

        <?php
        if (isset($_GET['id']) && isset($_GET['name']) && isset($_GET['email']) && isset($_GET['screenshot'])) {
            // Grab the score data from the GET
            $id = $_GET['id'];
            $name = $_GET['name'];
            $email = $_GET['email'];
            $screenshot = $_GET['screenshot'];
        } else if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['email'])) {
            // Grab the score data from the POST
            $id = $_POST['id'];
            $name = $_POST['name'];
            $score = $_POST['score'];
        } else  {
            echo '<p class="error">Sorry, no user was specified for removal.</p>';
        }

        if (isset($_POST['submit'])) {
            if ($_POST['confirm'] == 'Yes') {
                // Delete the screen shot image file from the server
                @unlink(GW_UPLOADPATH . $screenshot);

                // Delete the user data from the database
                $query = "DELETE FROM users WHERE id = $id LIMIT 1";
                $stmt = $dbh->prepare($query);
                $stmt->execute();

                // Confirm success with the user
                echo '<p>User ' . $name . ' at ' . $email . ' was successfully removed.';
            } else {
                echo '<p class="error">The user was not removed.</p>';
            }
        } else if (isset($id) && isset($name) && isset($email)) {
            echo '<p>Are you sure you want to delete the following user?</p>';
            echo '<p><strong>Name: </strong>' . $name . '<br /><strong></strong></p>';
            echo '<form method="post" action="edit_user.php">';                       // !!!!!!!!!!!!!!!!
            echo '<input type="radio" name="confirm" value="Yes" /> Yes ';
            echo '<input type="radio" name="confirm" value="No" checked="checked" /> No <br />';
            echo '<input type="submit" value="Submit" name="submit" />';
            echo '<input type="hidden" name="id" value="' . $id . '" />';
            echo '<input type="hidden" name="name" value="' . $name . '" />';
            echo '<input type="hidden" name="email" value="' . $email . '" />';
            echo '</form>';
        }

        echo '<p><a href="profile.php">&lt;&lt; Back to admin page</a></p>';
        ?>
    </body>
</html>
