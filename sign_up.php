<?php
    require_once('include/connect.php');
    require_once('include/appvars.php');
    $message = '';
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" />

        <!-- Links for the navigation bar -->
        <script type="text/javascript" rel="script" src="js/nav.js"></script>
        <link rel="stylesheet" type="text/css" href="css/form.css" />
        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
        <div align="center">
            <h1>Listy</h1>
            <a href="profile.php">profile</a>
        </div>
        <?php
            if (@$_POST['adduser']) {
                $output_form = false;
                $name = trim($_POST['name']);
                $email = trim(strtolower($_POST['email']));
                $password = $_POST['password'];
                $password_confirm = $_POST['password_confirm'];
                $screenshot = trim($_FILES['screenshot']['name']);
                $screenshot_type = $_FILES['screenshot']['type'];
                $screenshot_size = $_FILES['screenshot']['size'];

                // Validates the Form:
                if (!empty($name) && !empty($email) && !empty($password) && !empty($password_confirm) && !empty($screenshot) && ($password == $password_confirm)) {
                    if ((($screenshot_type == 'image/gif') || ($screenshot_type == 'image/jpeg') || ($screenshot_type == 'image/pjpeg') || ($screenshot_type == 'image/png'))
                        && ($screenshot_size > 0) && ($screenshot_size <= GW_MAXFILESIZE)) {

                        if ($_FILES['screenshot']['error'] == 0) {
                            // Move file to the target upload folder
                            $target = GW_UPLOADPATH . $screenshot;

                            if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $target)) {
                                // ENTER USER INFO
                                $query = "INSERT INTO users (email, password, name, screenshot) VALUES (:email, sha1(:password), :name, :screenshot)";
                                $stmt = $dbh->prepare($query);
                                $result = $stmt->execute(
                                    array(
                                        'email'         =>  $email,
                                        'password'      =>  $password,
                                        'name'          =>  $name,
                                        'screenshot'    =>  $screenshot
                                    )
                                );

                                if ($result) {
                                    $message = "User " . $_POST['email'] . " was successfully saved.";
                                } else {
                                    $message = "There was an error saving " . $_POST['email'];
                                    $output_form = true;
                                }

                                // SHOW SUCCESS MESSAGE TO USER
                                echo '<h1>Welcome ' . $name . '!</h1><br />';
                                echo '<a href="profile.php">Go to your account.</a>';
                                echo $message;
                            } else {
                                $message = '<p>Sorry, there was a problem uploading your screen shot image.</p>';
                                $output_form = true;
                            }
                        }
                    } else {
                        $message = '<p>The screen shot must be a GIF, JPEG, or PNG image file no greater than ' . (GW_MAXFILESIZE / 1024) .' KB in size.</p>';
                        $output_form = true;
                    }
                    // Try to delete the temp screenshot file
                    @unlink($_FILES['screenshot']['tmp_name']);
                } else {
                    $output_form = true;
                    $message = '<p>Please fill in all fields</p>';
                }
            } else {    // Button was not pressed or page has not loaded
                $output_form = true;
            }

            if ($output_form) {     // Displays the form with sticky data
                ?>
                <div class="container">
                    <div class="login-container">
                        <div id="output"></div>
                        <div class="avatar"></div>
                        <div class="form-box">
                            <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo GW_MAXFILESIZE; ?>" />
                                <input name="name" type="text" placeholder="full name" value="<?php echo $name; ?>">
                                <input name="email" type="text" placeholder="email" value="<?php echo $email; ?>">
                                <input name="password" type="password" placeholder="password">
                                <input name="password_confirm" type="password" placeholder="confirm password">
                                <input type="file" id="screenshot" name="screenshot" />
                                <button class="btn btn-info btn-block login" name="adduser" value="1" type="submit">Sign Up</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
                echo $message;
            }
        ?>
    </body>
</html>