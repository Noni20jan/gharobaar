<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div id="wrapper" class="index-wrapper">
    <div class="container">

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">title</th>
                    <th scope="col">Remark</th>
                    <th scope="col">date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row"><?php echo $notifications->id; ?></th>
                    <td><?php echo $notifications->title; ?></td>
                    <td><?php echo $notifications->remark; ?></td>
                    <td><?php echo $notifications->publish_date; ?></td>
                </tr>
                <!-- <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td colspan="2">Larry the Bird</td>
                    <td>@twitter</td>
                </tr> -->
            </tbody>
        </table>
    </div>
</div>