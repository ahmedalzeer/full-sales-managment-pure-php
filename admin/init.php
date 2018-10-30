<?php
ob_start();
system('ipconfig /all');
$mycom=ob_get_contents();
ob_clean();
$findme = "Physical";
$pmac = strpos($mycom, $findme);
$mac = substr($mycom,($pmac+36),17);

if ($mac =='78-AC-C0-9B-DD-B7')
{
    require 'congif.php';
    require 'temp/header.php';
    require 'functions/function.php';
}else
{
    echo '<center>ليس لك الحق في استخدام هذا البرنامج الرجاء الاتصال علي 01015258850</center>';
}


