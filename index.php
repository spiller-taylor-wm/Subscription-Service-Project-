<?php
    require_once('include/connect.php');
    $message = '';

    if(@$_POST['submit']){
        $email = strtolower($_POST['email']);
        $password = sha1($_POST['password']);

        if(!$_POST['email'] || !$_POST['password']){
            $message .= '<p>Please enter all fields.</p>';
        } else {
            // CHECK PASSWORD
            $query = "SELECT password FROM users WHERE email = :email";
            $stmt = $dbh->prepare($query);
            $stmt->execute(array('email' => $email));
            $result = $stmt->fetchColumn();

            if($password == $result){
                $stmt = $dbh->prepare('SELECT id FROM users WHERE email = :email AND password = :password');
                $stmt->execute(
                    array(
                        'email'     => $email,
                        'password'  => $password
                    )
                );
                $result = $stmt->fetchColumn();
                $_SESSION['users_id'] = $result; // SET USER ID AS SESSION VARIABLE
                $message = '<p>User '. $_POST['email'] .' was logged in.</p> <br /> <a href="profile.php>">Go to your profile.</a>';
            } else {
                $message .= '<p>Your email and password combination is incorrect!</p>';
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
        <script type="text/javascript" rel="script" src="js/nav.js"></script>
        <link rel="stylesheet" type="text/css" href="css/form.css" />
        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
        <div align="center">
            <h1>Listy</h1>
            <a href="profile.php">profile</a>
            <?php echo $message; ?>
        </div>
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
        </div>
    </body>
</html>