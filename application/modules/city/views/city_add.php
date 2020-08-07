<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>City </h2>
        <ol class="breadcrumb">
            <li>
                <a>City</a>
            </li>
            <li class="active">
                <strong>City add</strong>
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
                    <form id="form_city_save"  action="javascript:;" method="POST">
                        <div class="row">

                            <div class="form-group">
                                <label>State *</label>
                                <select name="StateId" id="StateId" class="form-control">
                                    <option value="">Select State</option>
                                <?php foreach ($states as $key => $state) {
                                ?>
                                    <option value="<?php echo $state['id']; ?>"><?php echo $state['StateName']; ?>
                                    </option>
                                <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>City Name *</label>
                                <input id="CityName" name="CityName" type="text" class="form-control required">
                            </div>

                            <div class="form-group col-lg-12">
                                <input type="hidden" id="<?=$csrfName;?>" name="<?=$csrfName;?>" value="<?=$csrfHash;?>" />
                                <input  name="submit" type="submit" class="btn btn-primary" >
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
