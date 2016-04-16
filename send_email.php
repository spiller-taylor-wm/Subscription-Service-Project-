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
            <li class="active"><a href='#'>Email</a></li>
            <li><a href='remove.php'>Users</a></li>
            <li><a href='log_out.php'>Log Out</a></li>
        </ul>
    </div>
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

</div>
</body>
</html>