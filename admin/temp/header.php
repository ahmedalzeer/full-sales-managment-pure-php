<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>لوحة التحكم</title>

    <!-- Bootstrap Core CSS -->
    <link href="../layouts/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../layouts/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../layouts/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="../layouts/mystyle.css" rel="stylesheet" type="text/css">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">لوحة التحكم</a>
        </div>
        <ul class="nav navbar-top-links navbar-left">
            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <?php echo $_SESSION['username']; ?>  <i class="fa fa-user fa-fw blue"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="../admin/logout.php"><i class="fa fa-power-off red fa-fw"></i> تسجيل الخروج</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <ul class="nav navbar-top-links navbar-left">
            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    التبيهات  <i class="fa fa-warning fa-fw red"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <?php
                    $stmt = $con->prepare("SELECT * FROM items");
                    $stmt->execute();
                    $items = $stmt->fetchAll();
                    foreach ($items as $item)
                    {
                        $mount = $item['stay_mount']-$item['sell_mount'];
                        if ($mount <=5)
                        {
                            echo'<li> '.$item['item_name'].' <strong> متبقي '.$mount.'</strong></li><br>';
                        }
                    }
                    ?>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->
        <div id="navbar" class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a id="result" class="text-center" href="#">
                            <script>
                                days = new Array('السبت','الاحد','الاثنين','الثلاثاء','الاريعاء','الخميس','الجمعه');
                                function showdate(){

                                    var date = new Date();
                                    var today = date.getDay()-1;
                                    var day = days[today];
                                    var yom = date.getDate();
                                    var month = date.getMonth()+1;
                                    var year = date.getFullYear();
                                    var h = date.getHours();
                                    var m = date.getMinutes();
                                    var s = date.getSeconds();
                                    var form ='';
                                    form +=yom+'-'+month+'-'+year+'<br/>';
                                    form +=date.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric' ,second: 'numeric', hour12: true });
                                    document.getElementById('result').innerHTML =form;
                                }
                                setInterval('showdate()',1000);
                            </script>
                        </a>
                    </li>
                    <li>
                        <a class="active" href="../admin/dashboard.php"><i class="fa fa-dashboard fa-fw green"></i> الإحصائيات</a>
                    </li>
                    <?php if ($_SESSION['role'] == 2){ ?>
                    <li>
                        <a href="#"><i class="fa fa-users fa-fw"></i>الموظفين<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="../admin/users.php?do=add">أضف موظف جديد</a>
                            </li>
                            <li>
                                <a href="../admin/users.php?do=manage">استعرض الموظفين</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>
                    <li>
                        <a href="#"><i class="fa fa-tasks fa-fw red"></i> الأقسام<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="../admin/sections.php?do=add">أضف قسم جديد</a>
                            </li>
                            <li>
                                <a href="../admin/sections.php?do=manage">استعرض جميع الأقسام</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-cubes fa-fw purple"></i><span class="fa arrow"></span>الاصناف</a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="../admin/items.php?do=add">أضف صنف جديد</a>
                            </li>
                            <li>
                                <a href="../admin/items.php?do=manage">استعرض الاصناف</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="../admin/sales.php?do=add"><i class="fa fa-shopping-cart fa-fw pink"></i>المبيعات</a>
                    </li>
                    <li>
                        <a href="../admin/import.php?do=add"><i class="fa fa-support fa-fw teal " ></i>المشتروات</a>
                    </li>
                    <li>
                        <a href="../admin/Inventory.php?do=manage"><i class="fa fa-archive fa-fw"></i>المخزون</a>
                    </li>
                    <li>
                        <a href="forms.html"><i class="fa fa-files-o fa-fw orange"></i><span class="fa arrow"></span>التقارير</a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="../admin/sales.php?do=manage">تقارير المبيعات</a>
                            </li>
                            <li>
                                <a href="../admin/import.php?do=manage">تقارير المشتروات</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <br><br><br><br>
                <li>
                    <div >Developed BY Ahmed ALzeer</div>
                </li>
                <li>
                    <div >برمجة م/احمد الزير</div>
                </li>
                <li>
                    <div >01015258850</div>
                </li>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
    </nav>

