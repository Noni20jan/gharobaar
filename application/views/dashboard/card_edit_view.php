<?php echo form_open('dashboard_controller/edit_cards'); ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
        <h3>Edit Card</h3>
    </div>
    <div class="modal-body">
        
        <input type="hidden" name="card_id" value="<?php echo $card->id; ?>">
        <div class="form-group">
            <label for="email">Bank Name</label>
            <input type="text" value="<?php echo $card->bank_name; ?>" name="bank_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Card Type</label>

            <select name="card_type" id="card_type" class="form-control" required>
                <option value="" disabled selected>Select Account Type</option>
                <option value="Debit card" <?php echo ($card->card_type == "Debit card") ? 'selected' : ''; ?>>Debit card</option>
                <option value="Credit card" <?php echo ($card->card_type == "Credit card") ? 'selected' : ''; ?>>Credit card</option>
            </select>
        </div>
        <div class="form-group">
            <label for="email">Card Holder Name</label>
            <input type="text" name="card_holder_name"  required value="<?php echo $card->card_holder_name; ?>" class="form-control">
        </div>

        <div class="form-group">
            <label for="email">Card number</label>
            <input type="text" autocomplete="off"  required value="<?php echo $card->card_number; ?>" name="card_number" id="credit-card-number" class="form-control">
        </div>

        <div class="form-group">
            <label for="email">Expiry Date</label>
            <input onkeyup="$cc.expiry.call(this,event)" required value="<?php echo $card->card_expiry_date; ?>" name="card_expiry_date" class="form-control" maxlength="7" placeholder="mm/yyyy">

        </div>
      

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>


        <button type="submit" name="submit" class="btn btn-success">Save Card</button>
    </div>
    <?php echo form_close(); ?>