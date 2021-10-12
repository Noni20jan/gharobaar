<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    @media (max-width: 768px) {
        .supplier_criteria {
            width: 400px;
        }

        .buyer_criteria {
            width: 400px;
        }
    }

    tr th {
        background-color: #4472C4;
        color: white;
        text-align: center;
    }

    td {
        font-weight: 600;
    }

    .table>thead>tr>th,
    .table>tbody>tr>th,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>tbody>tr>td,
    .table>tfoot>tr>td {
        border: 2px solid #f4f4f4 !important;
        vertical-align: middle;
    }

    .table-content {
        overflow-x: auto;
    }

    .medal {
        width: 200px;
    }
</style>

<?php var_dump($lp_user_data); ?>

<div class="content">

    <div>
        <?php
        $img = "";
        switch ($lp_user_data->lp_qualified_program):
            case "BRONZE":
                $img = "bronze.png";
                break;
            case "SILVER":
                $img = "silver.png";
                break;
            case "GOLD":
                $img = "gold.png";
                break;
            case "PLATINUM":
                $img = "platinum.png";
                break;
        endswitch;
        ?>
        <img class="medal" src="<?php echo base_url() ?>assets\img\<?php echo $img; ?>">
    </div>

    <div class="img">
        <h3>Supplier Loyalty Criteria</h3>
        <div class="table-content">
            <table class="table" style="text-align: center;">
                <tr>
                    <th style="width: 280px;">Qualifying criteria</th>
                    <th>Weightage</th>
                    <th>Bronze</th>
                    <th>Silver</th>
                    <th>Gold</th>
                    <th>Platinum</th>
                </tr>
                <tr>
                    <th style="text-align: left;">Metrics/KPIs</th>
                    <td>70 %</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th>Absolute Sales</th>
                    <td>50 %</td>
                    <td>
                        < 1 lakh</td>
                    <td>1-2 lakhs</td>
                    <td>2-5 lakhs</td>
                    <td>>5 lakhs</td>
                </tr>
                <tr>
                    <th>Achievement of target versus actual number for other KPIs such as active customers, reviews, complaint resolution, average ticket size</th>
                    <td>30 %</td>
                    <td>
                        < 75%</td>
                    <td>75-90%</td>
                    <td>90-110%</td>
                    <td>>100%</td>
                </tr>
                <tr>
                    <th>Absolute no. of new customers</th>
                    <td>20 %</td>
                    <td>0-50</td>
                    <td>50-100</td>
                    <td>100-200</td>
                    <td>>200</td>
                </tr>
                <tr>
                    <th style="text-align: left;">Alignment with platform theme</th>
                    <td>5 %</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th>- Scale of operation</th>
                    <td>33.33 %</td>
                    <td>
                        >20 lakhs</td>
                    <td>10-20 lakhs</td>
                    <td>5-10 lakhs</td>
                    <td>
                        < 5 lakhs</td>
                </tr>
                <tr>
                    <th>- Working from home</th>
                    <td>33.33 %</td>
                    <td>N</td>
                    <td>N</td>
                    <td>Y</td>
                    <td>Y</td>
                </tr>
                <tr>
                    <th>- Story (use keyword search)</th>
                    <td>33.33 %</td>
                    <td>Low</td>
                    <td>Medium</td>
                    <td>High</td>
                    <td>Very High</td>
                </tr>
                <tr>
                    <th>Exclusivity</th>
                    <td>10 %</td>
                    <td>Optional</td>
                    <td>Optional</td>
                    <td>Optional</td>
                    <td>Mandatory</td>
                </tr>
                <tr>
                    <th>Paid Service</th>
                    <td>10 %</td>
                    <td>
                        < 1000</td>
                    <td>1-3k</td>
                    <td>3-5k</td>
                    <td>> 5k</td>
                </tr>
                <tr>
                    <th>Gharobaar Promotion</th>
                    <td>5 %</td>
                    <td>N</td>
                    <td>1 platform</td>
                    <td>2 platforms</td>
                    <td>>2 platform</td>
                </tr>
            </table>
        </div>
    </div>


    <div class="img">
        <h3>Buyer Loyalty Criteria</h3>
        <div class="table-content">
            <table class="table" style="text-align: center;">
                <tr>
                    <th style="width: 280px;">Qualifying criteria</th>
                    <th>Weightage</th>
                    <th>Bronze</th>
                    <th>Silver</th>
                    <th>Gold</th>
                    <th>Platinum</th>
                </tr>
                <tr>
                    <th>Monthly transaction value</th>
                    <td>50 %</td>
                    <td>
                        < 3000</td>
                    <td>3-6k</td>
                    <td>6-10k</td>
                    <td>> 10k</td>
                </tr>
                <tr>
                    <th>Paid subscriptions</th>
                    <td>25 %</td>
                    <td>0-200</td>
                    <td>200-500</td>
                    <td>500-1000</td>
                    <td>> 1000</td>
                </tr>
                <tr>
                    <th>Gharobaar Promotion</th>
                    <td>10 %</td>
                    <td>N</td>
                    <td>1 platform</td>
                    <td>2 platforms</td>
                    <td>>2 platform</td>
                </tr>
                <tr>
                    <th>New buyer reference onboarding</th>
                    <td>5 %</td>
                    <td>
                        < 5</td>
                    <td>5-10</td>
                    <td>10-20</td>
                    <td>> 20</td>
                </tr>
                <tr>
                    <th>Business from buyer references</th>
                    <td>5 %</td>
                    <td>
                        < 3000</td>
                    <td>3-6k</td>
                    <td>6-10k</td>
                    <td>> 10k</td>
                </tr>
                <tr>
                    <th>No. of product categories purchased</th>
                    <td>5 %</td>
                    <td>1</td>
                    <td>1-3</td>
                    <td>3-5</td>
                    <td>> 5</td>
                </tr>
            </table>
        </div>
    </div>
</div>