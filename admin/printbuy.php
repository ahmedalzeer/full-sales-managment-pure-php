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
if (isset($_GET['buyid']))
{
    require 'congif.php';

    $buyid = $_GET['buyid'];
    $stmt= $con->prepare(" SELECT buyitems.*,buysitems.*,items.* FROM buysitems
                                    LEFT JOIN buyitems ON buyitems.buy_id = buy_idid
                                    INNER JOIN items ON item_id = item_ididbuy
                                    JOIN users ON user_id = buyitems.buy_user
                                    WHERE buy_idid = ? ");
    $stmt->execute([$buyid]);
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
                    <td>'.$sa['item_mountbuy'].'</td>
                    <td>'.$sa['sellprice']*$sa['item_mountbuy'].'</td>
                </tr>';
        $thead ='<table dir="rtl"><tr class="header">
                    <td>اسم المورد</td>
                    <td>موبيل المورد</td>
                </tr>
                 <tr>
                    <td>'.$sa['buy_sub'].'</td>
                    <td>'.$sa['buy_subphone'].'</td>
                </tr></table>';
        $tfooter='<table dir="rtl"><tr class="header">
                    <td>المدفوع</td>
                    <td>المتبقي</td>
                    <td>التاريخ</td>
                </tr>
                <tr>
                    <td>'.$sa['buy_price'].'</td>
                    <td>'.$sa['buy_stayprice'].'</td>
                    <td>'.$sa['buy_date'].'</td>
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