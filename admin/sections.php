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

    if ($do == 'manage')
    {
        ?>
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="page-header">لوحة الاقسام</h1>
            </div>

        </div>

        <div class="row">
        <div class="table-responsive">
        <table class="main-table manage-members text-center table table-bordered">
        <tr>
            <td>اسم القسم</td>
            <td>وصف القسم</td>
            <td>تاريخ تسجيله</td>
            <?php if ($_SESSION['role'] == 2){ ?>
            <td>التعديل</td>
            <?php } ?>
        </tr>
        <?php

        $sections =getAllFrom('*','sections','','','sec_id');
        foreach ($sections as $section)
        {
            echo '<tr>';
            echo '<td>'.$section['sec_name'].'</td>';
            echo '<td>'.$section['sec_desc'].'</td>';

            echo '<td>'.$section['sec_date'].'</td>';
            if ($_SESSION['role'] == 2){
            echo '<td>';
            ?>
            <a href="../admin/sections.php?do=edit&&id=<?php echo $section['sec_id']; ?>" class="btn btn-primary"><i class="fa fa-edit">تعديل</i></a>
            <?php
            echo '</td>';}
            echo '</tr>';
        }
    }elseif ($do == 'add')
    {
         ?>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1 class="page-header">اضافة قسم جديد</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
               <div class="col-md-8 col-md-offset-2">
                   <form action="../admin/sections.php?do=insert" method="post">
                       <div class="form-group">
                           <label> اسم القسم</label>
                           <input type="text" name="sec_name" class="form-control">
                       </div>
                       <div class="form-group">
                           <label>وصف القسم</label>
                           <textarea name="sec_desc" class="form-control" rows="3"></textarea>
                       </div>
                       <button type="submit" class="btn btn-success">حفظ</button>
                   </form>
               </div>
            </div>

        <?php

    }elseif ($do == 'insert')
    {
        if ($_SERVER['REQUEST_METHOD']=='POST')
        {
            $sec_name = $_POST['sec_name'];
            $sec_desc = $_POST['sec_desc'];

            if (!empty($sec_name))
            {
                $stmt = $con->prepare("INSERT INTO sections(sec_name,sec_desc,sec_date)
                                          VALUES(:sec_name,:sec_desc,now())");
                $stmt->execute(['sec_name'=>$sec_name,'sec_desc'=> $sec_desc]);
                echo '<div class="alert alert-success">تم تسجيل القسم بنجاح'.$stmt->rowCount().'</div>';

            }else
                {
                    $msg = '<div class="alert alert-danger">لابد من كتابة اسم القسم</div>';
                    redirectHome($msg,'back');
                    exit();
                }
        }else
        {
            echo '<div class="alert alert-danger">ليس لك الحق في الدخول لهذه الصفحة</div>';
            redirectHome($msg);
            exit();
        }
    }elseif ($do == 'edit')
    {
        $section = selectid('sections','sec_id',$_GET['id']);
        ?>
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="page-header">تعديل بيانات القسم</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form action="../admin/sections.php?do=update&&id=<?php echo $section['sec_id'] ?>" method="post">
                    <div class="form-group">
                        <label> اسم القسم</label>
                        <input type="text" name="sec_name" class="form-control" value="<?php echo $section['sec_name'] ?>">
                    </div>
                    <div class="form-group">
                        <label>وصف القسم</label>
                        <textarea name="sec_desc" class="form-control" rows="3"><?php echo $section['sec_desc'] ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">حفظ</button>
                </form>
            </div>
        </div>
        <?php
    }elseif ($do == 'update')
    {
        if ($_SERVER['REQUEST_METHOD']=='POST')
        {
            $id       = $_GET['id'];
            $sec_name = $_POST['sec_name'];
            $sec_desc = $_POST['sec_desc'];
            $stmt = $con->prepare("UPDATE sections SET sec_name=?,sec_desc=? WHERE sec_id =?");
            $stmt->execute([$sec_name,$sec_desc,$id]);
            echo '<div class="alert alert-success">تم التعديل بنجاح'.$stmt->rowCount().'</div>';
        }else
        {
            $msg = '<div class="alert alert-danger">ليس لك الحق في الدخول لهذه الصفحة</div>';
            redirectHome($msg);
            exit();
        }
    }elseif ($do == 'delete')
    {
        if (isset($_GET['id'])&&is_numeric($_GET['id']))
        {
            $id = $_GET['id'];
            $stmt = $con->prepare("DELETE FROM sections WHERE sec_id=?");
            $stmt->execute([$id]);
            echo '<div class="alert alert-success">تم حذف القسم بنجاح'.$stmt->rowCount().'</div>';
        }
    }
}
?>
    </table>
    </div>
<?php require 'temp/footer.php'; ?>