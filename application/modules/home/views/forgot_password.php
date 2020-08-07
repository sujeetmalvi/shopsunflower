<br><br><br><br>
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
           
            <h3>Welcome to <?php echo SITE_TITLE; ?> Forgot Password</h3>
             <h5 style="color:red"><?php echo (isset($error_msg))?$error_msg:'';?></h5>
            <form class="form-horizontal form-material" id="form_forgot_password_mobile" method="POST" action="javascript:;"> <?php //echo site_url('employees/reset_password');?>
                <div class="form-group">
                    <input type="password" id="employeespassword" name="employeespassword" class="form-control" placeholder="New Password" required="">
                </div>
                <div class="form-group">
                    <input type="password" id="confemployeespassword" name="confemployeespassword" class="form-control" placeholder="Confirm Password" required="">
                </div>
                <input type="hidden" name="<?=$csrfName;?>" value="<?=$csrfHash;?>" />
                <input type="hidden" id="EmployeesId" name="EmployeesId" value="<?=$EmployeesId;?>" />
                <button type="submit"  class="btn btn-primary block full-width m-b">Submit</button>
            </form>
        </div>
    </div>
