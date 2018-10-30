<?php
ob_start();
    session_start();
    require 'admin/congif.php';
    if(isset($_SESSION['username']))
    {
        header('location:admin/dashboard.php');
    }else
        {
            if(isset($_POST['sub']))
            {
                $user = $_POST['username'];
                $pass = sha1($_POST['password']);
                if (!empty($user)&&!empty($pass))
                {
                    $stmt = $con->prepare('SELECT * FROM users WHERE username=? AND password=?');
                    $stmt->execute([$user,$pass]);
                    $row = $stmt->rowCount();
                    if ($row>0)
                    {
                        $userinfo = $stmt->fetch();
                        $_SESSION['username']=$userinfo['username'];
                        $_SESSION['userid']  =$userinfo['user_id'];
                        $_SESSION['role'] = $userinfo['user_role'];
                        header('location:admin/dashboard.php');
                        exit();
                    }
                }else
                    {
                        echo '<div class="alert alert-danger">اكتب اسم المستخدم وكلمة المرور بشكل صحيح</div>';
                    }
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>sales management</title>
    <link rel="stylesheet" href="layouts/bootstrap.min.css"/>
    <link rel="stylesheet" href="layouts/font-awesome.min.css"/>
    <link rel="stylesheet" href="layouts/css/front.css"/>
</head>
<body id="loginform">
<div class="container">
    <h1 class="text-center">php sales app</h1>
    <div class="row">
        <div class="login-page col-md-8 col-md-offset-2 ">
            <div class="login panel">
                <div class="panel-primary">
                    <div class="panel-heading">
                        <label><i class="fa fa-lock fa-lg"></i>  تسجيل الدخول</label>
                    </div>
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                        <div class="panel-body">

                            <input class="form-control" type="text" name="username" placeholder="اسم المستخدم" autocomplete="off">
                            <input class="form-control" type="password" name="password" placeholder="كلمة المرور" autocomplete="new-password">

                        </div>
                        <div class="panel-footer">
                            <button class="btn btn-primary" type="submit" name="sub">دخول</button>
                        </div>
                    </form>
                </div>
            </div>
            <div>developed by ahmed alzeer</div>
            <div>01015258850</div>
        </div>
    </div>
</div>

<script src="layouts/bootstrap.min.js"></script>
<script src="layouts/jquery-1.11.0.js"></script>
</body>
</html>