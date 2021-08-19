<?php echo form_open('dashboard_controller/edit_addresses'); ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
    <h3>Edit Address</h3>
</div>
<div class="modal-body">
    <div class="row">
        
        <input type="hidden" name="address_id" value="<?php echo $address->id; ?>">
        <div class="form-group col-md-6">
            <label for="email">Full name (First and Last name)</label>
            <input type="text" value="<?php echo $address->f_name; ?>" name="full_name" class="form-control">
        </div>
        <div class="form-group col-md-6">
            <label for="email">Email</label>
            <input type="text" value="<?php echo $address->email; ?>" name="email" class="form-control">
        </div>

        <div class="form-group col-md-6">
            <label for="email">Mobile number</label>
            <input type="number" name="mobile_number" maxlength="10" value="<?php echo $address->ph_number; ?>" class="form-control">
        </div>

        <div class="form-group col-md-6">
            <label for="email">PIN code</label>
            <input type="number" autocomplete="off" value="<?php echo $address->zip_code; ?>" name="pin_code" class="form-control">
        </div>

        <div class="form-group col-md-6">
            <label for="email">Flat, House no., Building, Company, Apartment</label>
            <input name="house_number"  <?php echo $address->h_no; ?> class="form-control">

        </div>
        <div class="form-group col-md-6">
            <label for="email">Area, Colony, Street, Sector, Village</label>
            <input type="text" value="<?php echo $address->area; ?>" name="area" class="form-control">
        </div>
        <div class="form-group col-md-6">
            <label for="email">Landmark</label>
            <input type="text" value="<?php echo $address->landmark; ?>" name="landmark" class="form-control">
        </div>
        <div class="form-group col-md-6">
            <label for="email">Town/City</label>
            <input type="text" value="<?php echo $address->city; ?>" name="city" class="form-control">
        </div>
        <div class="form-group col-md-6">
            <label for="email">State / Province / Region</label>
            <input type="text" value="<?php echo $address->state; ?>" name="state" class="form-control">
        </div>
        <div class="form-group col-md-6">
            <label for="email">Address Type</label>

            <select name="address_type" id="address_type" class="form-control" required>
                <option value="" disabled selected>Select Address Type</option>
                <option value="Home(7 am 9 pm delivery)" <?php echo ($address->address_type == "Home(7 am 9 pm delivery)") ? 'selected' : ''; ?>>Home(7 am 9 pm delivery)</option>
                <option value="Office/commercial (10 am 6 pm delivery)" <?php echo ($address->address_type == "Office/commercial (10 am 6 pm delivery)") ? 'selected' : ''; ?>>Office/commercial (10 am 6 pm delivery)</option>
            </select>
        </div>
 
      
 
 
 
 
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-custom" data-dismiss="modal">Close</button>
    <button type="submit" name="submit" class="btn btn-success">Save Address</button>
</div>
<?php echo form_close(); ?>