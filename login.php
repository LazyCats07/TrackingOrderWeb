<?php
session_start();

// Atur koneksi ke database user
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'login';
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$err = "";
$username = "";
$rememberMe = "";

if (isset($_COOKIE['cookie_username'])) {
    $cookie_username = $_COOKIE['cookie_username'];
    $cookie_password = $_COOKIE['cookie_password'];

    $sql1 = "SELECT * FROM login WHERE username = '$cookie_username'";
    $q1 = mysqli_query($conn, $sql1);
    $r1 = mysqli_fetch_array($q1);

    if ($r1 && $r1['password'] == $cookie_password) {
        $_SESSION['session_username'] = $cookie_username;
        $_SESSION['session_password'] = $cookie_password;
        header("Location: masterAdmin");
        exit();
    }
}

if (isset($_SESSION['session_username'])) {
    header("Location: masterAdmin");
    exit();
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $rememberMe = isset($_POST['rememberMe']) ? $_POST['rememberMe'] : '';

    if ($username == '' || $password == '') {
        $err .= "<li>Silakan masukkan username dan juga password.</li>";
    } else {
        $sql1 = "SELECT * FROM login WHERE username = '$username'";
        $q1 = mysqli_query($conn, $sql1);
        $r1 = mysqli_fetch_array($q1);

        if (!$r1) {
            $err .= "<li>Username <b>$username</b> Tidak tersedia.</li>";
        } elseif ($r1['password'] != md5($password)) {
            $err .= "<li>Password tidak sesuai.</li>";
        }
    }

    if (empty($err)) {
        $_SESSION['session_username'] = $username;
        $_SESSION['session_password'] = md5($password);

        if ($rememberMe == '1') {
            setcookie('cookie_username', $username, time() + (60 * 60 * 24 * 30), "/");
            setcookie('cookie_password', md5($password), time() + (60 * 60 * 24 * 30), "/");
        }
        header("Location: masterAdmin");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <style>
        .glyphicon-eye-open, .glyphicon-eye-close {
            cursor: pointer;
        }
        footer {
            background-color: #4a4a4a;
            color: white;
            padding: 20px 0;
            border-top: 1px solid #ccc;
        }
        .footer-text {
            font-size: 12px;
        }
        .footer-links a {
            color: white;
            text-decoration: none;
            margin-right: 10px;
        }
    </style>
</head>
<body>
<div class="container my-4">    
    <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Login dan Masuk Ke Sistem</div>
            </div>      
            <div style="padding-top:30px" class="panel-body">
                <?php if($err){ ?>
                    <div id="login-alert" class="alert alert-danger col-sm-12">
                        <ul><?php echo $err ?></ul>
                    </div>
                <?php } ?>                
                <form id="loginform" class="form-horizontal" action="" method="post" role="form">       
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="login-username" type="text" class="form-control" name="username" value="<?php echo $username ?>" placeholder="username">                                        
                    </div>
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="login-password" type="password" class="form-control" name="password" placeholder="password">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-eye-open" id="toggle-password"></i>
                        </span>
                    </div>
                    <div class="input-group">
                        <div class="checkbox">
                        <label>
                            <input id="login-remember" type="checkbox" name="rememberMe" value="1" <?php if($rememberMe == '1') echo "checked"?>> Remember Me
                        </label>
                        </div>
                    </div>
                    <div style="margin-top:10px" class="form-group">
                        <div class="col-sm-12 controls">
                            <input type="submit" name="login" class="btn btn-success" value="Login"/>
                        </div>
                    </div>
                </form>    
            </div>                     
        </div>  
    </div>
</div>

<script>
    document.getElementById('toggle-password').addEventListener('click', function () {
        var passwordField = document.getElementById('login-password');
        var passwordFieldType = passwordField.getAttribute('type');
        if (passwordFieldType === 'password') {
            passwordField.setAttribute('type', 'text');
            this.classList.remove('glyphicon-eye-open');
            this.classList.add('glyphicon-eye-close');
        } else {
            passwordField.setAttribute('type', 'password');
            this.classList.remove('glyphicon-eye-close');
            this.classList.add('glyphicon-eye-open');
        }
    });
</script>
</body>
</html>
