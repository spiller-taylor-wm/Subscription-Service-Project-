<?php
    require_once('include/connect.php');
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
                $name = $_POST['name'];
                $email = strtolower($_POST['email']);
                $password = $_POST['password'];
                $password_confirm = $_POST['password_confirm'];

                // Validates the Form:
                if (empty($name) || empty($email) || empty($password) || empty($password_confirm) || ($password !== $password_confirm)){
                    $message .= '<p>Please fill out all fields.</p>';
                    $output_form = true;
                } else {
                    // ENCRYPT PASSWORD
                    $password = sha1($password);

                    // ENTER USER INFO
                    $query = "INSERT INTO users (email, password, name) VALUES (:email, :password, :name)";
                    $stmt = $dbh->prepare($query);
                    $result = $stmt->execute(
                        array(
                            'email'     => $email,
                            'password'  => $password,
                            'name'      => $name
                        )
                    );

                    if ($result) {
                        $message = "User " . $_POST['email'] . " was successfully saved.";
                    } else {
                        $message = "There was an error saving " . $_POST['email'];
                    }

                    // SHOW SUCCESS MESSAGE TO USER
                    echo '<h1>Welcome ' . $name . '!</h1><br />';
                    echo '<a href="profile.php">Go to your account.</a>';
                    echo $message;
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
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                <input name="name" type="text" placeholder="full name" value="<?php echo $name; ?>">
                                <input name="email" type="text" placeholder="email" value="<?php echo $email; ?>">
                                <input name="password" type="password" placeholder="password">
                                <input name="password_confirm" type="password" placeholder="confirm password">
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