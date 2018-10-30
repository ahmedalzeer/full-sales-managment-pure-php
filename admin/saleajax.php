<?php
session_start();
require 'congif.php';
if(!isset($_SESSION['username']))
{
    header('location:../index.php');
    exit();
}else {
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $output = '';

    $q = $_POST['search'];
    $stmt = $con->prepare("SELECT * FROM items WHERE item_name like '%$q%' LIMIT 10");
    $stmt->execute();
    $row = $stmt->rowCount();
    $results = $stmt->fetchAll();

    echo json_encode($results);
}else
{
    $msg = '<div>ليس لك الحق في الدخول للصفحة المطلوبة</div>';
    redirectHome($msg);
    exit();
}
}

?>
