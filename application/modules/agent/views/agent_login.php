<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_TITLE; ?></title>
    <link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/font-awesome/css/font-awesome.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/animate.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/style.css');?>" rel="stylesheet">

<?php
$csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
); ?>
	</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <h3 class="logo-name"><?php echo LOGIN_PAGE_TITLE; ?></h3>
            </div>
            <!-- <p>Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.
            </p> -->
            <h5> Retailer Login</h5>
             <h5 style="color:red"><?php echo (isset($error_msg))?$error_msg:'';?></h5>
            <form class="form-horizontal form-material" id="loginform" method="POST" action="<?php echo site_url('agent/agent/agent_login');?>">
                <div class="form-group">
                    <input type="email" name="loginname" class="form-control" placeholder="Username" required="" value="agent@admin.com">
                </div>
                <div class="form-group">
                    <input type="password" name="loginpassword" class="form-control" placeholder="Password" required="" value="123456">
                </div>
                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                <!-- <a href="#"><small>Forgot password?</small></a>
                <p class="text-muted text-center"><small>Do not have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a> -->
            </form>
            <p class="m-t"> <small><?php echo COPYRIGHT_TEXT; ?></small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?php echo base_url('assets/js/jquery-2.1.1.js');?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>

</body>
</html>
