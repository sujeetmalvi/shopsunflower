<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Retailer </h2>
        <ol class="breadcrumb">
            <li>
                <a>Retailer</a>
            </li>
            <li class="active">
                <strong>Retailer Edit</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
    </div>
</div>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <!-- <h5>All form elements <small>With custom checbox and radion elements.</small></h5> -->
                </div>
                <div class="ibox-content">
                    <form id="form_retailer_update"  action="javascript:;" method="POST">
                        <div class="row">

                            <div class="form-group">
                                <label>State *</label>
                                <select name="StateId" id="StateId" class="form-control" onchange="get_citylist(this.value);">
                                    <option value="">Select State</option>
                                <?php foreach ($states as $key => $state) {
                                    if($details['StateId']==$state['id']){
                                        $Stateselected = "selected='selected'";
                                    }else{
                                        $Stateselected = "";
                                    }
                                ?>
                                    <option value="<?php echo $state['id']; ?>" <?php echo $Stateselected;?>><?php echo $state['StateName']; ?>
                                    </option>
                                <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>City *</label>
                                <select name="CityId" id="CityId" class="form-control">
                                 <?php foreach ($cities as $key => $city) {
                                    if($details['CityId']==$city['id']){
                                        $Cityselected = "selected='selected'";
                                    }else{
                                        $Cityselected = "";
                                    }
                                ?>
                                    <option value="<?php echo $city['id']; ?>" <?php echo $Cityselected;?>><?php echo $city['CityName']; ?>
                                    </option>
                                <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Retailer Name *</label>
                                <input id="RetailerName" name="RetailerName" type="text" class="form-control required" value="<?php echo $details['RetailerName'];?>">
                            </div>

                            <div class="form-group col-lg-12">
                                <input type="hidden" id="<?=$csrfName;?>" name="<?=$csrfName;?>" value="<?=$csrfHash;?>" />
                                <input type="hidden" name="RetailerId"  value="<?php echo $details['id'];?>">
                                <input  name="submit" type="submit" class="btn btn-primary" >
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
