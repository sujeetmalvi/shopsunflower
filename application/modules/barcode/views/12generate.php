<?php

//require "vendor/autoload.php";

/* if (!$_GET['text']) {
    header("location: index.php");
    die();
} */


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Generate Bar Codes</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <?php if(isset($js_script)){?>
    <script src="<?php echo base_url('assets/js/pages/');?><?=$js_script?>.js"></script>
    <?php } ?>
    <style>
        body, html {
            height: 100%;
        }
        .bg {
            background-image: url("images/bg.jpg");
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        #qrbox>div {
            margin: auto;
        }
        .rotate {

    -webkit-transform: rotate(270deg);
    -webkit-transform-origin: left center;
    -moz-transform: rotate(270deg);
    -moz-transform-origin: left center;
    -ms-transform: rotate(270deg);
    -ms-transform-origin: left center;
    -o-transform: rotate(270deg);
    -o-transform-origin: left center;
    transform: rotate(270deg);
    transform-origin: left center;
    position: absolute;
    top: 0;
    left: 95%;
    margin-top: 20%;
    white-space: nowrap;    
    font-size: 14px;
}
    </style>
</head>
<body class="bg">
    <div class="container" id="panel">
    <input type="button" class="btn btn-primary" onclick="printme('printme') " value="Print">
        <br><br><br>
        <div class="row">
            <div class="col-md-6 offset-md-3" style="background: white; padding: 20px; box-shadow: 1px 10px 5px #888888;" id="printme">
                
                <?php if($BarcodeCount!=''){ }
                else{ 
                $BarcodeCount=1;
                }
                for($i=1;$i<=$BarcodeCount;$i++)
                {?>
                <span class="rotate">
    <?php echo 'B.N: '.$Batch; ?></span>	
     <span class="rotate" style="left: 90%;"><?php echo ' '.$SalesPack; ?></span>	
                <div class="panel-heading" style="text-align:center;">
                	
                    <h5><?php echo $ProductName; ?></h5>
                    <p><?php echo 'DavaIndia MRP Rs. '.$diprice; ?></p>
                </div>                
                <div id="qrbox">
                    <?php echo $code;
                    					//echo $generated;?>
                    	</div>				
                
                <br>
               <?php } ?>
               
            
        </div>
    </div>
</body>
</html>