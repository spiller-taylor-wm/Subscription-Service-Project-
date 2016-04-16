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
            <li class='active'><a href='admin.php'>Home</a></li>
            <li><a href='send_email.php'>Email</a></li>
            <li><a href='remove.php'>Users</a></li>
            <li><a href='log_out.php'>Log Out</a></li>
        </ul>
    </div>
    <br />
    <img src="https://carebooker.com/static/img/banner-welcome-back.png" />
    <br />
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum congue enim id dui semper pharetra. Ut et posuere orci. Morbi quis ipsum leo. Integer eu ipsum ultrices, dapibus metus vel, elementum arcu. Etiam tristique, mauris nec placerat consequat, lectus ante finibus lectus, quis pretium urna sem a elit. Aliquam erat volutpat. Donec congue, eros sit amet interdum faucibus, risus eros cursus nisl, at mollis dolor leo nec turpis.

        Nam non rhoncus velit. Morbi eu lacus sit amet massa posuere pellentesque. Quisque elementum finibus ipsum a pharetra. Integer elementum ac sem nec lacinia. Mauris et aliquet urna, vitae porttitor dui. Aenean eget ligula nec ipsum pretium tempus cursus non ex. Quisque luctus vestibulum mauris ac sodales. Donec eget vestibulum velit. Nullam congue tellus tellus, et lobortis mauris efficitur vel. Morbi ipsum metus, laoreet at ex quis, sagittis lacinia neque.

        Donec suscipit sed nulla a fringilla. Vivamus ut massa id odio malesuada egestas volutpat non mi. Nulla lectus ligula, facilisis eu pretium sit amet, consequat in nibh. Morbi tempus massa a mauris gravida rutrum. Sed nec sollicitudin nisl. Donec semper eros eget nulla laoreet finibus. Sed interdum scelerisque justo. Vivamus posuere imperdiet posuere. Praesent egestas neque nulla, sit amet placerat orci tempor quis. Duis ac odio lacinia, congue nibh a, convallis lorem. Praesent porttitor accumsan lectus, nec euismod metus ullamcorper et. Donec vitae dui et odio auctor finibus. Etiam bibendum purus vehicula vulputate accumsan. Mauris cursus id urna quis malesuada. Pellentesque pulvinar consequat malesuada.</p>


</div>
</body>
</html>