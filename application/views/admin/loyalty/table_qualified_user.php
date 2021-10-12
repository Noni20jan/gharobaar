<table id="offer_dashboard" class="display" style="width:100%">
    <thead>
        <tr>
            <th>User</th>
            <th>Bronze</th>
            <th>Sliver</th>
            <th>Gold</th>
            <th>Platinum</th>
            <th>View</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $qUser) :
            $user = get_user($qUser->user_id);
        ?>
            <tr class="text-center">
                <td><?php echo $user->first_name . " " . $user->last_name; ?></td>
                <td><i class="fa <?php echo $qUser->lp_qualified_value == 1 ? 'fa-check color-check' : 'fa-times cross-color'; ?>" aria-hidden="true"></i></td>
                <td><i class="fa <?php echo $qUser->lp_qualified_value == 2 ? 'fa-check color-check' : 'fa-times cross-color'; ?>" aria-hidden="true"></i></td>
                <td><i class="fa <?php echo $qUser->lp_qualified_value == 3 ? 'fa-check color-check' : 'fa-times cross-color'; ?>" aria-hidden="true"></i></td>
                <td><i class="fa <?php echo $qUser->lp_qualified_value == 4 ? 'fa-check color-check' : 'fa-times cross-color'; ?>" aria-hidden="true"></i></td>
                <td><a href="<?php echo (admin_url() . 'qualified-user-details/' . $qUser->id); ?>" style="text-decoration: underline; color:blue !important">Details</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>