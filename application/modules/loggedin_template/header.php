<?php

if (!isset($_SESSION['user_id'])){
    redirect(site_url());
}

$csrf = array(
    'name' => $this->security->get_csrf_token_name(),
    'hash' => $this->security->get_csrf_hash()
);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML Basic 1.1//EN"  "http://www.w3.org/TR/xhtml-basic/xhtml-basic11.dtd">
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_TITLE; ?></title>
    <link rel="icon" href="<?php echo base_url('');?>">
    <script type="text/javascript"> var BASE_URL = "<?php echo base_url();?>"; </script>
    <script type="text/javascript"> var SITE_URL = "<?php echo site_url(); ?>"; </script>
    <link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/font-awesome/css/font-awesome.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/iCheck/custom.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/steps/jquery.steps.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/animate.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/style.css');?>" rel="stylesheet">
<!--     <?php /*
    if(isset($css_custom)){
        foreach($css_custom as $css){?>
    <link href="<?php echo base_url($css);?>">
    <?php } } */?> -->

    <link href="<?php echo base_url('assets/css/plugins/chosen/bootstrap-chosen.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/colorpicker/bootstrap-colorpicker.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/cropper/cropper.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/switchery/switchery.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/jasny/jasny-bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/nouslider/jquery.nouislider.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/datapicker/datepicker3.css');?>" rel="stylesheet"> 
    <link href="<?php echo base_url('assets/css/plugins/ionRangeSlider/ion.rangeSlider.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/clockpicker/clockpicker.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/daterangepicker/daterangepicker-bs3.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/select2/select2.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/dualListbox/bootstrap-duallistbox.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/dataTables/datatables.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/alertify/alertify.core.css');?>" rel="stylesheet">   
    <link href="<?php echo base_url('assets/css/plugins/dataTables/jquery.dataTables.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/dataTables/select.dataTables.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/alertify/alertify.default.css');?>" rel="stylesheet"><!-- alertify.bootstrap.css -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="<?php echo base_url('assets/js/jquery-2.1.1.js');?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
    <style>
        .wizard > .content > .body { position: relative; }
        .select2-container--open{
        z-index:9999999
        }

    </style>
</head>
<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <div style='padding:6px;'>
                    <img alt="image" class="img-responsive" src="<?php echo base_url('assets/img/logo.jpg');?>" style='border:1px solid #ffffff; padding:2px;border-radius:10px;' />
                </div>
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> 
                        <span>
                            <img alt="image" class="img-circle" src="<?php echo base_url('assets/img/profile_small.jpg');?>" />
                        </span>
                        </div>
                        <div class="logo-element">SF</div>
                    </li>
                    <?php if($_SESSION['user_role'] == 'admin'){?>
                    <li>
                        <a href="<?php echo site_url('superadmin/dashboard');?>"><i class="fa fa-th-large"></i><span class="nav-label">Dashboards</span></a>
                    </li>
                    <?php } ?>
                    <!--<li  class="active">
                        <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Master</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="<?php echo site_url('productcategory');?>">Product Category</a></li>
                            <li><a href="<?php echo site_url('product');?>">Product</a></li>
                            <li><a href="<?php echo site_url('productstock');?>">Product Stock</a></li>
                            <li><a href="<?php echo site_url('shop');?>">Shop</a></li>
                            <li><a href="<?php echo site_url('colour');?>">Colour</a></li>
                            <li><a href="<?php echo site_url('size');?>">Size</a></li>
                            <li><a href="<?php echo site_url('user');?>">User</a></li>
                        </ul>
                    </li>-->
                    <li><a href="<?php echo site_url('productcategory');?>"><i class="fa fa-th-large"></i><span class="nav-label">Product Category</span></a></li>
                    <li><a href="<?php echo site_url('product');?>"><i class="fa fa-th-large"></i><span class="nav-label">Product</span></a></li>
                    <li><a href="<?php echo site_url('productstock');?>"><i class="fa fa-th-large"></i><span class="nav-label">Product Stock</span></a></li>
                    <li><a href="<?php echo site_url('shop');?>"><i class="fa fa-th-large"></i><span class="nav-label">Shop</span></a></li>
                    <li><a href="<?php echo site_url('colour');?>"><i class="fa fa-th-large"></i><span class="nav-label">Colour</span></a></li>
                    <li><a href="<?php echo site_url('size');?>"><i class="fa fa-th-large"></i><span class="nav-label">Size</span></a></li>
                    <li><a href="<?php echo site_url('user');?>"><i class="fa fa-th-large"></i><span class="nav-label">User</span></a></li>
                    <li><a href="<?php echo site_url('orders/orders_list');?>"><i class="fa fa-th-large"></i><span class="nav-label">New Orders List</span></a></li>
                    <li><a href="<?php echo site_url('orders/orders_list_cancelled');?>"><i class="fa fa-th-large"></i><span class="nav-label">Cancelled Orders List</span></a></li>
                    <li><a href="<?php echo site_url('orders/orders_list_dispatched');?>"><i class="fa fa-th-large"></i><span class="nav-label">Dispatched Orders List</span></a></li>
                    <li><a href="<?php echo site_url('orders/orders_dispatch');?>"><i class="fa fa-th-large"></i><span class="nav-label">Dispatch Orders</span></a></li>
                        </ul>
                    </div>
                </nav>
                <div id="page-wrapper" class="gray-bg">
                    <div class="row border-bottom">
                        <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                            <div class="navbar-header">
                                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                                <!-- <a class="minimalize-styl-2 btn btn-primary" href="<?php //echo site_url('pos/pos_orders_add'); ?>">POS</a> -->
            <!-- <form role="search" class="navbar-form-custom" action="http://webapplayers.com/inspinia_admin-v2.6/search_results.html">
                <div class="form-group">
                    <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                </div>
            </form> -->
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <span class="m-r-sm text-muted welcome-message">Welcome, <?php  echo $this->session->userdata('user_role');?> .</span>
            </li>
                <li>
                    
                    <?php $login = $this->uri->segment(1); ?>
                   <a href="<?php echo site_url('login/logout/'.$login);?>">
                       <i class="fa fa-sign-out"></i> Log out
                   </a>
               
                </li>
                <li>
                    <a class="right-sidebar-toggle">
                        <i class="fa fa-tasks"></i>
                    </a>
                </li>
            </ul>

        </nav>
    </div>