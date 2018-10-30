<?php
session_start();
require 'congif.php';
if(!isset($_SESSION['username']))
{
    header('location:../index.php');
    exit();
}else {
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['item_name'])) {

        $item = $_POST['item_name'];
        $stmt = $con->prepare("SELECT * FROM items WHERE item_name =?");
        $stmt->execute([$item]);
        $results = $stmt->fetchall();

        echo json_encode($results);

    } elseif (isset($_POST['buyww'])) {

        $item = $_POST['buyww'];
        $stmt = $con->prepare("SELECT * FROM items WHERE item_name =?");
        $stmt->execute([$item]);
        $res = $stmt->fetchall();

        echo json_encode($res);

    }
}else
{
    $msg = '<div>ليس لك الحق في الدخول للصفحة المطلوبة</div>';
    redirectHome($msg);
    exit();
}


}


?>



