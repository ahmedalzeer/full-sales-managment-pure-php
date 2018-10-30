<?php
    session_start();
    if(!isset($_SESSION['username']))
    {
        header('location:../index.php');
        exit();
    }else
        {
            require 'init.php';
        }
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-md-8">
            <h1 class="page-header">الإحصائيات</h1>
        </div>
        <div class="col-md-4 form-group">
            <label>الصنف</label>
            <input type="text" id="searchdash" class="form-control">
            <ul class="col-md-12 form-group" id="live_dashdata">
            </ul>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div id="countsdiv" class="row">
        <div class="col-lg-6 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <div class="huge"><?php echo countItems('sec_name', 'sections');?></div>
                            <div>الاقسام</div>
                        </div>
                    </div>
                </div>
                <a href="../admin/sections.php?do=manage">
                    <div class="panel-footer">
                        <span class="pull-left">المزيد </span>
                        <span class="pull-right"><i class="fa fa-spinner fa-spin fa-fw"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-cubes fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <div class="huge"><?php echo countItems('item_name', 'items');?></div>
                            <div>الاصناف</div>
                        </div>
                    </div>
                </div>
                <a href="../admin/items.php?do=manage">
                    <div class="panel-footer">
                        <span class="pull-left">المزيد</span>
                        <span class="pull-right"><i class="fa fa-spinner fa-spin fa-fw"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-users fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <div class="huge"><?php echo countItems('user_name', 'users');?></div>
                            <div>الموظفين</div>
                        </div>
                    </div>
                </div>
                <a href="../admin/users.php?do=manage">
                    <div class="panel-footer">
                        <span class="pull-left">المزيد</span>
                        <span class="pull-right"><i class="fa fa-spinner fa-spin fa-fw"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-support fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <div class="huge"><?php echo countItems('buy_sub', 'buyitems');?></div>
                            <div>المشتروات</div>
                        </div>
                    </div>
                </div>
                <a href="../admin/import.php?do=manage">
                    <div class="panel-footer">
                        <span class="pull-left">المزيد</span>
                        <span class="pull-right"><i class="fa fa-spinner fa-spin fa-fw"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-shopping-cart fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <div class="huge"><?php echo countItems('sale_cus', 'sales');?></div>
                            <div>المبيعات</div>
                        </div>
                    </div>
                </div>
                <a href="../admin/sales.php?do=manage">
                    <div class="panel-footer">
                        <span class="pull-left">المزيد</span>
                        <span class="pull-right"><i class="fa fa-spinner fa-spin fa-fw"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- /.row -->
</div>

<?php require 'temp/footer.php'; ?>