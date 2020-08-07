<?php
if (!isset($_SESSION['user_id'])){
    redirect(site_url('agent'));
}
$csrf = array(
    'name' => $this->security->get_csrf_token_name(),
    'hash' => $this->security->get_csrf_hash()
);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML Basic 1.1//EN"
    "http://www.w3.org/TR/xhtml-basic/xhtml-basic11.dtd">
<!-- <!DOCTYPE html> -->
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_TITLE; ?></title>
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
    <link href="<?php echo base_url('assets/css/plugins/alertify/alertify.default.css');?>" rel="stylesheet">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    
    <style>
        .wizard > .content > .body { position: relative; }
    </style>
</head>
<body class="pace-done mini-navbar">
    <div id="wrapper">
        <!-- <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> 
                        <span>
                            <img alt="image" class="img-circle" src="<?php //echo base_url('assets/img/profile_small.jpg');?>" />
                        </span>
                        </div>
                        <div class="logo-element">
                            SD
                        </div>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Customer</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                             <li><a href="<?php //echo site_url('customer/customer_list');?>">Customer List</a></li>

                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Agents</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="<?php // echo site_url('agent/agent_list');?>">Agent list</a></li>

                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">POS</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="<?php //echo site_url('pos/pos_orders_add');?>">Add Order</a></li>
                            <li><a href="<?php //echo site_url('pos/pos_orders_list');?>">Order List</a></li>
                            <li><a href="<?php //echo site_url('pos/pos_orders_return_add');?>">Order Return</a></li>

                        </ul>
                    </li>
                   
                        </ul>
                    </div>
                </nav> -->
                <div id="page-wrapper" class="" style="margin:0px !important;background: #999999 !important;">
                    <div class="row border-bottom">
                        <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                            <div class="navbar-header">
                                <!-- <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a> -->
                                <a class="btn btn-xs btn-primary " href="<?php echo site_url('agent/agent_dashboard');?>" style="margin-top:20px;margin-left:20px;"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a>

                                <a class="btn btn-xs btn-warning " href="<?php echo site_url('pos/pos_orders_list');?>"  style="margin-top:20px;margin-left:20px;"><i class="fa fa-list" aria-hidden="true"></i> Order List </a>
                                
                                <a class="btn btn-xs btn-warning " href="#"  style="margin-top:20px;margin-left:20px;" data-toggle="modal" data-target="#calculator"><i class="fa fa-calculator"  aria-hidden="true"></i> Calculator</a>

                                <button class="btn btn-outline btn-primary" style="margin-top:20px;margin-left:20px;"> Today's Profit:(₹) <span id="todaysprofit">0.00</span></button>

                                
                                
                                <!-- <a class="btn btn-xs btn-info " href="#"  style="margin-top:20px;margin-left:20px;"><i class="fa fa-slack" aria-hidden="true" ></i> Orders on Hold</a> -->


                                
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
                 <!--<li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="<?php // echo base_url('assets/img/a7.jpg');?>">
                                </a>
                                <div>
                                    <small class="pull-right">46h ago</small>
                                    <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="<?php // echo base_url('assets/img/a4.jpg');?>">
                                </a>
                                <div>
                                    <small class="pull-right text-navy">5h ago</small>
                                    <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="<?php // echo base_url('assets/img/profile.jpg');?>">
                                </a>
                                <div>
                                    <small class="pull-right">23h ago</small>
                                    <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                    <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="mailbox.html">
                                    <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li> -->
                 <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="mailbox.html">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="profile.html">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="grid_options.html">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="notifications.html">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li> 


                <li>
                    
                   <a href="<?php echo site_url('login/logout');?>">
                       <i class="fa fa-sign-out"></i> Log out
                   </a>
                    <!-- <a href="javascript:;" data-toggle="modal" data-target="#closingcashmodal">
                        <i class="fa fa-sign-out"></i> Log out
                    </a> -->
                </li>
                <li>
                    <a class="right-sidebar-toggle">
                        <i class="fa fa-tasks"></i>
                    </a>
                </li>
            </ul>

        </nav>
    </div>