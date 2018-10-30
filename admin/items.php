<?php
ob_start();
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
                <h1 class="page-header">لوحة الاصناف</h1>
            </div>

        </div>

        <div class="row">
        <div class="table-responsive">
        <table class="main-table manage-members text-center table table-bordered">
        <tr>
            <td>اسم الصنف</td>
            <td>وصف الصنف</td>
            <td>سعر الشراء</td>
            <td>سعر البيع</td>
            <td>القسم</td>
            <td>الموظف</td>
            <td>تاريخ تسجيله</td>
        <?php if ($_SESSION['role'] == 2){ ?>
            <td>عدل</td>
            <?php } ?>
        </tr>
        <?php

        $stmt = $con->prepare("SELECT items.*,sections.*,users.* FROM items 
                                        INNER JOIN sections ON sec_id = sectionid
                                        INNER JOIN  users ON user_id = userid
                                        ORDER BY item_id DESC");
        $stmt->execute();
        $items=$stmt->fetchAll();
        foreach ($items as $item)
        {
            echo '<tr>';
            echo '<td>'.$item['item_name'].'</td>';
            echo '<td>'.$item['item_desc'].'</td>';
            echo '<td>'.$item['buyprice'].'</td>';
            echo '<td>'.$item['sellprice'].'</td>';
            echo '<td>'.$item['sec_name'].'</td>';
            echo '<td>'.$item['user_name'].'</td>';
            echo '<td>'.$item['item_date'].'</td>';
            if ($_SESSION['role'] == 2){
            echo '<td>';
            ?>
            <a href="../admin/items.php?do=edit&&id=<?php echo $item['item_id']; ?>" class="btn btn-primary"><i class="fa fa-edit "></i>تعديل</a>
            <?php
            echo '</td>';}
            echo '</tr>';
        }
    }elseif ($do == 'add')
    {
        ?>
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="page-header">اضافة صنف جديد</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form action="../admin/items.php?do=insert" method="post">
                    <div class="form-group">
                        <label> اسم الصنف</label>
                        <input type="text" name="item_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>وصف الصنف</label>
                        <textarea name="item_desc" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>سعر الشراء</label>
                        <input type="text" name="buyprice" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>سعر البيع</label>
                        <input type="text" name="sellprice" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>القسم</label>
                        <select name="sectionid" class="form-control">
                            <?php
                            $sections =getAllFrom('*','sections','','','sec_id');
                            foreach ($sections as $section)
                            {?>
                                <option value="<?php echo $section['sec_id'] ?>"><?php echo $section['sec_name'] ?></option >
                                <?php  } ?>
                        </select>
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
            $item_name = $_POST['item_name'];
            $item_desc = $_POST['item_desc'];
            $buy       = $_POST['buyprice'];
            $sell      = $_POST['sellprice'];
            $sectionid = $_POST['sectionid'];
            $userid    = $_SESSION['userid'];

            if (!empty($item_name)&&!empty($sectionid)&&!empty($buy)&&!empty($sell))
            {
                $stmt = $con->prepare("INSERT INTO items(item_name,item_desc,buyprice,sellprice,sectionid,userid,item_date)
                                          VALUES(:item_name,:item_desc,:buyprice,:sellprice,:sectionid,:userid,now())");
                $stmt->execute([
                    'item_name'=> $item_name,
                    'item_desc'=> $item_desc,
                    'buyprice' => $buy,
                    'sellprice'=> $sell,
                    'sectionid'=> $sectionid,
                    'userid'   => $userid
                    ]);
                echo '<div class="alert alert-success">تم تسجيل الصنف بنجاح'.$stmt->rowCount().'</div>';

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
    }elseif ($do == 'edit')
    {
        $stmt = $con->prepare("SELECT items.*,sections.*,users.* FROM items 
                                        INNER JOIN sections ON sec_id = sectionid
                                        INNER JOIN  users ON user_id = userid
                                        WHERE item_id =?");
        $stmt->execute([$_GET['id']]);
        $item=$stmt->fetch();
        ?>
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="page-header">تعديل بيانات الصنف</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form action="../admin/items.php?do=update&&id=<?php echo $item['item_id']; ?>" method="post">
                    <div class="form-group">
                        <label> اسم الصنف</label>
                        <input type="text" name="item_name" class="form-control" value="<?php echo $item['item_name']; ?>">
                    </div>
                    <div class="form-group">
                        <label>وصف الصنف</label>
                        <textarea name="item_desc" class="form-control" rows="3"><?php echo $item['item_desc']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>سعر الشراء</label>
                        <input type="text" name="buyprice" class="form-control" value="<?php echo $item['buyprice']; ?>">
                    </div>
                    <div class="form-group">
                        <label>سعر البيع</label>
                        <input type="text" name="sellprice" class="form-control" value="<?php echo $item['sellprice']; ?>">
                    </div>
                    <div class="form-group">
                        <label>القسم</label>
                        <select name="sectionid" class="form-control">
                            <option value="<?php echo $item['sectionid']; ?>"><?php echo $item['sec_name']; ?></option>
                            <?php
                            $sections =getAllFrom('*','sections','','','sec_id');
                            foreach ($sections as $section)
                            {?>
                                <option value="<?php echo $section['sec_id'] ?>"><?php echo $section['sec_name'] ?></option >
                            <?php  } ?>
                        </select>
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
            $item_name = $_POST['item_name'];
            $item_desc = $_POST['item_desc'];
            $buy       = $_POST['buyprice'];
            $sell      = $_POST['sellprice'];
            $sectionid = $_POST['sectionid'];
            $userid    = $_SESSION['userid'];
            $stmt = $con->prepare("UPDATE items SET item_name=?,item_desc=?,buyprice=?,sellprice=?,sectionid=?,userid=? WHERE item_id =?");
            $stmt->execute([$item_name,$item_desc,$buy,$sell,$sectionid,$userid,$id]);
            echo '<div class="alert alert-success">تم التعديل بنجاح'.$stmt->rowCount().'</div>';
        }else
        {
            $msg= '<div class="alert alert-danger">ليس لك الحق في الدخول لهذه الصفحة</div>';
            redirectHome($msg);
            exit();
        }
    }elseif ($do == 'delete')
    {
        if (isset($_GET['id'])&&is_numeric($_GET['id']))
        {
            $id = $_GET['id'];
            $stmt = $con->prepare("DELETE FROM items WHERE item_id=?");
            $stmt->execute([$id]);
            echo '<div class="alert alert-success">تم حذف القسم بنجاح'.$stmt->rowCount().'</div>';
        }
    }
}
?>
    </table>
    </div>
<?php require 'temp/footer.php'; ?>