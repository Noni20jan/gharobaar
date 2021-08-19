<style>
    #error_404 {
        width: 75%;
        padding-bottom: 19%;
    }

    .error-text {
        font-size: 62px;
        padding-top: 9%;
        /* font-weight: bolder; */
        font-family: 'Montserrat';
        text-align: right;

    }


    .error404 {
        padding-top: 10%;
    }


    @media (max-width: 500px) {
        .error-text {
            font-size: 30px;
            padding-top: 0%;
            /* font-weight: bolder; */
            font-family: 'Montserrat';
            text-align: center;
        }
    }
</style>

<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Section: main -->
<div id="wrapper1">
    <section id="main">
        <div class="container">
            <div class="row error404">
                <div class="col-md-6">
                    <img id="error_404" src="assets/img/error404.png" class="img-responsive image1">
                </div>
                <div class="col-md-6">
                    <h2 class="error-text">the requested <b>URL</b> was <b>not found</b> on this server</h2>
                </div>
            </div>
        </div>
        <div class="text-auto">
            <a class="btn btn-lg btn-custom" href="<?php echo lang_base_url(); ?>"><?php echo trans("goto_home"); ?></a>
        </div>
</div>
</section>
<!-- /.Section: main -->