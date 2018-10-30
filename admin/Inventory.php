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
                <h1 class="page-header">ادارة المخزون</h1>
            </div>

        </div>

        <div class="row">
        <div class="table-responsive">
        <table class="main-table manage-members text-center table table-bordered">
        <tr>
            <td>اسم الصنف</td>
            <td>وصف الصنف</td>
            <td>القسم</td>
            <td>متبقي</td>
            <td>مباع</td>
            <td>تاريخ تسجيله</td>
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
            echo '<td>'.$item['sec_name'].'</td>';
            $realmount = $item['stay_mount']-$item['sell_mount'];
            if ($realmount <= 5){

            echo '<td style="background:red;">'.$realmount.'</td>';
            }else{
                echo '<td>'.$realmount.'</td>';
            }
            echo '<td>'.$item['sell_mount'].'</td>';
            echo '<td>'.$item['item_date'].'</td>';
            echo '</tr>';
        }
    }
}
?>
    </table>
    </div>
<?php require 'temp/footer.php'; ?>