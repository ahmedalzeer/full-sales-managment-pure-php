<?php

session_start();
if(!isset($_SESSION['username']))
{
    header('location:../index.php');
    exit();
}else
{

    require 'init.php';
?>
    <div id="page-wrapper">
<?php

    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    // If The Page Is Main Page

    if ($do == 'manage'&&$_SESSION['role'] == 2)
    {
        ?>
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="page-header">لوحة الموظفين</h1>
            </div>

        </div>

        <div class="row">
        <div class="table-responsive">
            <table class="main-table manage-members text-center table table-bordered">
                <tr>
                    <td>الاسم</td>
                    <td>اسم المستخدم</td>
                    <td>درجة الموظف</td>
                    <td>تاريخ تسجيله</td>
                    <td>التعديل او الحذف</td>
                </tr>
        <?php

                $usersinfo =getAllFrom('*','users','','','user_id');
                foreach ($usersinfo as $userinfo)
                {
                    echo '<tr>';
                    echo '<td>'.$userinfo['user_name'].'</td>';
                    echo '<td>'.$userinfo['username'].'</td>';
                    if($userinfo['user_role']==2)
                    {
                        echo '<td>مدير</td>';
                    }elseif($userinfo['user_role']==1)
                    {
                        echo '<td>مشرف</td>';
                    }else
                    {
                        echo '<td>موظف مبيعات</td>';
                    }
                    echo '<td>'.$userinfo['user_date'].'</td>';
                    echo '<td>';
                    ?>
                            <a href="../admin/users.php?do=edit&&id=<?php echo $userinfo['user_id']; ?>" class="btn btn-primary"><i class="fa fa-edit">تعديل</i></a>
                    <?php
                    echo '</td>';
                    echo '</tr>';
                }
    } elseif ($do == 'add'&&$_SESSION['role'] == 2)
    {
        ?>

            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1 class="page-header">اضافة موظف جديد</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
               <div class="col-md-8 col-md-offset-2">
                   <form action="../admin/users.php?do=insert" method="post">
                       <div class="form-group">
                           <label>الاسم</label>
                           <input type="text" name="name" class="form-control">
                       </div>
                       <div class="form-group">
                           <label>اسم المستخدم</label>
                           <input type="text" name="username" class="form-control">
                       </div>
                       <div class="form-group">
                           <label>كلمة السر</label>
                           <input type="password" name="password" class="form-control">
                       </div>
                       <div class="form-group">
                           <label>درجة الموظف</label>
                           <select name="role" class="form-control">
                               <option value="">اختر الدرجة</option>
                               <option value="0">موظف مبيعات</option>
                               <option value="1">مشرف</option>
                               <option value="2">مدير</option>
                           </select>
                       </div>
                       <button type="submit" name="adduser" class="btn btn-success">حفظ</button>
                   </form>
               </div>
            </div>

        <?php

    } elseif ($do == 'insert')
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST'&&$_SESSION['role'] == 2)
        {
            if (!empty($_POST['name'])&&!empty($_POST['username'])&&!empty($_POST['password']))
            {
                $user_name =$_POST['name'];
                $username =$_POST['username'];
                $pass =sha1($_POST['password']);
                $userrole = $_POST['role'];
                $stmt = $con->prepare('INSERT INTO users(user_name,username,password,user_role,user_date )
                                                VALUES (:user_name,:username,:password,:user_role,now())');
                $stmt->execute([
                    'user_name'=>$user_name,
                    'username' =>$username,
                    'password' =>$pass,
                    'user_role'=>$userrole
                ]);
                echo '<div class="alert alert-success">'.$stmt->rowCount().'<strong>تم التسجيل ينجاح</strong></div>';
            }else
                {
                    $msg = '<div class="alert alert-danger">ادخل الحقول بشكل صحيح</div>';
                    redirectHome($msg,'back');
                    exit();
                }
        }else
        {
            echo '<div class="alert alert-danger">ليس لك الحق في الدخول لهذه الصفحة</div>';
            redirectHome($msg);
            exit();
        }

    }elseif ($do == 'edit'&&$_SESSION['role'] == 2)
    {
        if (isset($_GET['id'])&&is_numeric($_GET['id'])&&$_SESSION['role'] == 2)
        {
            $userinformation = selectid('users','user_id',$_GET['id']);
        }
        ?>
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="page-header">تعديل بيانات موظف </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form action="../admin/users.php?do=update&&id=<?php echo $userinformation['user_id']; ?>" method="post">
                    <div class="form-group">
                        <label>الاسم</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $userinformation['user_name']; ?>">
                    </div>
                    <div class="form-group">
                        <label>اسم المستخدم</label>
                        <input type="text" name="username" class="form-control" value="<?php echo $userinformation['username']; ?>">
                    </div>
                    <div class="form-group">
                        <label>كلمة السر</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>درجة الموظف</label>
                        <select name="role" class="form-control">
                            <option value="<?php echo $userinformation['user_role']; ?>"><?php
                                if($userinformation['user_role']==2)
                                {
                                    echo '<td>مدير</td>';
                                }elseif($userinformation['user_role']==1)
                                {
                                    echo '<td>مشرف</td>';
                                }else
                                {
                                    echo '<td>موظف مبيعات</td>';
                                }
                                ?></option>
                            <option value="0">موظف مبيعات</option>
                            <option value="1">مشرف</option>
                            <option value="2">مدير</option>
                        </select>
                    </div>
                    <button type="submit" name="adduser" class="btn btn-success">حفظ</button>
                </form>
            </div>
        </div>

        <?php
    }elseif ($do == 'update'&&$_SESSION['role'] == 2)
    {
        if ($_SERVER['REQUEST_METHOD']== 'POST'&&$_SESSION['role'] == 2)
        {
            $nameuser = $_POST['name'];
            $user     = $_POST['username'];
            $pass     = sha1($_POST['password']);
            $roleuser = $_POST['role'];
            $id       =$_GET['id'];
            if (!empty($nameuser)&&!empty($user)&&!empty($roleuser))
            {
                $stmt = $con->prepare('UPDATE users SET user_name=?,username=?,password=?,user_role=? WHERE user_id=?');
                $stmt->execute([$nameuser,$user,$pass, $roleuser,$id]);
                echo '<div class="alert alert-success">تم التحديث بنجاح'.$stmt->rowCount().'</div>';
            }else
                {
                    $msg = '<div class="alert alert-danger">تحقق من المدخلات</div>';
                    redirectHome($msg,'back');
                    exit();
                }
        }else
            {
                $msg = '<div class="alert alert-danger">ليس لك الحق في الدخول لهذه الصفحة</div>';
                redirectHome($msg);
                exit();
            }
    }elseif ($do == 'delete'&&$_SESSION['role'] == 2)
    {
        if (isset($_GET['id'])&&is_numeric($_GET['id']));
        {
            $id   = $_GET['id'];
            $stmt = $con->prepare('DELETE FROM users WHERE user_id=?');
            $stmt->execute([$id]);
            echo '<div class="alert alert-success">تم الحذف بنجاح'.$stmt->rowCount().'</div>';

        }

    } else
        {

        $msg = '<div class="alert alert-danger">الصفحة غير موجودة</div>';
            redirectHome($msg);
        }
}
?>
</div>
<?php require 'temp/footer.php'; ?>


