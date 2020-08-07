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
    <script type="text/javascript"> var BASE_URL = "<?php echo base_url();?>"; </script>
    <script type="text/javascript"> var SITE_URL = "<?php echo site_url(); ?>"; </script>
     <link href="<?php echo base_url('assets/css/plugins/alertify/alertify.core.css');?>" rel="stylesheet"> 
    <link href="<?php echo base_url('assets/css/plugins/alertify/alertify.default.css');?>" rel="stylesheet">

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
                <h3 class="logo-name"><?php echo 'Forget Password'; ?></h3>
            </div>          
            <h5> Forget Password Request</h5>
             <h5 style="color:red"><?php echo (isset($error_msg))?$error_msg:'';?></h5>
            <form class="form-horizontal form-material" id="forgetpasswordform" method="POST" action="javascript:;">
                <div class="form-group">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" required="" value="retailer@admin.com">
                </div>                
                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                <button type="submit" class="btn btn-primary block full-width m-b">Send</button>              	
            </form>           
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?php echo base_url('assets/js/jquery-2.1.1.js');?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/validate/jquery.validate.min.js');?>"></script>
     <script src="<?php echo base_url('assets/js/plugins/alertify/alertify.min.js');?>"></script>
    <?php if(isset($js_script)){?>
    <script src="<?php echo base_url('assets/js/pages/');?><?=$js_script?>.js"></script>
    <?php } ?>

</body>
</html>
