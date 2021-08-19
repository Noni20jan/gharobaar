<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row m-b-30">


    <div class="col-sm-4">
        <div class="small-boxes-dashboard-earnings">
            <div class="small-boxes-dashboard">
                <div class="col-sm-12 col-xs-12 p-0">
                    <div class="small-box-dashboard">
                        <h3 class="total"><?= '₹' . round(($this->auth_user->balance) / 100, 2); ?></h3>
                        <span class="text-muted"><?= trans("total_earning"); ?></span>
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cash-stack" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 3H1a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1h-1z" />
                            <path fill-rule="evenodd" d="M15 5H1v8h14V5zM1 4a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1H1z" />
                            <path d="M13 5a2 2 0 0 0 2 2V5h-2zM3 5a2 2 0 0 1-2 2V5h2zm10 8a2 2 0 0 1 2-2v2h-2zM3 13a2 2 0 0 0-2-2v2h2zm7-4a2 2 0 1 1-4 0 2 2 0 0 1 4 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>








    <div class="col-sm-4">
        <div class="small-boxes-dashboard-earnings">
            <div class="small-boxes-dashboard">
                <div class="col-sm-12 col-xs-12 p-0">
                    <div class="small-box-dashboard">
                        <?php $penalty_details = $this->earnings_model->calculate_total_penalty_amount($this->auth_user->id); ?>
                        <?php if (!empty($penalty_details)) : ?>
                            <?php $sum_penalty = ($penalty_details->total_penalty) / 100; ?>
                            <h3 class="total"><?= '₹' . round($sum_penalty, 2) ?></h3>
                        <?php else : ?>
                            <h3 class="total"><?= '₹' . '0' ?></h3>
                        <?php endif; ?>
                        <span class="text-muted"><?= trans("total_penalty"); ?></span>
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cash-stack" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 3H1a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1h-1z" />
                            <path fill-rule="evenodd" d="M15 5H1v8h14V5zM1 4a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1H1z" />
                            <path d="M13 5a2 2 0 0 0 2 2V5h-2zM3 5a2 2 0 0 1-2 2V5h2zm10 8a2 2 0 0 1 2-2v2h-2zM3 13a2 2 0 0 0-2-2v2h2zm7-4a2 2 0 1 1-4 0 2 2 0 0 1 4 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>






    <div class="col-sm-4">
        <div class="small-boxes-dashboard-earnings" style="width: none !important;">
            <div class="small-boxes-dashboard">
                <div class="col-sm-12 col-xs-12 p-0">
                    <div class="small-box-dashboard">
                        <?php $penalty_details = $this->earnings_model->calculate_total_penalty_amount($this->auth_user->id); ?>
                        <?php if (!empty($penalty_details)) : ?>
                            <?php $sum_penalty = ($penalty_details->total_penalty) / 100;

                            $balance = ($this->auth_user->balance) - ($penalty_details->total_penalty);
                            $total_balance = $balance / 100; ?>

                            <h3 class="total"><?= '₹' . round($total_balance) ?></h3>
                        <?php else : ?>
                            <h3 class="total"><?= '₹' . round(($this->auth_user->balance) / 100, 2); ?></h3>
                        <?php endif; ?>
                        <span class="text-muted"><?= trans("balance"); ?></span>
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cash-stack" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 3H1a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1h-1z" />
                            <path fill-rule="evenodd" d="M15 5H1v8h14V5zM1 4a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1H1z" />
                            <path d="M13 5a2 2 0 0 0 2 2V5h-2zM3 5a2 2 0 0 1-2 2V5h2zm10 8a2 2 0 0 1 2-2v2h-2zM3 13a2 2 0 0 0-2-2v2h2zm7-4a2 2 0 1 1-4 0 2 2 0 0 1 4 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>