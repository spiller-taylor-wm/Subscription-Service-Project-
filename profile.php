<?php
    require_once('include/authorize.php');
    require_once('include/connect.php');
    //require_once('appvars.php');
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
            <h1>Send an email to all users:</h1>
            <?php
            if (isset($_POST['submit'])) {
                $output_form = false;
                $from = 'admin@listy.com';
                $subject = $_POST['subject'];
                $text = $_POST['body'];

                // Validates the Form:
                if (empty($subject) || empty($text)) {
                    if (empty($subject) && empty($text)) {    // Subject and Body are empty
                        echo 'You forgot the subject and body text.';
                        $output_form = true;
                    } elseif (empty($subject)) {    // Subject is empty
                        echo 'You forgot the subject.';
                        $output_form = true;
                    } elseif (empty($text)) {      // Body is empty
                        echo 'You forgot the body text.';
                        $output_form = true;
                    }
                } elseif (!empty($subject) && !empty($text)) {    // All is good. Send emails.

                    $dbh = new PDO("mysql:host=$hostname;dbname=subscription_service", $username, $password);

                    $query = "SELECT * FROM users";
                    $stmt = $dbh->prepare($query);
                    $stmt->execute();
                    $result = $stmt->fetchAll();

                    foreach ($result as $row) {
                        $to = $row['email'];
                        $name = $row['name'];
                        $msg = "Dear $name,\n$text";
                        mail($to, $subject, $msg, 'From:' . $from);
                        echo 'Email sent to: ' . $to . '<br />';
                    }
                }

            } else {    //Button was not pressed or page has not loaded
                $output_form = true;
            }

            if ($output_form) {     // Displays the form with sticky data
                ?>

                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                    <label for="subject">Subject of email:</label><br />

                    <input id="subject" name="subject" type="text" size="30" value="<?php echo $subject; ?>"/><br />

                    <label for="mail">Body of email:</label><br />

                    <textarea id="mail" name="body" rows="8" cols="40"><?php echo $text; ?></textarea><br />

                    <input type="submit" name="submit" value="Submit" />

                </form>

                <?php
            }
            ?>



            <h1>Edit or Remove Users:</h1>
            <?php
            require_once('appvars.php');
            require_once('connectvars.php');

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
                echo '<td><a href="removescore.php?id=' . $row['id'] .
                    '&amp;name=' . $row['name'] .
                    '&amp;email=' . $row['email'] .
                    '&amp;screenshot=' .
                    '">Remove</a>';
                echo '</td></tr>';
            }
            echo '</table>';
            ?>


            <?php
            if (isset($_GET['id']) && isset($_GET['name']) && isset($_GET['email'])) {
                // Grab the score data from the GET
                $id = $_GET['id'];
                $name = $_GET['name'];
                $email = $_GET['email'];
            } else  {
                echo '<p class="error">Sorry, no user was specified for removal.</p>';
            }

            if (isset($_POST['submit'])) {
                if ($_POST['confirm'] == 'Yes') {
                    // Delete the screen shot image file from the server
                    // @unlink(GW_UPLOADPATH . $screenshot);

                    // Delete the score data from the database
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
                echo '<form method="post" action="removescore.php">';                       // !!!!!!!!!!!!!!!!
                echo '<input type="radio" name="confirm" value="Yes" /> Yes ';
                echo '<input type="radio" name="confirm" value="No" checked="checked" /> No <br />';
                echo '<input type="submit" value="Submit" name="submit" />';
                echo '<input type="hidden" name="id" value="' . $id . '" />';
                echo '<input type="hidden" name="name" value="' . $name . '" />';
                echo '<input type="hidden" name="score" value="' . $score . '" />';
                echo '</form>';
            }

            echo '<p><a href="admin.php">&lt;&lt; Back to admin page</a></p>';
            ?>

        </div>
    </body>
</html>