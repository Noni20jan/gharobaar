<style>
    .expected_date_time {
        font-family: 'Montserrat';
        margin-bottom: 5px;
        font-weight: 600;
        font-size: 1rem;
    }

    #transit {
        position: relative;
    }

    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        border: 0;
    }

    .fa+.sr-only {
        padding: 0.25em;
        margin: 0;
        color: #000;
        background: #eee;
        border: 1px solid #ccc;
        border-radius: 2px;
        font: 11px sans-serif;
        z-index: 2;
    }

    #transit:focus .fa+.sr-only,
    #transit:hover .fa+.sr-only {
        clip: auto;
        width: auto;
        height: auto;
        bottom: 100%;
        left: 100%;
    }
</style>

<link href='<?php echo base_url(); ?>assets/css/jquery-ui.min.css' rel='stylesheet' type='text/css'>
<script src='<?php echo base_url(); ?>assets/admin/js/jquery.min.js' type='text/javascript'></script>
<script src='<?php echo base_url(); ?>assets/admin/js/jquery-ui.min.js' type='text/javascript'></script>

<script src="<?php echo base_url(); ?>assets/js/bootstrap-notify.js"></script>
        <?php
        $avail = $product->availability;
        $avail_days_array = array();
        if ($avail != "All days") {
            $avail_days = explode(",", $avail);
            foreach ($avail_days as $day) {
                switch ($day) {
                    case "Sunday":
                        array_push($avail_days_array, 0);
                        break;
                    case "Monday":
                        array_push($avail_days_array, 1);
                        break;
                    case "Tuesday":
                        array_push($avail_days_array, 2);
                        break;
                    case "Wednesday":
                        array_push($avail_days_array, 3);
                        break;
                    case "Thursday":
                        array_push($avail_days_array, 4);
                        break;
                    case "Friday":
                        array_push($avail_days_array, 5);
                        break;
                    case "Saturday":
                        array_push($avail_days_array, 6);
                        break;
                }
            }
        } else {
            $avail_days_array = [0, 1, 2, 3, 4, 5, 6];
        }

        $time_types = get_lookup_values_by_type("EXPECTED_DELIVERY_TIME_TYPE");
        $selected_delivery_date = date('d/m/Y', time() + get_transit_time_for_home_cook($product, "time"));
        $selected_day = date('w', time() + get_transit_time_for_home_cook($product, "time"));

        $start_date = strtotime(date('Y-m-d', time() + get_transit_time_for_home_cook($product, "time")));
        $i = 1;
        while (!in_array($selected_day, $avail_days_array)) {
            $time = 86400 * $i;
            $selected_delivery_date = date('d/m/Y', $start_date + $time);
            $selected_day = date('w', $start_date + $time);
            $i++;
        }
        ?>
        <div class="row">
            <div class="col-sm-6">
                <?php //var_dump(get_transit_time_for_home_cook($product));
                ?>
                <label class="control-label expected_date_time">Delivery Date<span class="Validation_error"> *</span></label>
                <input type="text" id="expected_delivery_date" name="expected_delivery_date" value="<?php echo $selected_delivery_date; ?>" class="form-control auth-form-input datepick" onkeypress="return nothingReturn(event)">
                <!-- <input type="text" name="expected_delivery_date" class="form-control auth-form-input datepick" placeholder="dd-mm-yyyy" onkeypress="return nothingReturn(event)" required> -->
                <div style="margin:10px 0 5px 0;">
                    <span><b>Lead Time <a id="transit" href="javascript:void(0);"><i class="fa fa-info-circle" aria-hidden="true"></i>
                                <p class="sr-only">Lead Time means the time a product would take to be <br>ready for dispatch.</p>
                            </a></i></b></span>
                    <span class="lead_time">:<?php echo get_transit_time_for_home_cook($product, "string"); ?></span>
                </div>
            </div>
            <div class="col-sm-6">
                <label class="control-label expected_date_time">Delivery Time<span class="Validation_error"> *</span></label>
                <select name="expected_delivery_time" id="expected_delivery_time" class="form-control auth-form-input" required>
                    <option value="" disabled selected>Select Delivery Time</option>
                    <?php foreach ($time_types as $time_type) : ?>
                        <option value="<?= ucfirst($time_type->lookup_code); ?>"><?= ucfirst($time_type->lookup_code); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
<script type='text/javascript'>
    var avail_days_array = JSON.parse("<?php echo json_encode($avail_days_array); ?>");
    $(document).ready(function() {
        // Number
        $('#expected_delivery_date').datepicker({
            dateFormat: "dd/mm/yy",
            setDate: new Date('<?php echo date('Y,m,d', time() + get_transit_time_for_home_cook($product, "time")) ?>'),
            minDate: new Date('<?php echo date('Y-m-d', time() + get_transit_time_for_home_cook($product, "time")) ?>'),
            changeYear: true,
            changeMonth: true,
            beforeShowDay: function(d) {
                var day = d.getDay();
                return [(avail_days_array.includes(day))];
            }
        });

    });
</script>