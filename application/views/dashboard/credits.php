
<?php $cards = get_user_cards($user->id); ?>
<style>
    :root {
        font-size: 24px;
    }



    /* Background circles start */

    /* Background circles end */

    .card-group {
        margin-top: 100px;
        margin-left: 500px;
      
      
        transform: translate(-50%, -50%);
    }

    .card {
        position: relative;
        height: 270px;
        width: 450px;
        border-radius: 25px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(30px);
        border: 2px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 0 80px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }

    .logo img,
    .chip img,
    .number,
    .name,
    .from,
    .to,
    .ring {
        position: absolute;
        /* All items inside card should have absolute position */
    }

    .logo img {
        top: 35px;
        right: 40px;
        width: 80px;
        height: auto;
        opacity: 0.8;
    }

    .chip img {
        top: 120px;
        left: 40px;
        width: 50px;
        height: auto;
        opacity: 0.8;
    }

    .number,
    .name,
    .from,
    .to {
        color: #000;
        font-weight: 400;
        letter-spacing: 2px;
        text-shadow: 0 0 2px rgba(0, 0, 0, 0.6);

    }

    .number {
        left: 40px;
        bottom: 65px;
        font-family: "Nunito", sans-serif;
    }

    .name {
        font-size: 0.5rem;
        left: 40px;
        bottom: 35px;
    }

    .from {
        font-size: 0.5rem;
        bottom: 35px;
        right: 110px;
    }

    .to {
        font-size: 0.5rem;
        bottom: 35px;
        right: 40px;
    }

    /* The two rings on the card background */
    .ring {
        height: 500px;
        width: 500px;
        border-radius: 50%;
        background: transparent;
        border: 50px solid rgba(255, 255, 255, 0.1);
        bottom: -250px;
        right: -250px;
        box-sizing: border-box;
    }

    .ring::after {
        content: "";
        position: absolute;
        height: 600px;
        width: 600px;
        border-radius: 50%;
        background: transparent;
        border: 30px solid rgba(255, 255, 255, 0.1);
        bottom: -80px;
        right: -110px;
        box-sizing: border-box;
    }
</style>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400&display=swap" rel="stylesheet">
<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">

            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 m-b-30 groove">
      
                    <?php if (!empty($cards)) : ?>
                                    <?php foreach ($cards as $card) : ?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm">

                                    <div class="card-group">
                                        <div class="card">
                                            <div class="logo"><img src="https://raw.githubusercontent.com/dasShounak/freeUseImages/main/Visa-Logo-PNG-Image.png" alt="Visa"></div>
                                            <div class="chip"><img src="https://raw.githubusercontent.com/dasShounak/freeUseImages/main/chip.png" alt="chip"></div>
                                            <div class="number"><?php echo $card->card_number; ?></div>
                                            <div class="name"><?php echo $card->card_holder_name; ?></div>
                                            <div class="from">Valid upto</div>
                                            <div class="to"><?php echo $card->card_expiry_date; ?></div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; endif ; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>