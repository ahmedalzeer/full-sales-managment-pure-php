<?php
ob_start();
session_start();
if(!isset($_SESSION['username']))
{
    header('location:../index.php');
    exit();
}else {
    ?>
    <html>
    <head>
        <title>print pill</title>
    </head>
    <style>
        body{
            margin: 75px 75px 75px;
        }
        table{
            border-collapse:collapse;
            margin: 15px 50px 15px;
            min-width: 500px;
        }
        .header{
           font-size: 16pt;
        }
        .cname{
            font-size: 16pt;

        }
    </style>
    <body dir="rtl">
    <div align="center">
    <div class="cname">شركة(اسم الشركة)</div>
    <?php
if (isset($_GET['saleid']))
{
    require 'congif.php';
    $saleid = $_GET['saleid'];
    $stmt= $con->prepare(" SELECT sales.*,salesitems.*,items.* FROM salesitems
                                    LEFT JOIN sales ON sales.sale_id = sale_idid
                                    INNER JOIN items ON item_id = item_idid
                                    JOIN users ON user_id = sales.sale_user
                                    WHERE sale_idid = ? ");
    $stmt->execute([$saleid]);
    $sal = $stmt->fetchAll();
    echo '<table class="items" border="1" dir="rtl">
                <tr class="header">
                    <td>اسم الصنف</td>
                    <td>الكمية</td>
                    <td>السعر</td>
                </tr>';
    foreach ($sal as $sa)
    {
        echo '
                <tr>
                    <td>'.$sa['item_name'].'</td>
                    <td>'.$sa['item_mount'].'</td>
                    <td>'.$sa['sellprice']*$sa['item_mount'].'</td>
                </tr>';
        $thead ='<table dir="rtl"><tr class="header">
                    <td>اسم العميل</td>
                    <td>موبيل العميل</td>
                </tr>
                 <tr>
                    <td>'.$sa['sale_cus'].'</td>
                    <td>'.$sa['sale_cusphone'].'</td>
                </tr></table>';
        $tfooter='<table dir="rtl"><tr class="header">
                    <td>المدفوع</td>
                    <td>المتبقي</td>
                    <td>التاريخ</td>
                </tr>
                <tr>
                    <td>'.$sa['sale_price'].'</td>
                    <td>'.$sa['sale_stayprice'].'</td>
                    <td>'.$sa['sale_date'].'</td>
                </tr>
            </table>';
    }

    echo $thead;
    echo $tfooter;
    echo '</table>';
}
?>
    <a href="#" onclick="printInvoice()" class="print">print</a>

    </div>
    <script>
        function printInvoice() {
            window.print();
        }
    </script>

    </body>
</html>
<?php } ?>