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
                                <label>Retailer Name *</label>
                                <input id="RetailerName" name="RetailerName" type="text" class="form-control required" value="<?php echo $details['RetailerName'];?>">
                            </div>
                            
				<div class="form-group">
                                    <label>Retailer Contact No *</label>
                                    <input id="RetailerContactNo" name="RetailerContactNo"  value="<?php echo $details['RetailerContactNo'];?>" type="text" class="form-control required">
                                </div>

                                <div class="form-group">
                                    <label>Retailer Email </label>
                                    <input id="RetailerEmail" name="RetailerEmail" type="text"  value="<?php echo $details['RetailerEmail'];?>" class="form-control required">
                                </div>

                                <div class="form-group"  style="display: none;">
                                    <label>Category  *</label>
                                    <input id="CategoryId" name="CategoryId" type="text"  value="<?php echo $details['CategoryId'];?>" class="form-control required">
                                </div>
                                <div class="form-group">
                                    <label>Address *</label>
                                    <input id="Address" name="Address" type="text"  value="<?php echo $details['Address'];?>" class="form-control required">
                                </div>

                            <div class="form-group">
                                <label>State *</label>
                                <select name="StateId" id="StateId" class="form-control"  onchange="get_citylist(this.value);">
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
                                <select name="CityId" id="CityId" onchange="get_stockist_by_city_id(this.value);" class="form-control">
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
                                    <label>Stockist *</label>
                                    <?php $stockist=$this->stockist_model->get_all_stockist($details['CityId']);
                                    
                                     ?>
                                    <select name="StockistId" id="StockistId" class="form-control">
                                    <?php foreach ($stockist as $key => $stock)
                                    {
                                    if($details['StockistId']==$stock['id']){
                                        $Stockistselected = "selected='selected'";
                                    }else{
                                        $Stockistselected = "";
                                    }
                                ?>
                                        <option value="">Select Stockist</option>
                                        <option value="<?php echo $stock['id']; ?>" <?php echo $Stockistselected;?>><?php echo $stock['StockistName']; ?>
                                    </option>
                                <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Contact Person *</label>
                                    <input id="ContactPerson"  value="<?php echo $details['ContactPerson'];?>" name="ContactPerson" type="text" class="form-control required">
                                </div>

                                <div class="form-group">
                                    <label>Contact Mobile *</label>
                                    <input id="ContactMobile"  value="<?php echo $details['ContactMobile'];?>" name="ContactMobile" type="text" class="form-control required">
                                </div>

                                <div class="form-group">
                                    <label>Contact Email </label>
                                    <input id="ContactEmail"  value="<?php echo $details['ContactEmail'];?>" name="ContactEmail" type="text" class="form-control required">
                                </div>

                                <div class="form-group">
                                    <label>Pan No </label>
                                    <input id="PanNo" name="PanNo"  value="<?php echo $details['PanNo'];?>" type="text" class="form-control required">
                                </div>

                                <div class="form-group">
                                    <label>Tin No </label>
                                    <input id="TinNo" name="TinNo"  value="<?php echo $details['TinNo'];?>" type="text" class="form-control required">
                                </div>

                                <div class="form-group">
                                    <label>DL No </label>
                                    <input id="DLNo" name="DLNo"  value="<?php echo $details['DLNo'];?>" type="text" class="form-control required">
                                </div>

                                <div class="form-group">
                                    <label>LST No </label>
                                    <input id="LSTNo" name="LSTNo"  value="<?php echo $details['LSTNo'];?>" type="text" class="form-control required">
                                </div>

                                <div class="form-group">
                                    <label>GST No </label>
                                    <input id="CSTNo" name="CSTNo"  value="<?php echo $details['CSTNo'];?>" type="text" class="form-control required">
                                </div>

                                <div class="form-group">
                                    <label>TAN No </label>
                                    <input id="TANNo" name="TANNo"  value="<?php echo $details['TANNo'];?>" type="text" class="form-control required">
                                </div>
                                

                                <div class="form-group">
                                    <label>Credit Days </label>
                                    <input id="CreditDays"  value="<?php echo $details['CreditDays'];?>" name="CreditDays" type="text" class="form-control required">
                                </div>

                                <div class="form-group">
                                    <label>Credit Limit </label>
                                    <input id="CreditLimit"  value="<?php echo $details['CreditLimit'];?>" name="CreditLimit" type="text" class="form-control required">
                                </div>

                                <div class="form-group">
                                    <label>Transporter *</label>
                                    <input id="Transporter"  value="<?php echo $details['Transporter'];?>" name="Transporter" type="text" class="form-control required">
                                </div>

                                <div class="form-group" style="display: none;">
                                    <label>Party Code </label>
                                    <input id="PartyCode"   name="PartyCode" type="text" class="form-control required">
                                </div>

                                <div class="form-group" style="display: none;">
                                    <label>Party Group </label>
                                    <input id="PartyGroup"  name="PartyGroup" type="text" class="form-control required">
                                </div>

                                <div class="form-group" style="display: none;">
                                    <label>Under A/c Group </label>
                                    <input id="UnderAcGroup"  name="UnderAcGroup" type="text" class="form-control required">
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
