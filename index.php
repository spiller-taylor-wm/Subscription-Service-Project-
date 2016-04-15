<?php
    require_once('include/connect.php');
    $message = '';


    if(!isset($_COOKIE['user_id'])) {
        if (@$_POST['submit']) {
            $email = strtolower($_POST['email']);
            $password = sha1($_POST['password']);

            if (!$_POST['email'] || !$_POST['password']) {
                $message .= '<p>Please enter all fields.</p>';
            } else {
                // CHECK PASSWORD
                $query = "SELECT password FROM users WHERE email = :email";
                $stmt = $dbh->prepare($query);
                $stmt->execute(array('email' => $email));
                $result = $stmt->fetchColumn();

                if ($password == $result) {
                    $query = 'SELECT name, id FROM users WHERE email = :email AND password = :password';
                    $stmt = $dbh->prepare($query);
                    $stmt->execute(
                        array(
                            'email' => $email,
                            'password' => $password
                        )
                    );
                    $result = $stmt->fetch();
                    $name = $result['name'];
                    $id = $result['id'];

                    // PUT STUFF AS COOKIES
                    setcookie('user_id', $id);
                    setcookie('name', $name);

                    if ($email == 'admin@listy.com'){
                        $destination = 'admin.php';
                    } else {
                        $destination = 'profile.php';
                    }

                    // REDIRECT USER. IF ADMIN, GO TO ADMIN PAGE
                    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/' . $destination;
                    header('Location: ' . $home_url);

                    $message = '<p>User ' . $_COOKIE['name'] . ' was logged in.</p> <br /><a href="profile.php>">Go to your profile.</a>';
                } else {
                    $message .= '<p>Your email and password combination is incorrect!</p>';
                }
            }
        }
    }
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" />

        <!-- Links for the navigation bar -->
        <script type="text/javascript" rel="script" src="js/form.js"></script>
        <link rel="stylesheet" type="text/css" href="css/form.css" />
        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
        <div align="center">
            <h1>Listy</h1>
            <a href="admin.php">admin</a>
        </div>
            <?php
                // If there is no cookie, show the form to log in
                if (empty($_COOKIE['user_id'])){
                    echo $message;
            ?>
        <div class="container">
            <div class="login-container">
                <div id="output"></div>
                <div class="avatar"></div>
                <div class="form-box">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <input name="email" type="text" placeholder="email">
                        <input name="password" type="password" placeholder="password">
                        <button class="btn btn-info btn-block login" name="submit" value="1" type="submit">Login</button>
                    </form>
                    <a href="sign_up.php">sign up</a>
                </div>
            </div>

            <?php
                } else {
                    // They are already logged in
                    echo $message;
                }
            ?>
        </div>
    </body>
</html>