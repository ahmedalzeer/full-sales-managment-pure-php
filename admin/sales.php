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
                <h1 class="page-header">تقارير المبيعات</h1>
            </div>

        </div>

        <div class="row">
        <div class="table-responsive">
        <table class="main-table manage-members text-center table table-bordered">
        <tr>
            <td>م الفاتورة</td>
            <td>المدفوع</td>
            <td>المتبقي</td>
            <td>العميل</td>
            <td>الموظف</td>
            <td>التاريخ</td>
        </tr>
<?php

        $stmt = $con->prepare(" SELECT sales.*,users.* FROM sales
                                        INNER JOIN users ON user_id = sale_user
                                        ORDER BY sale_id DESC");
        $stmt->execute();
        $sales=$stmt->fetchAll();
        foreach ($sales as $sale)
        {
            echo '<tr>';
            echo '<td><a  href="../admin/printsales.php?saleid='.$sale['sale_id'].'">'.$sale['sale_id'].'</a></td>';
            echo '<td>'.$sale['sale_price'].'</td>';
            echo '<td>'.$sale['sale_stayprice'].'</td>';
            echo '<td>'.$sale['sale_cus'].'</td>';
            echo '<td>'.$sale['user_name'].'</td>';
            echo '<td>'.$sale['sale_date'].'</td>';
            echo '</tr>';
        }
    }
    elseif ($do == 'add')
    {
        ?>

        <div class="row">
            <div class="col-md-8 text-center">
                <h1 class="page-header">فاتورة مبيعات</h1>
            </div>
            <div class="col-md-4 form-group">
                <label>الصنف</label>
                <input type="text" id="searchinput" on="takevalue()" class="form-control">
                <div class="col-md-12 form-group" id="live_data">
                </div>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div id="div2" class="col-md-12">
                <form id="form_sale" dir="rtl" action="../admin/sales.php?do=insert" method="post">
                    <div class="col-md-6 form-group">
                        <label> اسم العميل</label>
                        <input type="text" name="cus_name" class="form-control">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>موبيل العميل</label>
                        <input type="text" name="cusphone" class="form-control">
                    </div>
                    <div  class="col-md-12 form-group">
                        <table id="form_item">
                        </table>
                    </div>
                    <div class="col-md-4 form-group">
                        <label id="totalres" class="btn btn-default btn-sm" >الاجمالي</label>
                        <input id="fullprice" type="text" name="total_price" class="form-control">
                    </div>
                    <div class="col-md-4 form-group">
                        <label style="margin-bottom: 9px;">المدفوع</label>
                        <input id="paymount" type="text" name="paidmount" class="form-control">
                    </div>
                    <div class="col-md-4 form-group">
                        <label style="margin-bottom: 9px;">المتبقي</label>
                        <input id="staymount" type="text" name="staymount" class="form-control">
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
            $cus_name      = $_POST['cus_name'];
            $cusphone      = $_POST['cusphone'];
            $total_price   = $_POST['total_price'];
            $paidmount     = $_POST['paidmount'];
            $staymount     = $_POST['staymount'];
            $userid        = $_SESSION['userid'];

            if (!empty($cus_name)&&!empty($total_price))
            {
                $stmt = $con->prepare("INSERT INTO sales(sale_user,sale_stayprice,sale_price ,sale_cus,sale_cusphone,sale_date)
                                          VALUES(:sale_user,:sale_stayprice,:sale_price,:sale_cus,:sale_cusphone,now())");
                $stmt->execute([
                    'sale_user'     => $userid,
                    'sale_stayprice'=> $staymount,
                    'sale_price'    => $paidmount,
                    'sale_cus'      => $cus_name,
                    'sale_cusphone' => $cusphone
                ]);

                $sale_id=$con->lastInsertId();
                $item_idid = $_POST['i'];
                $mount=$_POST['buyprice'];
            foreach(array_combine($item_idid, $mount) as $d1 => $d2)
            {
                $stmt = $con->prepare("INSERT INTO salesitems(sale_idid,item_idid,item_mount)
                                          VALUES(:sale_idid,:item_idid,:item_mount)");
                        $stmt->execute([
                            'sale_idid' => $sale_id,
                            'item_idid' => $d1,
                            'item_mount'=> $d2
                          ]);
                $stmtt =$con->prepare("SELECT * FROM items WHERE item_id = ?");
                $stmtt->execute([$d1]);
                $sellmount = $stmtt->fetch();
                $mountres = $sellmount['sell_mount'] + $d2;
                $stmttt= $con->prepare("UPDATE items SET sell_mount=? WHERE item_id =?");

                $stmttt->execute([$mountres,$d1]);
            }

                echo '<div class="alert alert-success">تم تسجيل الفاتورة بنجاح'.$stmt->rowCount().'</div>';
//                header('refresh:2;url=../admin/printsales.php?saleid='.$sale_id);
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
    }
}
?>
    </table>
    </div>
<?php require 'temp/footer.php'; ?>