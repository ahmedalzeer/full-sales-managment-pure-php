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
                <h1 class="page-header">تقارير المشتروات</h1>
            </div>

        </div>

        <div class="row">
        <div class="table-responsive">
        <table class="main-table manage-members text-center table table-bordered">
        <tr>
            <td>م الفاتورة</td>
            <td>المدفوع</td>
            <td>المتبقي</td>
            <td>المورد</td>
            <td>الموظف</td>
            <td>التاريخ</td>
        </tr>
        <?php

        $stmt = $con->prepare(" SELECT buyitems.*,users.* FROM buyitems
                                        INNER JOIN users ON user_id = buy_user
                                        ORDER BY buy_id DESC");
        $stmt->execute();
        $sales=$stmt->fetchAll();
        foreach ($sales as $sale)
        {
            echo '<tr>';
            echo '<td><a href="../admin/printbuy.php?buyid='.$sale['buy_id'].'">'.$sale['buy_id'].'</a></td>';
            echo '<td>'.$sale['buy_price'].'</td>';
            echo '<td>'.$sale['buy_stayprice'].'</td>';
            echo '<td>'.$sale['buy_sub'].'</td>';
            echo '<td>'.$sale['user_name'].'</td>';
            echo '<td>'.$sale['buy_date'].'</td>';
            echo '</tr>';
        }
    }
    elseif ($do == 'add')
    {
        ?>

        <div class="row">
            <div class="col-md-8 text-center">
                <h1 class="page-header">فاتورة مشتروات</h1>
            </div>
            <div class="col-md-4 form-group">
                <label>الصنف</label>
                <input type="text" id="buysearchinput" class="form-control">
                <div class="col-md-12 form-group" id="buylive_data">
                </div>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div id="div2" class="col-md-12">
                <form id="buyform_sale" dir="rtl" action="../admin/import.php?do=insert" method="post">
                    <div class="col-md-6 form-group">
                        <label> اسم المورد</label>
                        <input type="text" name="sub_name" class="form-control">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>موبيل المورد</label>
                        <input type="text" name="subphone" class="form-control">
                    </div>
                    <div  class="col-md-12 form-group">
                        <table id="buyform_item">
                        </table>
                    </div>
                    <div class="col-md-4 form-group">
                        <label id="buytotalres" class="btn btn-default btn-sm" >الاجمالي</label>
                        <input id="buyfullprice" type="text" name="totalbuy_price" class="form-control">
                    </div>
                    <div class="col-md-4 form-group">
                        <label style="margin-bottom: 9px;">المدفوع</label>
                        <input id="buypaymount" type="text" name="buypaidmount" class="form-control">
                    </div>
                    <div class="col-md-4 form-group">
                        <label style="margin-bottom: 9px;">المتبقي</label>
                        <input id="buystaymount" type="text" name="buystaymount" class="form-control">
                    </div>
                    <button type="submit" class="col-md-12 btn btn-success" id="btn_insert">حفظ</button>
                </form>
            </div>
        </div>
        <div id="test1"></div>

        <?php

    }elseif ($do == 'insert')
    {
        if ($_SERVER['REQUEST_METHOD']=='POST')
        {
            $sub_name      = $_POST['sub_name'];
            $subphone      = $_POST['subphone'];
            $total_price   = $_POST['totalbuy_price'];
            $paidmount     = $_POST['buypaidmount'];
            $staymount     = $_POST['buystaymount'];
            $userid        = $_SESSION['userid'];

            if (!empty($sub_name)&&!empty($total_price))
            {
                $stmt = $con->prepare("INSERT INTO buyitems(buy_user,buy_stayprice,buy_price ,buy_sub,buy_subphone,buy_date)
                                          VALUES(:buy_user,:buy_stayprice,:buy_price,:buy_sub,:buy_subphone,now())");
                $stmt->execute([
                    'buy_user'     => $userid,
                    'buy_stayprice'=> $staymount,
                    'buy_price'    => $paidmount,
                    'buy_sub'      => $sub_name,
                    'buy_subphone' => $subphone
                ]);

                $buy_id=$con->lastInsertId();
                $item_idid = $_POST['i'];
                $mount=$_POST['buyprice'];
                foreach(array_combine($item_idid, $mount) as $d1 => $d2)
                {
                    $stmt = $con->prepare("INSERT INTO buysitems(buy_idid,item_ididbuy,item_mountbuy)
                                          VALUES(:buy_idid,:item_ididbuy,:item_mountbuy)");
                    $stmt->execute([
                        'buy_idid' => $buy_id,
                        'item_ididbuy' => $d1,
                        'item_mountbuy'=> $d2
                    ]);
                    $stmtt =$con->prepare("SELECT * FROM items WHERE item_id = ?");
                    $stmtt->execute([$d1]);
                    $sellmount = $stmtt->fetch();
                    $mountres = $sellmount['stay_mount'] + $d2;
                    $stmttt= $con->prepare("UPDATE items SET stay_mount=? WHERE item_id =?");

                    $stmttt->execute([$mountres,$d1]);
                }

                echo '<div class="alert alert-success">تم تسجيل الفاتورة بنجاح'.$stmt->rowCount().'</div>';
                header('refresh:2;url=../admin/printbuy.php?buyid='.$buy_id);
            }else
            {
                $msg = '<div class="alert alert-danger">تحقق من المدخلات</div>';
                redirectHome($msg,'back');
            }
        }else
        {
            $msg = '<div class="alert alert-danger">ليس لك الحق في الدخول لهذه الصفحة</div>';
            redirectHome($msg);
            exit();
        }
    }
}
?>
    </table>
    </div>
<?php require 'temp/footer.php'; ?>